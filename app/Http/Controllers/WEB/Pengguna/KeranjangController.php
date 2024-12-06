<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index(Peminjaman $keranjang)
    {
        // Identifikasi pengguna yang login
        $mahasiswaId = Auth::guard('mahasiswa')->user();
        $dosenId = Auth::guard('dosen')->user();

        if ($mahasiswaId) {
            $keranjang = Peminjaman::where('mahasiswa_id', $mahasiswaId->id)->with('barang')->get();
        } elseif ($dosenId) {
            $keranjang = Peminjaman::where('dosen_id', $dosenId->id)->with('barang')->get();
        } else {
            // Redirect jika tidak ada pengguna yang login
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $matkul = MataKuliah::all();
        $ruangan = Ruangan::all();
        $dosen = Dosen::all();

        return view('pages.pengguna.keranjang.index', compact('keranjang', 'matkul', 'ruangan', 'dosen'));
    }

    public function update(Request $request, Peminjaman $keranjang)
    {
        $request->validate([
            'ruangan_id' => 'nullable|exists:ruangans,id',
            'matkul_id' => 'nullable|exists:mata_kuliahs,id',
            'tanggal_waktu_peminjaman' => 'nullable|date',
            'waktu_pengembalian' => 'nullable|date_format:H:i',
            'anggota_kelompok' => 'nullable|string',
            'nama_dosen' => 'nullable|string'
        ]);

        $mahasiswa_id = $keranjang->mahasiswa_id;
        $dosen_id = $keranjang->dosen_id;

        $peminjaman = Peminjaman::where('mahasiswa_id', $mahasiswa_id)
            ->orWhere('dosen_id', $dosen_id)
            ->get();

        foreach ($peminjaman as $item) {
            $item->update([
                'nama_dosen' => $request->nama_dosen ?? $item->nama_dosen,
                'ruangan_id' => $request->ruangan_id ?? $item->ruangan_id,
                'matkul_id' => $request->matkul_id ?? $item->matkul_id,
                'tanggal_waktu_peminjaman' => $request->tanggal_waktu_peminjaman ?? $item->tanggal_waktu_peminjaman,
                'waktu_pengembalian' => $request->waktu_pengembalian ?? $item->waktu_pengembalian,
                'anggota_kelompok' => $request->anggota_kelompok ?? $item->anggota_kelompok,
                'stock_pinjam_ruangan' => '1',
            ]);
        }

        return redirect()->back()->with('success', 'Permintaan peminjaman berhasil diperbarui. Silakan menunggu persetujuan dari staf.');
    }

    public function destroy(Peminjaman $keranjang)
    {
        // Ambil pengguna yang sedang login
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $dosen = Auth::guard('dosen')->user();

        // Validasi apakah pengguna yang login adalah pemilik keranjang
        if (($mahasiswa && $keranjang->mahasiswa_id !== $mahasiswa->id) ||
            ($dosen && $keranjang->dosen_id !== $dosen->id)
        ) {
            return redirect()->route('keranjang.index')->with('error', 'Akses tidak diizinkan.');
        }

        // Hapus keranjang
        $keranjang->delete();

        return redirect()->route('keranjang.index')
            ->with('success', 'Barang berhasil dihapus dari keranjang.');
    }
}
