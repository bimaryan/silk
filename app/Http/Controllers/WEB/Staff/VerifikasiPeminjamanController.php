<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class VerifikasiPeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::get();
        return view('pages.staff.verifikasi-peminjaman.index', compact('peminjamans'));
    }

    public function update(Request $request, Peminjaman $verifikasi_peminjaman)
    {
        $peminjaman = Peminjaman::with('stock')->findOrFail($verifikasi_peminjaman->id);

        $currentStock = $peminjaman->stock->stock;

        $approval = $request->input('aprovals');
        $jumlahPinjam = $peminjaman->stock_pinjam;

        if ($approval === 'Ya') {
            $newStock = $currentStock - $jumlahPinjam;

            if ($newStock >= 0) {
                $peminjaman->stock->update([
                    'stock' => $newStock,
                ]);

                $peminjaman->status = 'Dipinjam';
            } else {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }
        }

        $peminjaman->aprovals = $approval;
        $peminjaman->save();

        return redirect()->back()->with('success', 'Status approval peminjaman berhasil diperbarui.');
    }
}
