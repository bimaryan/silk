<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Pengguna\BerandaController;
use App\Http\Controllers\API\Pengguna\DetailController;
use App\Http\Controllers\API\Pengguna\InformasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('login', LoginController::class)->only('store');

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('beranda', BerandaController::class);
    Route::get('{nama_barang}', [DetailController::class, 'index'])->name('detail');
    Route::prefix('informasi/')->group(function(){});
    Route::get('informasi-peminjaman', [InformasiController::class, 'index'])->name('informasi.peminjaman');
});
