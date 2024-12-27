<?php

namespace App\Http\Controllers\API\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InformasiController extends Controller
{
    public function indexPeminjaman()
    {
        // Ambil user yang sedang login
        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();


        if (auth()->check()) {
            $dataKeranjang = Keranjang::where('user_id', auth()->id())
                ->with('barang')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('barang_id');
        }

        // Ambil data peminjaman terkait user yang login
        $peminjaman = Peminjaman::where('persetujuan', 'Belum Diserahkan')->with([
            'matkul',
            'ruangan',
            'peminjamanDetail.barang',
            'user',
            'dokumenSpo'
        ])
            ->where('user_id', $userID)
            ->orderBy('created_at', 'desc')
            ->get();

        // Kirim data ke view
        return response()->json([
            'peminjaman' => $peminjaman,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'userType' => $userType,
            'userID' => $userID
        ]);
    }

    public function prosesPengembalian(Request $request, $peminjamanId)
    {
        $request->validate([
            'jumlah_kembali' => 'required|array',
            'jumlah_kembali.*' => 'required|integer',
            'kondisi' => 'required|array',
            'kondisi.*' => 'required|in:Dikembalikan,Hilang,Rusak,Habis',
            'tindakan_spo_pengguna' => 'required|string',
        ]);

        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();
        $peminjaman = Peminjaman::with('peminjamanDetail.barang')->findOrFail($peminjamanId);

        if ($peminjaman->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengembalikan peminjaman ini.');
        }

        DB::beginTransaction();
        try {
            $pengembalian = Pengembalian::updateOrcreate(
                [
                    'peminjaman_id' => $peminjamanId,
                    'user_id' => $userID,
                    'user_type' => $userType,
                ],
                [
                    'persetujuan' => 'Menunggu Verifikasi',
                    'tindakan_spo_pengguna' => $request->tindakan_spo_pengguna,
                ]
            );

            foreach ($peminjaman->peminjamanDetail as $detail) {
                $jumlahKembali = $request->input('jumlah_kembali.' . $detail->id, 0);
                $kondisi = $request->input('kondisi.' . $detail->id);

                if ($jumlahKembali > $detail->jumlah_pinjam) {
                    return response()->json()->with('error', 'Jumlah kembali melebihi batas peminjaman.');
                }

                PengembalianDetail::updateOrCreate(
                    [
                        'pengembalian_id' => $pengembalian->id,
                        'barang_id' => $detail->barang_id,
                    ],
                    [
                        'jumlah_pinjam' => $detail->jumlah_pinjam,
                        'jumlah_kembali' => $jumlahKembali,
                        'kondisi' => $kondisi,
                    ]
                );
            }

            $pengembalian->update([
                'persetujuan' => 'Menunggu Verifikasi',
            ]);

            DB::commit();
            return response()->json()->with('success', 'Pengembalian berhasil diserahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json()->with('error', $e->getMessage());
        }
    }
}
