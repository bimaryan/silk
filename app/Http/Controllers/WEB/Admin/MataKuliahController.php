<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $matakuliah = MataKuliah::get();
        return view('pages.admin.matakuliah.index', ['matakuliah' => $matakuliah]);
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
}
