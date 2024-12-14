<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class VerifikasiPeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::paginate(5);
        return view('pages.staff.verifikasi-peminjaman.index', compact('peminjamans'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Temukan peminjaman berdasarkan ID dengan relasi ruangan
        $peminjaman = Peminjaman::with(['barang.stock', 'ruangan'])->findOrFail($peminjaman->id);

        // Ambil nilai approval dari input request
        $approval = $request->input('aprovals');

        // Logika untuk peminjaman barang
        if ($peminjaman->jenis_peminjaman === 'Barang') {
            $currentStock = $peminjaman->barang->stock->stock ?? null;

            if (is_null($currentStock)) {
                return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
            }

            $jumlahPinjam = $peminjaman->stock_pinjam;

            if ($approval === 'Ya') {
                $newStock = $currentStock - $jumlahPinjam;

                if ($newStock >= 0) {
                    $peminjaman->barang->stock->update([
                        'stock' => $newStock,
                    ]);

                    $peminjaman->status = 'Dipinjamkan';
                } else {
                    return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
                }
            }
        }

        // Logika untuk peminjaman ruangan
        if ($peminjaman->jenis_peminjaman === 'Ruangan') {
            if ($approval === 'Ya') {
                $peminjaman->status = 'Dipinjamkan';
            } elseif ($approval === 'Tidak') {
                $peminjaman->status = 'Dipinjamkan';
            }
        }

        // Update status dan approval
        $peminjaman->aprovals = $approval;
        $peminjaman->save();

        return redirect()->back()->with('success', 'Status dan approval peminjaman berhasil diperbarui.');
    }
}
