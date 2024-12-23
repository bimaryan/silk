<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Exports\KelasExport;
use App\Http\Controllers\Controller;
use App\Imports\KelasImport;
use App\Models\Kelas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama_kelas', 'LIKE', "%{$search}%");
        }

        $kelas = $query->paginate(5)->appends($request->all());

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

        return view('pages.admin.kelas.index', ['kelas' => $kelas, 'notifikasi' => $notifikasi]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
        ], [
            'nama_kelas.required' => 'Kelas harus di isi',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function update(Kelas $data_kelas, Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
        ]);

        $data_kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(Kelas $data_kelas)
    {
        $data_kelas->delete();
        return redirect()->back()->with('success', 'Kelas berhasil di hapus!');
    }

    public function importKelas(Request $request)
    {
        Excel::import(new KelasImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Kelas berhasil di import!');
    }

    public function exportKelas()
    {
        return Excel::download(new KelasExport, 'data_kelas.xlsx');
    }
}
