<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Imports\SatuanImport;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Satuan::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('satuan', 'LIKE', "%{$search}%");
        }

        $satuan = $query->paginate(5)->appends($request->all());

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

        return view('pages.staff.satuan.index', ['satuan' => $satuan, 'notifikasi' => $notifikasi]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'satuan' => 'required|string'
        ]);

        Satuan::create([
            'satuan' => $request->satuan
        ]);

        return redirect()->back()->with('success', 'Satuan berhasil ditambahkan!');
    }

    public function destroy(Request $request, Satuan $satuan)
    {
        $satuan->delete();

        return redirect()->back()->with('success', 'Satuan berhasil dihapus!');
    }

    public function update(Request $request, Satuan $satuan)
    {
        $request->validate([
            'satuan' => 'required|string'
        ]);

        $satuan->update([
            'satuan' => $request->satuan,
        ]);

        return redirect()->back()->with('success', 'Satuan berhasil diperbarui!');
    }

    public function importSatuan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file.mimes' => 'File harus berupa .xlsx, .xls, .csv',
        ]);

        Excel::import(new SatuanImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Mahasiswa berhasil di import!');
    }
}
