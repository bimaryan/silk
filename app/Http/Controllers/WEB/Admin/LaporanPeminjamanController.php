<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class LaporanPeminjamanController extends Controller
{
    public function index()
    {
        $laporan = Peminjaman::with(['peminjamanDetail.barang', 'pengembalian'])
            ->orderBy('created_at', 'desc')
            ->get();

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

        return view('pages.staff.laporan-peminjaman.index', [
            'laporan' => $laporan,
            'notifikasi' => $notifikasi
        ]);
    }
}
