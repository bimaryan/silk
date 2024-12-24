<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Exports\KelasExport;
use App\Http\Controllers\Controller;
use App\Imports\KelasImport;
use App\Models\Kelas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Validators\ValidationException;
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

        return view('pages.admin.kelas.index', compact('kelas', 'notifikasi'));
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Perbarui data kelas berdasarkan ID
            $kelas = Kelas::findOrFail($id); // Pastikan ID valid
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
            ]);

            DB::commit(); // Commit transaksi jika berhasil
            return redirect()->back()->with('success', 'Kelas berhasil diperbarui!');
        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback transaksi jika gagal
            return redirect()->back()->with('error', 'Kelas gagal diperbarui! ' . $th->getMessage());
        }
    }

    public function destroy(Kelas $data_kelas)
    {
        $data_kelas->delete();
        return redirect()->back()->with('success', 'Kelas berhasil di hapus!');
    }

    public function importKelas(Request $request)
    {
        try {
            // Pastikan file diunggah
            if (!$request->hasFile('file')) {
                return redirect()->back()->with('error', 'Harap unggah file Excel terlebih dahulu.');
            }

            // Jalankan proses impor
            Excel::import(new KelasImport, $request->file('file'));

            return redirect()->back()->with('success', 'Kelas berhasil diimport!');
        } catch (ValidationException $e) {
            // Tangkap error validasi dari Maatwebsite Excel
            $failures = $e->failures();
            $messages = collect($failures)->map(function ($failure) {
                return "Baris {$failure->row()}: {$failure->errors()[0]}";
            })->implode("\n");

            return redirect()->back()->with('error', "Kelas gagal diimport! Kesalahan:\n" . $messages);
        } catch (Exception $e) {
            // Tangkap error umum lainnya
            return redirect()->back()->with('error', "Kelas gagal diimport! Kesalahan:\n" . $e->getMessage());
        }
    }



    public function exportKelas()
    {
        return Excel::download(new KelasExport, 'data_kelas.xlsx');
    }
}
