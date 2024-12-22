<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use App\Models\Stock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiPengembaliancontroller extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::whereIn('persetujuan', ['Belum Dikembalikan', 'Menunggu Verifikasi'])->with([
            'user',
            'peminjaman.barang',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.staff.verifikasi-pengembalian.index', compact('pengembalian'));
    }

    public function update(Request $request, $pengembalianId)
    {
        $pengembalianDetail = PengembalianDetail::where('pengembalian_id', $pengembalianId)->get();

        DB::beginTransaction();
        try {
            foreach ($pengembalianDetail as $detail) {
                $barangId = $detail->barang_id;
                $jumlahKembali = $detail->jumlah_kembali;
                $kondisi = strtolower($detail->kondisi);

                $stok = Stock::where('barang_id', $barangId)->first();

                if (!$stok) {
                    throw new Exception("Stok untuk barang dengan ID {$barangId} tidak ditemukan.");
                }

                if ($jumlahKembali > 0) {
                    $stokBaru = $stok->stock + $jumlahKembali;

                    // Update stok di tabel stock
                    $stok->update([
                        'stock' => $stokBaru
                    ]);
                }

                if (in_array($kondisi, ['Hilang', 'Rusak'])) {
                    if ($request->catatan[$barangId] === null) {
                        throw new Exception('Catatan tidak boleh kosong');
                    }

                    $pengembalianDetail
                        ->where('pengembalian_id', $pengembalianId)
                        ->where('barang_id', $barangId)
                        ->update([
                            'catatan' => $request->catatan[$barangId],
                    ]);
                }
            }

            Pengembalian::where('id', $pengembalianId)->update([
                'persetujuan' => 'Dikembalikan',
            ]);

            DB::commit();

            return redirect()->route('verifikasi-pengembalian.index')->with('success', 'Pengembalian berhasil disetujui');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
