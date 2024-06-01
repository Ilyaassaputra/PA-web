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
        // $data = $request->all();
        // dd($data, $tagihanId);
        $request->validate([
            'metode' => 'required', // Pastikan metode pembayaran terisi
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,pdf|max:2048', // Buat bukti_pembayaran opsional
        ]);

        // Dapatkan data tagihan
        $tagihan = DataTagihan::findOrFail($tagihanId);

        // Buat objek DataPembayaran
        $pembayaran = new DataPembayaran();
        $pembayaran->tagihan_id = $tagihanId;
        $pembayaran->jenis_tagihan_id = $tagihan->jenis_tagihan_id;
        $pembayaran->nominal_tagihan = $tagihan->nominal_tagihan;
        $pembayaran->metode = $request->metode;

        // Simpan bukti pembayaran jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            $pembayaran->bukti_pembayaran = $filePath;
        }

        // Simpan pembayaran
        $pembayaran->save();

        // Perbarui status tagihan menjadi "Sudah Bayar"
        $tagihan->status_pembayaran = 'Sudah Bayar';
        $tagihan->save();

        // Redirect atau response sesuai kebutuhan
        Alert::success('Pembayaran Berhasil');
        return redirect()->back();
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
