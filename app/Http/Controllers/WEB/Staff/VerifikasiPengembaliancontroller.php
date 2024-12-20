<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class VerifikasiPengembaliancontroller extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::whereIn('persetujuan', ['Belum Dikembalikan'])->with([
            'user',
            'peminjaman.barang',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.staff.verifikasi-pengembalian.index', compact('pengembalian'));
    }

    public function update(Request $request, Peminjaman $pengembalian)
    {

        // Ambil nilai approval_pengembalian dari input request
        $persetujuanPengembalian = $request->input('persetujuan');

        foreach ($persetujuanPengembalian as $pengembalian) {
            // Logika untuk pengembalian barang
            if ($pengembalian->jenis_peminjaman === 'Barang') {
                $datastok = $pengembalian->barang->stock->stock ?? null;

                if (is_null($datastok)) {
                    return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
                }

                $jumlahPinjam = $pengembalian->stock_pinjam;
                $catatan = $request->input('catatan', 0); // Ambil jumlah barang rusak atau hilang, default 0

                // Jika barang rusak atau hilang, kurangi stok pinjamannya
                $jumlahDikembalikan = $jumlahPinjam - $catatan;

                // Pastikan jumlah dikembalikan tidak negatif
                if ($jumlahDikembalikan < 0) {
                    return redirect()->back()->with('error', 'Jumlah barang rusak atau hilang melebihi jumlah yang dipinjam.');
                }

                if ($persetujuanPengembalian === 'Dikembalikan') {
                    // Update stock only if the item is approved for return
                    $newStock = $jumlahPinjam + $jumlahDikembalikan;

                    if ($newStock >= 0) {
                        // Update stock
                        $pengembalian->barang->stock->update([
                            'stock' => $newStock,
                        ]);

                        // Update status pengembalian
                        $updatedPengembalian->status = 'Dikembalikan';
                        $updatedPengembalian->status_pengembalian = 'Diserahkan';
                    } else {
                        return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
                    }
                }
            }

        }

        return redirect()->back()->with('success', 'Semua data pengembalian berhasil diperbarui.');
    }

    // public function update(Request $request, Peminjaman $pengembalian)
    // {
    //     // Temukan semua data pengembalian berdasarkan mahasiswa_id atau dosen_id
    //     $relatedPengembalians = Peminjaman::with(['barang.stock', 'ruangan'])
    //         ->where('mahasiswa_id', $pengembalian->mahasiswa_id)
    //         ->orWhere('dosen_id', $pengembalian->dosen_id)
    //         ->get();

    //     // Ambil nilai approval_pengembalian dari input request
    //     $approval_pengembalian = $request->input('aprovals_pengembalian');

    //     foreach ($relatedPengembalians as $relatedPengembalian) {
    //         // Logika untuk pengembalian barang
    //         if ($relatedPengembalian->jenis_peminjaman === 'Barang') {
    //             $currentStock = $relatedPengembalian->barang->stock->stock ?? null;

    //             if (is_null($currentStock)) {
    //                 return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
    //             }

    //             $jumlahPinjam = $relatedPengembalian->stock_pinjam;

    //             if ($approval_pengembalian === 'Ya') {
    //                 // Update stock only if the item is approved for return
    //                 $newStock = $currentStock + $jumlahPinjam;

    //                 if ($newStock >= 0) {
    //                     $relatedPengembalian->barang->stock->update([
    //                         'stock' => $newStock,
    //                     ]);

    //                     $relatedPengembalian->status = 'Dikembalikan';
    //                     $relatedPengembalian->status_pengembalian = 'Diserahkan';
    //                 } else {
    //                     return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
    //                 }
    //             }
    //         }

    //         // Logika untuk pengembalian ruangan
    //         if ($relatedPengembalian->jenis_peminjaman === 'Ruangan') {
    //             if ($approval_pengembalian === 'Ya') {
    //                 $relatedPengembalian->status = 'Dikembalikan';
    //                 $relatedPengembalian->status_pengembalian = 'Diserahkan';
    //             } elseif ($approval_pengembalian === 'Tidak') {
    //                 $relatedPengembalian->status = 'Tidak Dikembalikan';
    //             }
    //         }

    //         // Update status dan approval
    //         $relatedPengembalian->aprovals_pengembalian = $approval_pengembalian;
    //         $relatedPengembalian->save();
    //     }

    //     return redirect()->back()->with('success', 'Semua data pengembalian berhasil diperbarui.');
    // }

    // public function update(Request $request, Peminjaman $pengembalian)
    // {
    //     // Temukan semua data pengembalian berdasarkan mahasiswa_id atau dosen_id
    //     $relatedPengembalians = Peminjaman::with(['barang.stock', 'ruangan'])
    //         ->where('mahasiswa_id', $pengembalian->mahasiswa_id)
    //         ->orWhere('dosen_id', $pengembalian->dosen_id)
    //         ->get();

    //     // Ambil nilai approval_pengembalian dari input request
    //     $approval_pengembalian = $request->input('aprovals_pengembalian');
    //     $barang_rusak_atau_hilang = $request->input('barang_rusak_atau_hilang', 0); // Ambil jumlah barang rusak/hilang

    //     foreach ($relatedPengembalians as $relatedPengembalian) {
    //         // Logika untuk pengembalian barang
    //         if ($relatedPengembalian->jenis_peminjaman === 'Barang') {
    //             $currentStock = $relatedPengembalian->barang->stock->stock ?? null;

    //             if (is_null($currentStock)) {
    //                 return redirect()->back()->with('error', 'Data stok tidak ditemukan.');
    //             }

    //             $jumlahPinjam = $relatedPengembalian->stock_pinjam;

    //             if ($approval_pengembalian === 'Ya') {
    //                 // Logika jika ada barang yang rusak atau hilang
    //                 if ($barang_rusak_atau_hilang > 0) {
    //                     // Kurangi jumlah barang yang rusak/hilang dari jumlah yang dipinjam
    //                     $jumlahPinjam -= $barang_rusak_atau_hilang;

    //                     // Jika jumlah pinjam setelah dikurangi barang rusak/hilang tetap positif
    //                     if ($jumlahPinjam < 0) {
    //                         $jumlahPinjam = 0; // Jika lebih kecil dari 0, set ke 0
    //                     }

    //                     // Update stok barang
    //                     $newStock = $currentStock - $barang_rusak_atau_hilang;
    //                 } else {
    //                     // Jika tidak ada barang rusak/hilang, update stok seperti biasa
    //                     $newStock = $currentStock + $jumlahPinjam;
    //                 }

    //                 if ($newStock >= 0) {
    //                     // Update stok barang yang tersedia
    //                     $relatedPengembalian->barang->stock->update([
    //                         'stock' => $newStock,
    //                     ]);

    //                     // Update status pengembalian
    //                     $relatedPengembalian->status = 'Dikembalikan';
    //                     // $relatedPengembalian->status_pengembalian = 'Diserahkan';
    //                 } else {
    //                     return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
    //                 }
    //             }
    //         }

    //         // Logika untuk pengembalian ruangan
    //         if ($relatedPengembalian->jenis_peminjaman === 'Ruangan') {
    //             if ($approval_pengembalian === 'Ya') {
    //                 $relatedPengembalian->status = 'Dikembalikan';
    //                 // $relatedPengembalian->status_pengembalian = 'Diserahkan';
    //             } elseif ($approval_pengembalian === 'Tidak') {
    //                 // $relatedPengembalian->status = 'Tidak Dikembalikan';
    //             }
    //         }

    //         // Update status dan approval
    //         $relatedPengembalian->aprovals_pengembalian = $approval_pengembalian;
    //         $relatedPengembalian->save();
    //     }

    //     return redirect()->back()->with('success', 'Semua data pengembalian berhasil diperbarui.');
    // }

    
}
