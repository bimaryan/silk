<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Pengembalian;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiPeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::whereIn('persetujuan', ['Belum Diserahkan'])->with([
            'user',
            'peminjamanDetail.barang',
            'ruangan.peminjaman',
        ])
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
        return view('pages.staff.verifikasi-peminjaman.index', compact('peminjaman', 'notifikasi'));
    }

    public function updateStatusBarang(Request $request, string $id)
    {
        $peminjaman = Peminjaman::with('peminjamanDetail')->findOrFail($id);


        $request->validate([
            'status' => 'required|array',
            'status.*' => 'in:Diproses,Diterima,Ditolak',
            'alasan_penolakan' => 'nullable|array'
        ]);

        DB::beginTransaction();
        try {
            $statuses = $request->input('status', []);
            $alasanPenolakan = $request->input('alasan_penolakan', []);

            foreach ($peminjaman->peminjamanDetail as $detail) {
                if (isset($statuses[$detail->id])) {
                    $detail->status = $statuses[$detail->id];

                    if ($detail->status == 'Ditolak') {
                        $detail->jumlah_pinjam = 0;
                        $detail->alasan_penolakan = $alasanPenolakan[$detail->id] ?? 'Tidak ada alasan spesifik';
                    } else {
                        $detail->alasan_penolakan = null;
                    }

                    $detail->save();
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Status barang berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function updatePersetujuan(Request $request, $id)
    {
        $request->validate([
            'persetujuan' => 'required|in:Belum Diserahkan,Diserahkan',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with([
                'peminjamanDetail.barang.stock',
                'matkul',
                'ruangan',
                'peminjamanDetail',
                'dokumenSpo',
                'user'
            ])->findOrFail($id);

            $peminjaman->update([
                'persetujuan' => $request->persetujuan,
            ]);

            if ($request->persetujuan == 'Diserahkan') {
                $pengembalian = Pengembalian::where('peminjaman_id', $peminjaman->id)->first(); // Ambil pengembalian berdasarkan peminjaman_id
                if (!$pengembalian) {
                    $pengembalian = Pengembalian::updateOrCreate(
                        ['peminjaman_id' => $peminjaman->id],
                        [
                            'user_id' => $peminjaman->user_id,
                            'user_type' => $peminjaman->user_type,
                            'persetujuan' => 'Belum Dikembalikan',
                            'tindakan_spo_pengguna' => $peminjaman->tindakan_spo_pengguna
                        ]
                    );
                }
            }


            if ($request->persetujuan == 'Diserahkan') {
                foreach ($peminjaman->peminjamanDetail as $detail) {
                    if ($detail->status == 'Diterima') {
                        $barang = $detail->barang;
                        $stok = $barang->stock;

                        if ($stok && $stok->stock >= $detail->jumlah_pinjam) {
                            $stok->stock -= $detail->jumlah_pinjam;
                            $stok->save();
                        } else {
                            if ($stok->stock < $detail->jumlah_pinjam) {
                                DB::rollBack();
                                return redirect()->back()->with('error', 'Stok alat bahan tidak cukup.');
                            }
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Persetujuan peminjaman berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan : ' . $e->getMessage());
        }
    }
}
