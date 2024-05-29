<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DataPembayaran;
use App\Models\DataTagihan;
use App\Models\DokumenMou;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;



class LaporanController extends Controller
{
    public function getTableName()
    {
        return "data_pembayarans";
    }

    public function getData(Request $request)
    {
        // dd($request->all());
        DB::enableQueryLog();
        $data['data'] = [];
        $datadb = DataTagihan::with('santri', 'jenisTagihan', 'pembayaran');
        // dd($datadb);


        if (isset($_GET)) {
            if (isset($_GET['bulan'])) {
                if ($_GET['bulan'] != '') {
                    $datadb->where('bulan', '=', $_GET['bulan']);
                }
            }
            if (isset($_GET['tahun'])) {
                if ($_GET['tahun'] != '') {
                    $datadb->whereRaw("YEAR(created_at) = ?", $_GET['tahun']);

                }
            }
            if (isset($_GET['status_pembayaran'])) {
                if ($_GET['status_pembayaran'] != '') {
                    $datadb->where('status_pembayaran', '=', $_GET['status_pembayaran']);
                }
            }

            if (isset($_GET['jenis_pembayaran'])) {
                if ($_GET['jenis_pembayaran'] != '') {
                    $datadb->where('jenis_tagihan_id', '=', $_GET['jenis_pembayaran']);
                }
            }

        }

        $data['data'] = $datadb->get()->toArray();

        return response()->json($data);
    }



}
