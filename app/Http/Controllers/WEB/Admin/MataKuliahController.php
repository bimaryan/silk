<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Exports\MataKuliahExport;
use App\Http\Controllers\Controller;
use App\Imports\MatkulImport;
use App\Models\MataKuliah;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = MataKuliah::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('kode_mata_kuliah', 'LIKE', "%{$search}%")
                ->orWhere('mata_kuliah', 'LIKE', "%{$search}%");
        }

        $matakuliah = $query->paginate(5)->appends($request->all());

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

        return view('pages.admin.matakuliah.index', ['matakuliah' => $matakuliah, 'notifikasi' => $notifikasi]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mata_kuliah' => 'required|string',
            'mata_kuliah' => 'required|string',
        ], [
            'kode_mata_kuliah.required' => 'Kode mata kuliah harus diisi',
            'mata_kuliah.required' => 'Mata kuliah harus diisi',
        ]);

        $matakuliah = MataKuliah::create($request->all());

        $matakuliah->save();

        return redirect()->back()->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function update(MataKuliah $data_mata_kuliah, Request $request)
    {
        $request->validate([
            'kode_mata_kuliah' => 'required',
            'mata_kuliah' => 'required',
        ]);

        $data_mata_kuliah->update([
            'kode_mata_kuliah' => $request->kode_mata_kuliah,
            'mata_kuliah' => $request->mata_kuliah
        ]);

        return redirect()->back()->with('success', 'Mata kuliah berhasil diperbarui!');
    }

    public function destroy(MataKuliah $data_mata_kuliah)
    {
        $data_mata_kuliah->delete();

        return redirect()->back()->with('success', 'Mata kuliah berhasil di hapus!');
    }

    public function importMatakuliah(Request $request)
    {
        try {
            // Pastikan file diunggah
            if (!$request->hasFile('file')) {
                return redirect()->back()->with('error', 'Harap unggah file Excel terlebih dahulu.');
            }

            // Jalankan proses impor
            Excel::import(new MatkulImport, $request->file('file'));

            return redirect()->back()->with('success', 'Kelas berhasil diimport!');
        } catch (ValidationException $e) {
            // Tangkap error validasi dari Maatwebsite Excel
            $failures = $e->failures();
            $messages = collect($failures)->map(function ($failure) {
                return "Baris {$failure->row()}: {$failure->errors()[0]}";
            })->implode("\n");

            return redirect()->back()->with('error', "Matkul gagal diimport! Kesalahan:\n" . $messages);
        } catch (Exception $e) {
            // Tangkap error umum lainnya
            return redirect()->back()->with('error', "Matkul gagal diimport! Kesalahan:\n" . $e->getMessage());
        }
    }

    public function exportMataKuliah()
    {
        return Excel::download(new MataKuliahExport, 'data_mata_kuliah.xlsx');
    }
}
