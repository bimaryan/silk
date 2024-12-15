<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class VerifikasiPengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Peminjaman::with(['barang.kategori', 'ruangan'])
            ->whereNotNull('mahasiswa_id')  // Filter by mahasiswa_id
            ->orWhereNotNull('dosen_id')    // Filter by dosen_id
            ->get()
            ->groupBy(function ($data) {
                // Group by 'mahasiswa_id' if exists, otherwise by 'dosen_id'
                return $data->mahasiswa_id ? 'mahasiswa_' . $data->mahasiswa_id : 'dosen_' . $data->dosen_id;
            });

        return view('pages.staff.verifikasi-pengembalian.index', compact('pengembalian'));
    }

    public function update(Request $request, Peminjaman $pengembalian)
    {
        // Temukan semua data pengembalian berdasarkan mahasiswa_id atau dosen_id
        $relatedPengembalians = Peminjaman::with(['barang.stock', 'ruangan'])
            ->where('mahasiswa_id', $pengembalian->mahasiswa_id)
            ->orWhere('dosen_id', $pengembalian->dosen_id)
            ->get();

        // Ambil nilai approval_pengembalian dari input request
        $approval_pengembalian = $request->input('aprovals_pengembalian');

        foreach ($relatedPengembalians as $relatedPengembalian) {
            // Logika untuk pengembalian barang
            if ($relatedPengembalian->jenis_peminjaman === 'Barang') {
                $currentStock = $relatedPengembalian->barang->stock->stock ?? null;

                if (is_null($currentStock)) {
                    return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
                }

                $jumlahPinjam = $relatedPengembalian->stock_pinjam;

                if ($approval_pengembalian === 'Ya') {
                    // Update stock only if the item is approved for return
                    $newStock = $currentStock + $jumlahPinjam;

                    if ($newStock >= 0) {
                        $relatedPengembalian->barang->stock->update([
                            'stock' => $newStock,
                        ]);

                        $relatedPengembalian->status = 'Dikembalikan';
                        $relatedPengembalian->status_pengembalian = 'Diserahkan';
                    } else {
                        return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
                    }
                }
            }

            // Logika untuk pengembalian ruangan
            if ($relatedPengembalian->jenis_peminjaman === 'Ruangan') {
                if ($approval_pengembalian === 'Ya') {
                    $relatedPengembalian->status = 'Dikembalikan';
                    $relatedPengembalian->status_pengembalian = 'Diserahkan';
                } elseif ($approval_pengembalian === 'Tidak') {
                    $relatedPengembalian->status = 'Tidak Dikembalikan';
                }
            }

            // Update status dan approval
            $relatedPengembalian->aprovals_pengembalian = $approval_pengembalian;
            $relatedPengembalian->save();
        }

        return redirect()->back()->with('success', 'Semua data pengembalian berhasil diperbarui.');
    }
}
