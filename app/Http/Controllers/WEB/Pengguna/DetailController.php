<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Keranjang;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index($id)
    {
        $view = Barang::find($id);

        if (!$view) {
            return redirect('katalog.index')->with('error', 'Data barang tidak ditemukan.');
        }

        return view('pages.pengguna.detail.index', [
            'view' => $view,
        ]);
    }

    public function store(Request $request, Barang $barang)
    {
        $request->validate([
            'tindakan_spo' => 'required|string',
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();
        $dosen = Auth::guard('dosen')->user();

        if (!$mahasiswa && !$dosen) {
            return back()->withErrors([
                'auth' => 'Anda harus login sebagai mahasiswa atau dosen untuk melakukan peminjaman.',
            ])->withInput();
        }

        // Cek apakah barang sudah dipinjam oleh pengguna yang login
        $existingPeminjaman = Peminjaman::where('barang_id', $barang->id)
            ->where(function ($query) use ($mahasiswa, $dosen) {
                if ($mahasiswa) {
                    $query->where('mahasiswa_id', $mahasiswa->id);
                }
                if ($dosen) {
                    $query->where('dosen_id', $dosen->id);
                }
            })->first();

        if ($existingPeminjaman) {
            // Update stock_pinjam jika sudah ada
            $newStock = $existingPeminjaman->stock_pinjam + $request->stock_pinjam;

            if ($newStock > 10) {
                return back()->withErrors([
                    'stock_pinjam' => 'Jumlah total barang yang dipinjam tidak boleh lebih dari 10.',
                ])->withInput();
            }

            $existingPeminjaman->update(['stock_pinjam' => $newStock]);

            return redirect()->route('katalog.index')->with('success', 'Stock pinjam berhasil diperbarui.');
        }

        // Tambahkan peminjaman baru jika belum ada
        Peminjaman::create([
            'mahasiswa_id' => $mahasiswa ? $mahasiswa->id : null,
            'dosen_id' => $dosen ? $dosen->id : null,
            'barang_id' => $barang->id,
            'stock_pinjam' => $request->stock_pinjam,
            'tindakan_spo' => $request->tindakan_spo,
            'jenis_peminjaman' => 'Barang',
        ]);

        return redirect()->route('katalog.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }
}
