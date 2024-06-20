<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataSantri;
use App\Models\DataTagihan;
use App\Models\ListSekolah;
use App\Models\JenisTagihan;

use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use App\Models\DataPembayaran;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use function PHPUnit\Framework\returnSelf;

class SantriController extends Controller
{
    public function profile()
    {
        $data_pendaftars = DataPendaftar::where('user_id', auth()->id())->first();

        if (!$data_pendaftars) {
            // Handle the case when there is no data_pendaftars found
            return redirect()->back()->withErrors('Data pendaftar tidak ditemukan.');
        }

        $user = User::where('id', $data_pendaftars->user_id)->first();
        $santris = DataSantri::where('data_pendaftar_id', $data_pendaftars->id)->get(); // Ambil data santri yang sesuai dengan data pendaftar
        $daftarSekolah = ListSekolah::all();

        $dataTagihan = collect(); // Default to an empty collection

        if ($santris->isNotEmpty()) {
            $dataTagihan = DataTagihan::where('santri_id', $santris->first()->id)->orderBy('created_at', 'desc')->get(); // Ambil data tagihan sesuai dengan santri yang login
        }

        return view('santri.profilesantri', compact('user', 'santris', 'data_pendaftars', 'daftarSekolah', 'dataTagihan'));
    }




    public function index()
    {
        $daftarSekolah = ListSekolah::all();
        $data_santri = DataSantri::all();
        $user = User::all();


        return view('santri.index', compact('data_santri', 'daftarSekolah', 'user'));
    }

    public function show($id)
    {
        $daftarSekolah = ListSekolah::all();
        $data_santri = DataSantri::findOrFail($id);
        $dataTagihan = DataTagihan::where('santri_id', $id)->orderBy('created_at', 'desc')->get();
        $jenis_tagihan = JenisTagihan::all();


        return view('santri.detail', compact('data_santri', 'daftarSekolah', 'dataTagihan', 'jenis_tagihan'));
    }

    public function history($id)
    {
        $daftarSekolah = ListSekolah::all();
        $data_santri = DataSantri::findOrFail($id);
        $dataTagihan = DataTagihan::where('santri_id', $id)->orderBy('created_at', 'desc')->get();
        $jenis_tagihan = JenisTagihan::all();
        $data_pembayaran = DataPembayaran::all();

        return view('santri.history', compact('data_santri', 'daftarSekolah', 'dataTagihan', 'jenis_tagihan', 'data_pembayaran'));
    }


    public function searchSantri(Request $request)
    {
        $daftarSekolah = ListSekolah::all();
        $keyword = $request->input('keyword');

        $santris = DataSantri::where('nama', 'LIKE', "%$keyword%")->get();

        return view('santri.search', compact('santris', 'keyword', 'daftarSekolah'));
    }

    public function addPayment(Request $request, $santriId)
    {

        $request->validate([
            'bukti_transfer' => 'nullable|file|mimes:jpeg,png,pdf|max:2048', // Buat bukti_transfer opsional


        ]);


        $filePath = null;
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
        }
        // Buat objek pembayaran baru
        DataPembayaran::create([
            'santri_id' => $santriId,
            'tagihan_id' => $request->input('tagihan_id'),
            'bulan' => $request->input('bulan'),
            'nominal_tagihan' => $request->input('nominal_tagihan'),
            'metode' => $request->input('metode'),
            'bukti_transfer' => $filePath,
            'status' => 3, // default status
        ]);


        Alert::success('Pembayaran berhasil ditambahkan');
        return redirect()->route('santri.detail', $santriId);
    }
}
