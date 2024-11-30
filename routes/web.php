<?php

use App\Http\Controllers\WEB\Admin\AdminController;
use App\Http\Controllers\WEB\Admin\DashboardController;
use App\Http\Controllers\WEB\Admin\DokumenSpoController;
use App\Http\Controllers\WEB\Admin\DosenController;
use App\Http\Controllers\WEB\Admin\KelasController;
use App\Http\Controllers\WEB\Admin\MahasiswaController;
use App\Http\Controllers\WEB\Admin\MataKuliahController;
use App\Http\Controllers\WEB\Auth\ForgotPasswordController;
use App\Http\Controllers\WEB\Auth\LoginController;
use App\Http\Controllers\WEB\Auth\LogoutController;
use App\Http\Controllers\WEB\Auth\ResetPasswordController;
use App\Http\Controllers\WEB\Staff\BarangController;
use App\Http\Controllers\WEB\Staff\Kategoricontroller;
use App\Http\Controllers\WEB\Staff\SatuanController;
use Illuminate\Support\Facades\Route;

// ROUTE LOGIN
Route::resource('login', LoginController::class);

// ROUTE FORGOT PASSWORD
Route::resource('forgot-password', ForgotPasswordController::class);

// ROUTE RESET PASSWORD
Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('reset-password.index');
Route::post('reset-password/{token}', [ResetPasswordController::class, 'store'])->name('reset-password.store');

Route::middleware(['auth:admin'])->group(function () {
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::resource('logout', LogoutController::class)->only('index');

    Route::middleware(['UserAccess:Admin'])->group(function () {
        Route::prefix('pengguna')->group(function () {
            Route::resource('admin-dan-staff', AdminController::class);
            Route::resource('data-mahasiswa', MahasiswaController::class);
            Route::resource('data-dosen', DosenController::class);
        });

        Route::resource('data-kelas', KelasController::class);
        Route::resource('data-mata-kuliah', MataKuliahController::class);
        Route::resource('data-spo', DokumenSpoController::class);
    });

    Route::middleware(['UserAccess:Staff'])->group(function () {
        Route::prefix('data/')->group(function () {
            Route::resource('barang', BarangController::class);
            Route::resource('kategori', Kategoricontroller::class);
            Route::resource('satuan', SatuanController::class);
        });
    });
});

Route::middleware(['multiGuard:dosen,mahasiswa'])->group(function () {});
