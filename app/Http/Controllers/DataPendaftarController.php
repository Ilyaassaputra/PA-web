<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataSantri;
use App\Models\DataTagihan;
use App\Models\ListSekolah;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class DataPendaftarController extends Controller
{
    public function dashboard()
    {
        $data_pendaftars = DataPendaftar::where('user_id', auth()->id())->first();
        $data_santri = User::where('id', $data_pendaftars->user_id)->first();
        $daftarSekolah = ListSekolah::all();
        $dataTagihan = DataTagihan::where('santri_id', $data_santri->id)->get();
        $jenis_tagihan = JenisTagihan::all();

        return view('dashboard', compact('data_pendaftars', 'data_santri', 'daftarSekolah', 'dataTagihan', 'jenis_tagihan'));
    }

    public function index(Request $request)
    {
        $daftarSekolah = ListSekolah::all();
        $data_pendaftar = DataPendaftar::all();

        // return response()->json([
        //     'message' => 'Success',
        //     'data' => $data_pendaftar
        // ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $data_pendaftar,

            ]);
        }
        return view('pendaftar.index', compact('data_pendaftar', 'daftarSekolah'));
    }


    public function show($id)
    {
        $daftarSekolah = ListSekolah::all();
        $data_pendaftar = DataPendaftar::findOrFail($id);
        return view('pendaftar.detail', compact('data_pendaftar', 'daftarSekolah'));
    }

    public function create()
    {
        $daftarSekolah = ListSekolah::all();
        return view('pendaftar.create', compact('daftarSekolah'));
    }

    public function tambahPendaftar(Request $request)
    {
        $request->validate([
            // Validasi untuk form tambah pendaftar
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'sekolah_id' => ['required', 'string'],
            'nama_ayah' => ['required', 'string'],
            'nama_ibu' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string'],
            'foto' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],


        ]);

        // Simpan foto ke dalam direktori penyimpanan
        $fotoPath = null;
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoPath = $request->file('foto')->store('foto', 'public');
        }


        // Buat pengguna dalam tabel users
        $user = User::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),

        ]);

        $pendaftar = DataPendaftar::create([
            'user_id' => $user->id,
            'nama' => $request['nama'],
            'tempat_lahir' => $request['tempat_lahir'],
            'tanggal_lahir' => $request['tanggal_lahir'],
            'jenis_kelamin' => $request['jenis_kelamin'],
            'sekolah_id' => $request['sekolah_id'],
            'nama_ayah' => $request['nama_ayah'],
            'nama_ibu' => $request['nama_ibu'],
            'alamat' => $request['alamat'],
            'no_hp' => $request['no_hp'],
            'foto' => $request['foto'],
        ]);

        return redirect('datapendaftar');
        return $user;
    }

    public function uploadBuktiPembayaran(Request $request)
    {


        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ]);

        $buktiPembayaran = null;
        if ($request->hasFile('bukti_pembayaran') && $request->file('bukti_pembayaran')->isValid()) {
            $buktiPembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $data_pendaftar = DataPendaftar::findOrFail($request->id);
        $data_pendaftar->update([
            'status' => 2,
            'bukti_pembayaran' => $buktiPembayaran,
        ]);

        return redirect()->route('dashboard')->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    public function konfirmasiPendaftar($id)
    {
        $dataPendaftar = DataPendaftar::findOrFail($id);

        if ($dataPendaftar->status != 2) {
            return redirect()->route('datapendaftar')->with('error', 'Pembayaran pendaftaran belum dikonfirmasi.');
        }
        // Mencari user berdasarkan nama


        $dataPendaftar->update([
            'status' => 3,

        ]);

        // Proses konfirmasi dan pindah ke data santri
        DB::transaction(function () use ($dataPendaftar) {
            $dataSantri = DataSantri::create([
                'nama' => $dataPendaftar->nama,
                'tempat_lahir' => $dataPendaftar->tempat_lahir,
                'tanggal_lahir' => $dataPendaftar->tanggal_lahir,
                'jenis_kelamin' => $dataPendaftar->jenis_kelamin,
                'sekolah_id' => $dataPendaftar->sekolah_id,
                'nama_ayah' => $dataPendaftar->nama_ayah,
                'nama_ibu' => $dataPendaftar->nama_ibu,
                'alamat' => $dataPendaftar->alamat,
                'no_hp' => $dataPendaftar->no_hp,
                'foto' => $dataPendaftar->foto,
                'status' => 'aktif',
                'data_pendaftar_id' => $dataPendaftar->id,
            ]);

            $user = $dataPendaftar->user;
            $user->role = 'santri';
            $user->save();
        });

        return redirect()->route('datasantri');
    }
    public function destroy($id)
    {
        $dataPendaftar = DataPendaftar::with('user')->findOrFail($id); 
        $user = $dataPendaftar->user; 

        if (!$dataPendaftar) {
            return redirect()->route('datapendaftar')->with('error', 'Data pendaftar tidak ditemukan');
        }

        DB::beginTransaction();

        try {
            if ($dataPendaftar) {
                $dataPendaftar->delete(); 
            }

            $user->delete(); 
            DB::commit(); 

            return redirect()->route('datapendaftar')->with('success', 'Data pendaftar dan user berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback(); 
            return redirect()->route('datapendaftar')->with('error', 'Gagal menghapus data pendaftar dan user: ' . $e->getMessage());
        }
    }
}
