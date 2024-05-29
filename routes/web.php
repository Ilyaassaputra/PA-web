<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PendaftarController;
use Illuminate\Routing\Route as RoutingRoute;
use App\Http\Controllers\DataTagihanController;
use App\Http\Controllers\JenisTagihanController;
use App\Http\Controllers\DataPendaftarController;
use App\Http\Controllers\DataPembayaranController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
});

Route::middleware('auth')->group(function () {
    
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/datapendaftar', [DataPendaftarController::class, 'index'])->name('datapendaftar');
    Route::get('/pendaftar/{id}', [DataPendaftarController::class, 'show'])->name('pendaftar.detail');
    Route::get('/tambah.pendaftar', [DataPendaftarController::class, 'create']);
    Route::post('/tambah.pendaftar', [DataPendaftarController::class, 'tambahPendaftar']);
    Route::post('/konfirmasi-pendaftar/{id}', [DataPendaftarController::class, 'konfirmasiPendaftar'])->name('konfirmasi.pendaftar');
    Route::delete('/datapendaftar/{id}', [DataPendaftarController::class, 'destroy'])->name('destroy.pendaftar');


    Route::get('/datasantri', [SantriController::class, 'index'])->name('datasantri');
    Route::get('/santri/{id}', [SantriController::class, 'show'])->name('santri.detail');

    Route::get('/dashboard', [DataPendaftarController::class, 'dashboard'])->name('dashboard');
    Route::post('/upload-bukti', [DataPendaftarController::class, 'uploadBuktiPembayaran'])->name('upload.bukti');


    Route::get('search', [SantriController::class, 'searchSantri'])->name('santri.search');
    Route::get('/santri/detail/{id}', [SantriController::class, 'show'])->name('santri.detail');
    Route::get('/profilesantri', [SantriController::class, 'profile'])->name('profilesantri');
    Route::post('/santri/add-payment/{id}', [SantriController::class, 'addPayment'])->name('santri.addPayment');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, 'filter'])->name('laporan.index');

    Route::get('/tagihan', [DataTagihanController::class, 'index'])->name('tagihan');
    Route::post('/add-tagihan', [DataTagihanController::class, 'store']);
    Route::delete('tagihan/{batch_id}', [DataTagihanController::class, 'destroy'])->name('tagihan.destroy');


    Route::get('/pembayaran/{tagihanId}', [DataPembayaranController::class, 'showBayarForm'])->name('show-bayar-form');
    Route::post('/pembayaran/{tagihanId}', [DataPembayaranController::class, 'bayar'])->name('bayar');

    Route::get('/tagihanedit/edit', [JenisTagihanController::class, 'index'])->name('editindex');
    Route::post('/tagihanedit/update', [JenisTagihanController::class, 'update'])->name('tagihanedit.update');

    Route::get('/dataadmin', [AdminController::class, 'index'])->name('dataadmin');
    Route::get('/add-admin', [AdminController::class, 'create']);
    Route::post('/add-admin', [AdminController::class, 'createAdmin'])->name('createAdmin');
    Route::delete('/dataadmin/{id}', [AdminController::class, 'destroyAdmin'])->name('destroy.admin');


    // Route::get('/laporan-bulanan', [LaporanController::class, 'bulanan'])->name('laporan-bulanan');
    // Route::post('/laporan-bulanan', [LaporanController::class, 'filterBulanan'])->name('filter-laporan-bulanan');


    // Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
    //     ->name('logout');
});

require __DIR__ . '/auth.php';
