<?php

namespace App\Http\Controllers;

use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class JenisTagihanController extends Controller
{
    public function index()
    {
        $jenisTagihan = JenisTagihan::whereIn('jenis_tagihan', ['Daftar Ulang', 'Bulanan'])->get();
        return view('santri.tagihanedit', compact('jenisTagihan'));
    }
    public function update(Request $request)
    {
        // Validasi
        $request->validate([
            'nominal_tagihan' => 'required|array',
            'nominal_tagihan.*' => 'numeric|min:0'
        ]);

        // Update data
        foreach ($request->nominal_tagihan as $id => $nominal) {
            JenisTagihan::whereId($id)->update(['nominal_tagihan' => $nominal]);
        }

        // Redirect setelah update untuk menghindari double submission
        Alert::success('Berhasil', 'Nominal Tagihan Berhasil Diubah');
        return redirect()->route('editindex');
    }

}
