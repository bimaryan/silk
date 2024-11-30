<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function kelas()
    {
        $kelas = Kelas::get();
        return view('pages.admin.kelas.index', ['kelas' => $kelas]);
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
}
