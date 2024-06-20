<?php

namespace App\Http\Controllers;

use App\Models\DataSantri;
use App\Models\DataTagihan;
use Illuminate\Http\Request;
use App\Models\DataPembayaran;
use RealRashid\SweetAlert\Facades\Alert;

class DataPembayaranController extends Controller
{

    public function showBayarForm($tagihanId)
    {
        $dataTagihan = DataTagihan::findOrFail($tagihanId);

        return view('santri.pembayaran', compact('dataTagihan'));
    }

    public function bayar(Request $request, $tagihanId)
    {
        $request->validate([
            'metode' => 'required',
            'bukti_transfer' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'jumlah_dibayar' => 'required_if:metode,Cicil|nullable|numeric|min:1',
        ]);

        // Dapatkan data tagihan
        $tagihan = DataTagihan::findOrFail($tagihanId);

        // Handle metode pembayaran Cicil
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
            $pembayaran->tagihan_id = $tagihanId;
            $pembayaran->jenis_tagihan_id = $tagihan->jenis_tagihan_id;
            $pembayaran->nominal_tagihan = $tagihan->nominal_tagihan;
            $pembayaran->metode = $request->metode;
            $pembayaran->jumlah_dibayar = $jumlah_dibayar;
            $pembayaran->sisa_pembayaran = $sisa_pembayaran;

            // Simpan bukti pembayaran jika ada
            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('bukti_transfer', $fileName, 'public');
                $pembayaran->bukti_transfer = $filePath;
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

            // Redirect atau response sesuai kebutuhan
            Alert::success('Pembayaran Berhasil');
            return redirect()->back();
        } else {
            // Handle pembayaran penuh
            $pembayaran = new DataPembayaran();
            $pembayaran->tagihan_id = $tagihanId;
            $pembayaran->jenis_tagihan_id = $tagihan->jenis_tagihan_id;
            $pembayaran->nominal_tagihan = $tagihan->nominal_tagihan;
            $pembayaran->metode = $request->metode;
            $pembayaran->jumlah_dibayar = $tagihan->nominal_tagihan;
            $pembayaran->sisa_pembayaran = 0;

            // Simpan bukti pembayaran jika ada
            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('bukti_transfer', $fileName, 'public');
                $pembayaran->bukti_transfer = $filePath;
            }

            // Simpan pembayaran penuh
            $pembayaran->save();

            // Perbarui status tagihan menjadi "Sudah Bayar"
            $tagihan->status_pembayaran = 'Sudah Bayar';
            $tagihan->save();

            // Redirect atau response sesuai kebutuhan
            Alert::success('Pembayaran Berhasil');
            return redirect()->back();
        }
    }








    // public function index()
    // {
    //     $data_santri = DataSantri::all();
    //     $dataPembayaran = DataPembayaran::all();

    //     $dataTagihan = DataTagihan::all();
    //     return view('pembayaran', compact('dataPembayaran', 'dataTagihan', 'data_santri'));
    // }

    // public function create()
    // {
    //     $dataTagihan = DataTagihan::all();

    //     return view('data_pembayaran.create', compact('dataTagihan'));
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'tagihan_id' => 'required',
    //         'bulan' => 'required',
    //         'nominal_tagihan' => 'required|numeric',
    //         'metode' => 'required',
    //         'bukti_transfer' =>'required',
    //         'status' => 'required',

    //     ]);

    //     $santriId = $request->input('santri_id'); // Pastikan Anda mengganti ini sesuai kebutuhan

    //     DataPembayaran::create([
    //         'santri_id' => $santriId,
    //         'tagihan_id' => $request->tagihan_id,
    //         'bulan' => $request->bulan,
    //         'nominal_tagihan' => $request->nominal_tagihan,
    //         'metode' => $request->metode,
    //         'bukti_transfer' => $request->file('bukti_transfer')->store('bukti_transfer', 'public'),
    //         'status' => 1, // default status
    //     ]);

    //     return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    // }

}
