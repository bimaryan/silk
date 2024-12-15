<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function update(Request $request, Peminjaman $pengembalians)
    {
        $request->validate([
            'catatan' => 'required|string',
            'kondisi' => 'required',
        ]);

        $mahasiswa_id = $pengembalians->mahasiswa_id;
        $dosen_id = $pengembalians->dosen_id;

        $pengembalian = Peminjaman::where('mahasiswa_id', $mahasiswa_id)
            ->orWhere('dosen_id', $dosen_id)
            ->get();

        foreach ($pengembalian as $data) {
            $data->update([
                'status_pengembalian' => $request->status_pengembalian,
                'status' => 'Dikembalikan',
                'catatan' => $request->catatan,
                'kondisi' => $request->kondisi,
            ]);
        }

        return redirect()->route('riwayat.index')->with('success', 'Barang berhasil dikembalikan dan menunggu tahap verifikasi dari staff.');
    }
}
