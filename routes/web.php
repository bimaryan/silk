<?php

use App\Http\Controllers\WEB\Admin\AdminController;
use App\Http\Controllers\WEB\Admin\DashboardController;
use App\Http\Controllers\WEB\Admin\DokumenSpoController;
use App\Http\Controllers\WEB\Admin\DosenController;
use App\Http\Controllers\WEB\Admin\KelasController;
use App\Http\Controllers\WEB\Admin\LaporanPeminjamanController;
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
use App\Http\Controllers\WEB\Pengguna\PeminjamanController;
use App\Http\Controllers\WEB\Pengguna\PengembalianController;
use App\Http\Controllers\WEB\Pengguna\RiwayatController;
// use App\Http\Controllers\WEB\Pengguna\PeminjamanController;
use App\Http\Controllers\WEB\Pengguna\RuanganController as PenggunaRuanganController;
use App\Http\Controllers\WEB\Staff\BarangController;
use App\Http\Controllers\WEB\Staff\Kategoricontroller;
use App\Http\Controllers\WEB\Staff\RuanganController as StaffRuanganController;
use App\Http\Controllers\WEB\Staff\SatuanController;
use App\Http\Controllers\WEB\Staff\VerifikasiPeminjamanController;
use App\Http\Controllers\WEB\Staff\VerifikasiPengembaliancontroller;
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
    Route::resource('laporan-peminjaman', LaporanPeminjamanController::class);

    Route::middleware(['UserAccess:Admin'])->group(function () {
        Route::prefix('pengguna/')->group(function () {
            Route::resource('admin-dan-staff', AdminController::class);
            Route::resource('data-mahasiswa', MahasiswaController::class);
            Route::resource('data-dosen', DosenController::class);

            Route::post('import-mahasiswa', [MahasiswaController::class, 'importMahasiswa'])->name('import-mahasiswa');
            Route::get('export-mahasiswa', [MahasiswaController::class, 'exportMahasiswa'])->name('export-mahasiswa');

            Route::post('import-dosen', [DosenController::class, 'importDosen'])->name('import-dosen');
            Route::get('export-dosen', [DosenController::class, 'exportDosen'])->name('export-dosen');

            Route::post('import-kelas', [KelasController::class, 'importKelas'])->name('import-kelas');
            Route::get('export-kelas', [KelasController::class, 'exportKelas'])->name('export-kelas');
        });

        Route::resource('data-kelas', KelasController::class);

        Route::resource('data-mata-kuliah', MataKuliahController::class);
        Route::post('import-mata-kuliah', [MataKuliahController::class, 'importMataKuliah'])->name('import-mata-kuliah');
        Route::get('export-mata-kuliah', [MataKuliahController::class, 'exportMataKuliah'])->name('export-mata-kuliah');

        Route::resource('data-spo', DokumenSpoController::class);
        Route::get('download-spo/{data_spo}', [DokumenSpoController::class, 'downloadSPO'])->name('download.spo');
    });

    Route::middleware(['UserAccess:Staff'])->group(function () {
        Route::prefix('data/')->group(function () {
            Route::resource('barang', BarangController::class);
            Route::post('import-barang', [BarangController::class, 'importBarang'])->name('import-barang');
            Route::get('export-barang', [BarangController::class, 'exportBarang'])->name('export-barang');

            Route::resource('kategori', Kategoricontroller::class);
            Route::post('import-kategori', [KategoriController::class, 'importKategori'])->name('import-kategori');

            Route::resource('satuan', SatuanController::class);
            Route::post('import-satuan', [SatuanController::class, 'importSatuan'])->name('import-satuan');
        });

        Route::resource('ruangan', StaffRuanganController::class);
        Route::post('import-ruangan', [StaffRuanganController::class, 'importRuangan'])->name('import-ruangan');
        Route::get('export-ruangan', [StaffRuanganController::class, 'exportRuangan'])->name('export-ruangan');

        Route::prefix('verifikasi/')->group(function () {
            Route::get('verifikasi-peminjaman', [VerifikasiPeminjamanController::class, 'index'])->name('verifikasi-peminjaman.index');
            Route::put('update-status-barang/{id}', [VerifikasiPeminjamanController::class, 'updateStatusBarang'])->name('verifikasi-peminjaman.update');
            Route::put('updata-persetujuan-barang/{id}', [VerifikasiPeminjamanController::class, 'updatePersetujuan'])->name('updatePersetujuanBarang');

            Route::resource('verifikasi-pengembalian', VerifikasiPengembaliancontroller::class);
        });
    });
});

Route::middleware(['multiGuard:dosen,mahasiswa'])->group(function () {
    Route::resource('logout', LogoutController::class)->only('index');

    Route::resource('beranda', BerandaController::class)->only('index');
    Route::resource('katalog', KatalogController::class);
    Route::resource('katalog-ruangan', PenggunaRuanganController::class);
    Route::prefix('informasi/')->group(function () {
        Route::get('informasi-peminjaman', [InformasiController::class, 'indexPeminjaman'])->name('informasi-peminjaman.index');
        Route::get('informasi-pengembalian', [InformasiController::class, 'indexPengembalian'])->name('informasi-pengembalian.index');
    Route::post('proses-pengembalian/{pengembalian_id}', [InformasiController::class, 'prosesPengembalian'])->name('pengembalian.proses');

    });
    Route::resource('riwayat', RiwayatController::class);
    Route::resource('edit-profile', EditProfileController::class);
    Route::resource('edit-password', EditPasswordController::class);
    Route::resource('peminjaman', PeminjamanController::class);

    Route::get('/detail/{id}', [DetailController::class, 'index'])->name('detail.index');
    Route::post('/detail/store/{barang}', [DetailController::class, 'store'])->name('detail.store');
    Route::resource('keranjang', KeranjangController::class);

});
