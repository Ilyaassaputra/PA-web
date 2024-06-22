<?php

namespace App\Http\Controllers;

use App\Models\DataSantri;
use App\Models\DataTagihan;
use Illuminate\Support\Str;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use App\Services\TwilioService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DataTagihanController extends Controller
{
    public function index()
    {
        // Ambil data tagihan dengan id terkecil untuk setiap kelompok bulan dan tahun ajaran
        $dataTagihan = DB::table('data_tagihans')
        ->select('bulan', 'thn_ajaran', DB::raw('MIN(id) as min_id'))
        ->groupBy('bulan', 'thn_ajaran')
        ->orderBy('min_id', 'desc') // Urutkan berdasarkan id terkecil secara descending (terbaru)
        ->get();

        $dataTagihanDetail = collect([]);

        foreach ($dataTagihan as $tagihan) {
            // Ambil detail tagihan dengan id terkecil dari hasil query sebelumnya
            $detail = DataTagihan::with('JenisTagihan')
            ->where('id', $tagihan->min_id)
                ->first();

            if ($detail) {
                $dataTagihanDetail->push($detail);
            }
        }

        $jenis_tagihan = JenisTagihan::all();

        return view('santri.tagihan', compact('dataTagihan', 'jenis_tagihan', 'dataTagihanDetail'));
    }

    // app/Http/Controllers/TagihanController.php
    public function show($id)
    {
        $tagihan = DataTagihan::with('pembayaran')->findOrFail($id);
        return view('santri.detailpembayaran', compact('tagihan'));
    }


    public function store(Request $request, TwilioService $twilio)
    {

        $dataSantri = DataSantri::all();
        $batchId = Str::uuid(); // Menghasilkan UUID baru untuk setiap tagihan
        foreach ($dataSantri as $santri) {

            DataTagihan::create([
                'santri_id' => $santri->id,
                'jenis_tagihan_id' => $request->jenis_tagihan_id,
                'bulan' => $request->bulan,
                'thn_ajaran' => $request->thn_ajaran,
                'nominal_tagihan' => $request->nominal_tagihan,
                'batch_id' => $batchId,  // Menyimpan batch_id yang sama untuk setiap tagihan dalam satu batch
            ]);

            $message = "Tagihan baru telah dibuat untuk bulan " . $request->bulan . " dengan nominal " . $request->nominal_tagihan;
            $twilio->sendSms($santri->no_hp, $message);
        }
        Alert::success('Berhasil', 'Tagihan Baru berhasil ditambahkan');
        return redirect()->route('tagihan');
    }


    public function destroy($batch_id)
    {
        // Menghapus semua tagihan dengan batch_id yang sama
        DataTagihan::where('batch_id', $batch_id)->delete();

        // Redirect ke halaman dengan pesan sukses
        return redirect()->route('tagihan');
    }
}
