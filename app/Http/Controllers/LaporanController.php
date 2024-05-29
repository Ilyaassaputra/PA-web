<?php

namespace App\Http\Controllers;

use App\Models\DataSantri;
use App\Models\DataTagihan;
use Illuminate\Http\Request;
use App\Models\DataPembayaran;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function index()
    {

        $laporan = DataTagihan::orderBy('updated_at', 'desc')->get();
        $dataPembayaran = DataPembayaran::all();
        $years = DataTagihan::selectRaw('YEAR(created_at) as year')
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get()
        ->pluck('year');
        $thnAjarans = DataTagihan::select('thn_ajaran')
        ->groupBy('thn_ajaran')
        ->orderBy('thn_ajaran', 'desc')
        ->get();

        return view('santri.laporan', compact('laporan', 'dataPembayaran', 'years', 'thnAjarans'));

    }

    public function filter(Request $request) {
        // dd($request->all());
        $bulan = $request->bulan;
        $tahun = $request->filled('tahun') ? $request->tahun : null;
        $thnajaran = $request->thn_ajaran;
        $status_pembayaran = $request->status_pembayaran;
        $jenis_tagihan_id = $request->jenis_tagihan_id;
        $years = DataTagihan::selectRaw('YEAR(created_at) as year');

        $laporan = DataTagihan::with(['pembayaran', 'santri'])
            ->when($bulan, function ($query, $bulan) {
                return $query->where('bulan', $bulan);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('created_at', $tahun);
            })
            ->when($thnajaran, function ($query, $thnajaran) {
                return $query->where('thn_ajaran', $thnajaran);
            })
            ->when($status_pembayaran, function ($query, $status_pembayaran) {
                if ($status_pembayaran == 'Sudah Bayar') {
                    return $query->whereHas('pembayaran', function ($subquery) {
                        $subquery->where('status_pembayaran', 'Sudah Bayar');
                    });
                } elseif ($status_pembayaran == 'Belum Bayar') {
                    return $query->whereDoesntHave('pembayaran', function ($subquery) {
                        $subquery->where('status_pembayaran', 'Sudah Bayar');
                    });
                }
            })
            ->when($jenis_tagihan_id, function ($query, $jenis_tagihan_id) {
                return $query->where('jenis_tagihan_id', $jenis_tagihan_id);
            })
            ->get();

        return view('santri.laporan2', compact('laporan', 'bulan', 'years'));
    }



}
