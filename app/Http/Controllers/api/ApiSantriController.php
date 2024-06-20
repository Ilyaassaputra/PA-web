<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DataPembayaran;
use App\Models\DataSantri;
use App\Models\DataTagihan;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ApiSantriController extends Controller
{
    public function getDataSantriByNamed(Request $request)
    {

        $data['message'] = false;

        try {
            $data['data'] = DataSantri::with('tagihans')->where('nama', 'like', '%' . $request->nama_santri . '%')->get();

            $data['message'] = true;
            return response()->json([
                'data' => $data['data'],
                'message' => $data['message']
            ]);
        } catch (\Throwable $th) {
            $data['message'] = $th->getMessage();
            return response()->json([
                'data' => $data['data'],
                'message' => $data['message']
            ]);
        }
    }
    public function getDataSantriById(Request $request)
    {

        $data['message'] = false;

        try {
            $data['data'] = DataSantri::with('tagihans')->where('id', $request->id)->first();

            $data['message'] = true;
            return response()->json([
                'data' => $data['data'],
                'message' => $data['message']
            ]);
        } catch (\Throwable $th) {
            $data['message'] = $th->getMessage();
            return response()->json([
                'data' => $data['data'],
                'message' => $data['message']
            ]);
        }
    }

    public function bayar(Request $request)
    {
        $data = $request->all();
        $data['message'] = false;

        // Validasi input
        $request->validate([
            'metode' => 'required',
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'jumlah_dibayar' => 'required_if:metode,Cicil|nullable|numeric|min:1',
        ]);

        try {
            // Dapatkan data tagihan
            $tagihan = DataTagihan::findOrFail($data['id']);

            // Tangani pembayaran cicilan
            if ($request->metode == 'Cicil') {
                $jumlah_dibayar = $request->input('jumlah_dibayar');

                // Hitung total pembayaran yang sudah dilakukan terhadap tagihan
                $total_pembayaran = $tagihan->pembayaran()->sum('jumlah_dibayar');

                // Hitung sisa pembayaran
                $sisa_pembayaran = $tagihan->nominal_tagihan - $total_pembayaran - $jumlah_dibayar;

                // Pastikan sisa pembayaran tidak minus
                if ($sisa_pembayaran < 0) {
                    $sisa_pembayaran = 0;
                }

                // Buat objek DataPembayaran
                $pembayaran = new DataPembayaran();
                $pembayaran->tagihan_id = $data['id'];
                $pembayaran->jenis_tagihan_id = $tagihan->jenis_tagihan_id;
                $pembayaran->nominal_tagihan = $tagihan->nominal_tagihan;
                $pembayaran->metode = $request->metode;
                $pembayaran->jumlah_dibayar = $jumlah_dibayar;
                $pembayaran->sisa_pembayaran = $sisa_pembayaran;

                // Simpan bukti pembayaran jika ada
                if ($request->hasFile('bukti_pembayaran')) {
                    $file = $request->file('bukti_pembayaran');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
                    $pembayaran->bukti_pembayaran = $filePath;
                }

                // Simpan pembayaran cicilan
                $pembayaran->save();

                // Perbarui status tagihan
                if ($sisa_pembayaran <= 0) {
                    $tagihan->status_pembayaran = 'Sudah Bayar';
                } else {
                    $tagihan->status_pembayaran = 'Cicilan';
                }

                $tagihan->save();
                $data['message'] = true;
                return response()->json([
                    'message' => 'Pembayaran Cicilan Berhasil',
                    'data' => $data,
                ]);
            } else {
                // Tangani pembayaran penuh
                $pembayaran = new DataPembayaran();
                $pembayaran->tagihan_id = $data['id'];
                $pembayaran->jenis_tagihan_id = $tagihan->jenis_tagihan_id;
                $pembayaran->nominal_tagihan = $tagihan->nominal_tagihan;
                $pembayaran->metode = $request->metode;
                $pembayaran->jumlah_dibayar = $tagihan->nominal_tagihan;
                $pembayaran->sisa_pembayaran = 0;

                // Simpan bukti pembayaran jika ada
                if ($request->hasFile('bukti_pembayaran')) {
                    $file = $request->file('bukti_pembayaran');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
                    $pembayaran->bukti_pembayaran = $filePath;
                }

                // Simpan pembayaran penuh
                $pembayaran->save();

                // Perbarui status tagihan menjadi "Sudah Bayar"
                $tagihan->status_pembayaran = 'Sudah Bayar';
                $tagihan->save();
                $data['message'] = true;
                return response()->json([
                    'message' => 'Pembayaran Penuh Berhasil',
                    'data' => $data,
                ]);
            }
        } catch (\Throwable $th) {
            $data['message'] = $th->getMessage();
            return response()->json([
                'message' => $data['message']
            ]);
        }
    }

}
