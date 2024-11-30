<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DokumenSpo;
use App\Models\Role;
use Illuminate\Http\Request;

class DokumenSpoController extends Controller
{
    public function index()
    {
        $dokumen = DokumenSpo::get();
        return view('pages.admin.dokumenspo.index', ['dokumen' => $dokumen]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file dan buat nama unik
        $originalName = $request->file('file')->getClientOriginalName();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
        $file_path = $request->file('file')->storeAs('dokumen-spo', $fileName, 'public');

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
}
