<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function update(Request $request, Peminjaman $pengembalian)
    {
        // $request->validate([
        //     'catatan' => 'required|string',
        //     'kondisi' => 'required',
        // ]);

        // dd($request->all());

        // $mahasiswa_id = $pengembalian->mahasiswa_id;
        // $dosen_id = $pengembalian->dosen_id;

        // $pengembalians = Peminjaman::where('mahasiswa_id', $mahasiswa_id)
        //     ->orWhere('dosen_id', $dosen_id)
        //     ->findOrFail($pengembalian->id)
        //     ->get();


        // foreach ($pengembalian as $data) {
        //     $data->update([
        //         'status_pengembalian' => $request->status_pengembalian,
        //         'status' => 'Dikembalikan',
        //         'catatan' => $request->catatan,
        //         'kondisi' => $request->kondisi,
        //     ]);
        // }

        // Temukan item peminjaman berdasarkan ID
        // $peminjaman = Peminjaman::findOrFail($pengembalians->id);

        // Update data item
        // Peminjaman::where('mahasiswa_id', $mahasiswa_id)
        //     ->orWhere('dosen_id', $dosen_id)
        //     ->where('id', $pengembalian->id)
        //     ->update([
        //         'status_pengembalian' => $request->status_pengembalian,
        //         'kondisi' => $request->kondisi,
        //         'barang_rusak_atau_hilang' => $request->barang_rusak_atau_hilang,
        //         'catatan' => $request->catatan,
        //         'status' => 'Dikembalikan',
        //     ]);

        $pengembalian->update([
            'status_pengembalian' => $request->status_pengembalian,
            'kondisi' => $request->kondisi,
            'barang_rusak_atau_hilang' => $request->barang_rusak_atau_hilang,
            'catatan' => $request->catatan,
            'status' => 'Menunggu Persetujuan',
        ]);

        return redirect()->route('riwayat.index')->with('success', 'Barang berhasil dikembalikan dan menunggu tahap verifikasi dari staff.');
    }
}
