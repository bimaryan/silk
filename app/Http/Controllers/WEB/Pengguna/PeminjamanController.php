<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'nullable|exists:ruangans,id',
            'matkul_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'tanggal_waktu_peminjaman' => 'required',
            'waktu_pengembalian' => 'required',
        ]);

        // Ambil semua keranjang yang dimiliki oleh pengguna saat ini
        $keranjangs = Keranjang::where('users_id', Auth::id())->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada barang yang bisa dipinjam.');
        }

        foreach ($keranjangs as $keranjang) {
            Peminjaman::create([
                'users_id' => Auth::id(),
                'keranjang_id' => $keranjang->id,
                'ruangan_id' => $request->ruangan_id,
                'matkul_id' => $request->matkul_id,
                'dosen_id' => $request->dosen_id,
                'tanggal_waktu_peminjaman' => $request->tanggal_waktu_peminjaman,
                'waktu_pengembalian' => $request->waktu_pengembalian,
                'anggota_kelompok' => $request->anggota_kelompok,
                'status_pengembalian' => 'Belum',
                'aprovals' => 'Belum',
                'status' => 'Menunggu Persetujuan',
            ]);
        }

        return redirect()->route('informasi.index')->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan.');
    }
}
