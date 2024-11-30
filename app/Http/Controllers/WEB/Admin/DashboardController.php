<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeminjaman = Peminjaman::count();
        $totalMahasiswa = Mahasiswa::count();
        $totalAlat = Barang::where('kategori_id', 1)->count();
        $totalBahan = Barang::where('kategori_id', 2)->count();

        $peminjamanTerakhir30Hari = Peminjaman::whereRaw('CAST(tgl_pinjam AS DATE) >= ?', [now()->subDays(30)->toDateString()])->count();

        $persentasePeminjaman = ($totalPeminjaman > 0) ? ($peminjamanTerakhir30Hari / $totalPeminjaman) * 100 : 0;

        $totalDikembalikan = Peminjaman::where('status', 'Dikembalikan')->count();

        return view('pages.dashboard.index', compact('totalPeminjaman', 'totalMahasiswa', 'totalAlat', 'totalBahan', 'persentasePeminjaman', 'totalDikembalikan', 'peminjamanTerakhir30Hari'));
    }
}
