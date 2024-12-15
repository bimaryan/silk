<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class VerifikasiPeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['barang.kategori', 'ruangan'])
            ->whereNotNull('mahasiswa_id')  // Filter by mahasiswa_id
            ->orWhereNotNull('dosen_id')    // Filter by dosen_id
            ->get()
            ->groupBy(function ($data) {
                // Group by 'mahasiswa_id' if exists, otherwise by 'dosen_id'
                return $data->mahasiswa_id ? 'mahasiswa_' . $data->mahasiswa_id : 'dosen_' . $data->dosen_id;
            });

        return view('pages.staff.verifikasi-peminjaman.index', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Temukan semua data peminjaman berdasarkan mahasiswa_id atau dosen_id
        $relatedPeminjamans = Peminjaman::with(['barang.stock', 'ruangan'])
            ->where('mahasiswa_id', $peminjaman->mahasiswa_id)
            ->orWhere('dosen_id', $peminjaman->dosen_id)
            ->get();

        // Ambil nilai approval dari input request
        $approval = $request->input('aprovals');

        foreach ($relatedPeminjamans as $relatedPeminjaman) {
            // Logika untuk peminjaman barang
            if ($relatedPeminjaman->jenis_peminjaman === 'Barang') {
                $currentStock = $relatedPeminjaman->barang->stock->stock ?? null;

                if (is_null($currentStock)) {
                    return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
                }

                $jumlahPinjam = $relatedPeminjaman->stock_pinjam;

                if ($approval === 'Ya') {
                    $newStock = $currentStock - $jumlahPinjam;

                    if ($newStock >= 0) {
                        $relatedPeminjaman->barang->stock->update([
                            'stock' => $newStock,
                        ]);

                        $relatedPeminjaman->status = 'Dipinjamkan';
                    } else {
                        return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
                    }
                }
            }

            // Logika untuk peminjaman ruangan
            if ($relatedPeminjaman->jenis_peminjaman === 'Ruangan') {
                if ($approval === 'Ya') {
                    $relatedPeminjaman->status = 'Dipinjamkan';
                } elseif ($approval === 'Tidak') {
                    $relatedPeminjaman->status = 'Dipinjamkan';
                }
            }

            // Update status dan approval
            $relatedPeminjaman->aprovals = $approval;
            $relatedPeminjaman->save();
        }

        return redirect()->route('pengembalian.index')->with('success', 'Semua data peminjaman berhasil diperbarui.');
    }
}
