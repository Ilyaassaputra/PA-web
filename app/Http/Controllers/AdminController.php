<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataSantri;
use App\Models\ListSekolah;
use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function dashboard(){
        $statusPendaftar = [1,2];
        $jumlahPendaftar = DataPendaftar::whereIn('status', $statusPendaftar)->count();
        $jumlahSantri = DataSantri::count();
        $daftarSekolah = ListSekolah::all();
        $data_pendaftar = DataPendaftar::all();
        return view('admin.dashboard', compact('jumlahPendaftar', 'jumlahSantri', 'daftarSekolah', 'data_pendaftar'));
    }

    public function index()
    {       
        $admin = User::where('role', 'admin')->get();
        return view('admin.index', compact('admin'));
    }
    public function create(){
        $admin = User::all();
        return view('admin.add-admin', compact('admin'));
    }
    protected function createAdmin(Request $data){
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => 'admin',
            'password' => Hash::make($data['password']),
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Ditambah');
        return redirect()->route('dataadmin');
    }

    public function destroyAdmin($id){
        $data = User::findOrFail($id);
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        $data ->delete();
        return redirect()->route('dataadmin');
    }
}
