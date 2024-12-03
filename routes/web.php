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
use App\Http\Controllers\WEB\Pengguna\BerandaController;
use App\Http\Controllers\WEB\Pengguna\DetailController;
use App\Http\Controllers\WEB\Pengguna\EditPasswordController;
use App\Http\Controllers\WEB\Pengguna\EditProfileController;
use App\Http\Controllers\WEB\Pengguna\InformasiController;
use App\Http\Controllers\WEB\Pengguna\KatalogController;
use App\Http\Controllers\WEB\Pengguna\KeranjangController;
use App\Http\Controllers\WEB\Pengguna\RiwayatController;
use App\Http\Controllers\WEB\Staff\BarangController;
use App\Http\Controllers\WEB\Staff\Kategoricontroller;
use App\Http\Controllers\WEB\Staff\RuanganController;
use App\Http\Controllers\WEB\Staff\SatuanController;
use App\Http\Controllers\WEB\Staff\VerifikasiPeminjamanController;
use Illuminate\Support\Facades\Route;

// ROUTE LOGIN
Route::resource('login', LoginController::class);

// ROUTE BERANDA
Route::resource('/', BerandaController::class);

// ROUTE FORGOT PASSWORD
Route::resource('forgot-password', ForgotPasswordController::class);

// ROUTE RESET PASSWORD
Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('reset-password.index');
Route::post('reset-password/{token}', [ResetPasswordController::class, 'store'])->name('reset-password.store');

Route::middleware(['auth:admin'])->group(function () {
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::resource('logout', LogoutController::class)->only('index');
    Route::resource('laporan-peminjamandownloadSPO', LogoutController::class)->only('index');

    Route::middleware(['UserAccess:Admin'])->group(function () {
        Route::prefix('pengguna')->group(function () {
            Route::resource('admin-dan-staff', AdminController::class);
            Route::resource('data-mahasiswa', MahasiswaController::class);
            Route::resource('data-dosen', DosenController::class);
        });

        Route::resource('data-kelas', KelasController::class);
        Route::resource('data-mata-kuliah', MataKuliahController::class);
        Route::resource('data-spo', DokumenSpoController::class);
        Route::get('download-spo/{data_spo}', [DokumenSpoController::class, 'downloadSPO'])->name('download.spo');
    });

    Route::middleware(['UserAccess:Staff'])->group(function () {
        Route::prefix('data/')->group(function () {
            Route::resource('barang', BarangController::class);
            Route::resource('kategori', Kategoricontroller::class);
            Route::resource('satuan', SatuanController::class);
            Route::resource('ruangan', RuanganController::class);
        });

        Route::resource('verifikasi-peminjaman', VerifikasiPeminjamanController::class);
    });
});

Route::middleware(['multiGuard:dosen,mahasiswa'])->group(function () {
    Route::resource('logout', LogoutController::class)->only('index');

    Route::resource('beranda', BerandaController::class)->only('index');
    Route::resource('katalog', KatalogController::class);
    Route::resource('informasi', InformasiController::class);
    Route::resource('riwayat', RiwayatController::class);
    Route::resource('edit-profile', EditProfileController::class);
    Route::resource('edit-password', EditPasswordController::class);

    Route::get('/detail/{id}', [DetailController::class, 'index'])->name('detail.index');
    Route::post('/detail/store/{barang}', [DetailController::class, 'store'])->name('detail.store');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/store/{keranjang}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::delete('/keranjang/{keranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');


});
