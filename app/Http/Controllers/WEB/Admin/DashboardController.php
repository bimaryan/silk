<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeminjaman = Peminjaman::count();
        $totalMahasiswa = Mahasiswa::count();
        $totalAlat = Barang::where('kategori_id', 1)->count();
        $totalBahan = Barang::where('kategori_id', 2)->count();

        $peminjamanTerakhir30Hari = Peminjaman::whereRaw('CAST(tanggal_waktu_peminjaman AS DATE) >= ?', [now()->subDays(30)->toDateString()])->count();

        $persentasePeminjaman = ($totalPeminjaman > 0) ? ($peminjamanTerakhir30Hari / $totalPeminjaman) * 100 : 0;

        $totalDikembalikan = Peminjaman::where('persetujuan', 'Dikembalikan')->count();

        // Ambil notifikasi terkait peminjaman yang belum diproses
        $peminjamanNotifications = Peminjaman::where('persetujuan', 'Belum Diserahkan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil notifikasi terkait pengembalian yang perlu verifikasi
        $pengembalianNotifications = Pengembalian::where('persetujuan', 'Menunggu Verifikasi')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Gabungkan notifikasi
        $notifikasi = $peminjamanNotifications->merge($pengembalianNotifications);

        return view('pages.dashboard.index', compact('totalPeminjaman', 'totalMahasiswa', 'totalAlat', 'totalBahan', 'persentasePeminjaman', 'totalDikembalikan', 'peminjamanTerakhir30Hari', 'notifikasi'));
    }
}
