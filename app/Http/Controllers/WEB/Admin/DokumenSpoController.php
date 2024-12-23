<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DokumenSpo;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Role;
use Illuminate\Http\Request;

class DokumenSpoController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenSpo::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama_dokumen', 'LIKE', "%{$search}%");
        }

        $dokumen = $query->paginate(5)->appends($request->all());

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

        return view('pages.admin.dokumenspo.index', ['dokumen' => $dokumen, 'notifikasi' => $notifikasi]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $file_path = $request->file('file')->move('dokumen-spo', time() . '_' . $request->file('file')->getClientOriginalName());

        // Pastikan path file berhasil disimpan
        if (!$file_path) {
            return redirect()->back()->with('error', 'Gagal menyimpan file!');
        }

        DokumenSpo::create([
            'nama_dokumen' => $request->nama_dokumen,
            'file' => $file_path,
        ]);

        return redirect()->back()->with('success', 'Dokumen SPO berhasil ditambahkan');
    }

    public function destroy(DokumenSpo $data_spo)
    {
        $data_spo->delete();

        return redirect()->back()->with('success', 'Dokumen SPO berhasil dihapus!');
    }

    public function downloadSPO(DokumenSpo $data_spo)
    {
        $filePath = $data_spo->file;

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return back()->with('error', 'File tidak ditemukan.');
        }
    }
}
