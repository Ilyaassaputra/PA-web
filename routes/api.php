<?php

use App\Http\Controllers\api\ApiSantriController;
use App\Http\Controllers\api\ApiTagihanController;
use App\Http\Controllers\api\LaporanController;
use App\Http\Controllers\api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DataPendaftarController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [RegisteredUserController::class, 'register']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/datasantri', [ApiController::class, 'indexSantri']);
Route::get('/datapendaftar', [ApiController::class, 'index']);
Route::get('/datapendaftar/{id}', [ApiController::class, 'show']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', function (Request $request) {
        return $request->user();
    });



    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});




Route::get('cari', [LaporanController::class, 'getData']);
Route::post('loginMobile', [LoginController::class, 'loginApi']);

// API TAGIHAN
Route::post('buat-tagihan', [ApiTagihanController::class, 'store']);
Route::post('getDataNominal', [ApiTagihanController::class, 'getDataNominal']);
// SANTRI
Route::post('getDataSantriByNamed', [ApiSantriController::class, 'getDataSantriByNamed']);
Route::post('getDataSantriById', [ApiSantriController::class, 'getDataSantriById']);
Route::post('bayar', [ApiSantriController::class, 'bayar']);
