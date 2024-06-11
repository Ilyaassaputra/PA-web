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

        try {

            // Dapatkan data tagihan
            $tagihan = DataTagihan::findOrFail($data['id']);

            // Buat objek DataPembayaran
            $pembayaran = new DataPembayaran();
            $pembayaran->tagihan_id = $data['id'];
            $pembayaran->jenis_tagihan_id = $tagihan->jenis_tagihan_id;
            $pembayaran->nominal_tagihan = $tagihan->nominal_tagihan;
            $pembayaran->metode = $request->metode;
            // Simpan pembayaran
            $pembayaran->save();

            // Perbarui status tagihan menjadi "Sudah Bayar"
            $tagihan->status_pembayaran = 'Sudah Bayar';
            $tagihan->save();
            $data['message'] = true;
            return response()->json([
                'message' => $data['message']
            ]);
        } catch (\Throwable $th) {
            $data['message'] = $th->getMessage();
            return response()->json([
                'message' => $data['message']
            ]);
        }
    }
}
