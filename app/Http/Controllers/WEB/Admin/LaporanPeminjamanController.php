<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $notifikasiPeminjaman = Peminjaman::with(['mahasiswa', 'dosen', 'barang'])
            ->where('status', '!=', 'Dikembalikan')
            ->latest()
            ->take(5)
            ->get();

        $peminjamans = Peminjaman::with(['mahasiswa', 'dosen', 'barang'])
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('tanggal_waktu_peminjaman', $bulan);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('tanggal_waktu_peminjaman', $tahun);
            })
            ->paginate(5);

        return view('pages.staff.laporan-peminjaman.index', [
            'notifikasiPeminjaman' => $notifikasiPeminjaman,
            'peminjamans' => $peminjamans,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }
}
