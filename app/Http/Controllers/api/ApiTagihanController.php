<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DataSantri;
use App\Models\DataTagihan;
use App\Models\JenisTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ApiTagihanController extends Controller
{
    public function store(Request $request)
    {

        $data = $request->all();

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
        }
        Alert::success('Berhasil', 'Tagihan Baru berhasil ditambahkan');
        return response()->json([
            'code' => 200,
            'message' => 'Tagihan berhasil ditambahkan',
        ]);
    }

    // ambil data tahun ajaran

    public function getDataNominal(Request $request)
    {
        $data['message'] = false;

        try {
            $data['data'] = JenisTagihan::where('id', $request->id)->first();
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
}
