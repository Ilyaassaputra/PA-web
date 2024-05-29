<?php

namespace App\Http\Controllers;

use App\Models\DataSantri;
use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    

    public function index ()
    {
        $data_pendaftar = DataPendaftar::all();
        return response()->json([
            'message' => 'success',
            'data' => $data_pendaftar
        ]);
    }

    public function show ($id){
        $data_pendaftar = DataPendaftar::find($id);
        return response()->json([
            'data' => $data_pendaftar
        ]);
    }

    public function indexSantri()
    {
        $data_santri = DataSantri::all();
        return response()->json([
            'message' => 'success',
            'data' => $data_santri
        ]);
    }
}
