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
use RealRashid\SweetAlert\Facades\Alert;


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
            'foto' => ['image', 'mimes:jpeg,png,jpg,gif'],


        ]);

        try {
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
                'foto' => $fotoPath,
            ]);

            Alert::success('Berhasil', 'Data Berhasil Ditambah');
            return redirect('datapendaftar');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data Gagal Ditambah');
            return redirect('datapendaftar');
        }
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
        Alert::success('Bukti Pembayaran Berhasil Diupload', 'Tunggu hingga admin melakukan konfirmasi');
        return redirect()->route('dashboard');
    }

    public function konfirmasiPendaftar($id)
    {
        $dataPendaftar = DataPendaftar::findOrFail($id);

        if ($dataPendaftar->status != 2) {
            Alert::error('Gagal', 'Pendaftar Belum Melakukan Pembayaran.');
            return redirect()->route('datapendaftar');
        }
        // Mencari user berdasarkan nama


        $dataPendaftar->update([
            'status' => 3,

        ]);

        // Proses konfirmasi dan pindah ke data santri
        try {
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
            Alert::success('Berhasil', 'Pendaftaran berhasil dikonfirmasi.');
            return redirect()->route('datapendaftar');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Pendaftaran gagal dikonfirmasi.');
            return redirect()->route('datapendaftar');
        }
    }

    public function destroy($id)
    {
        $dataPendaftar = DataPendaftar::with('user')->findOrFail($id);
        $user = $dataPendaftar->user;

        if (!$dataPendaftar) {
            Alert::error('Data Pendaftar Tidak Ditemukan.');
            return redirect()->route('datapendaftar');
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
