<?php

use App\Http\Controllers\WEB\Admin\AdminController;
use App\Http\Controllers\WEB\Admin\DashboardController;
use App\Http\Controllers\WEB\Admin\MahasiswaController;
use App\Http\Controllers\WEB\Auth\ForgotPasswordController;
use App\Http\Controllers\WEB\Auth\LoginController;
use App\Http\Controllers\WEB\Auth\LogoutController;
use App\Http\Controllers\WEB\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

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
        });
    });

    Route::middleware(['UserAccess:Staff'])->group(function () {});
});

Route::middleware(['multiGuard:dosen,mahasiswa'])->group(function () {});
