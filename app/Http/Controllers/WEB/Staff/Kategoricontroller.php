<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Imports\KategoriImport;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Kategoricontroller extends Controller
{
    public function index()
    {
        $kategori = Kategori::paginate(5);
        return view('pages.staff.kategori.index', ['kategori' => $kategori]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
        ]);

        Kategori::create([
            'kategori' => $request->kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kategori' => 'required|string',
        ]);

        $kategori->update([
            'kategori' => $request->kategori
        ]);

        return redirect()->back()->with('success', 'Kategori updated successfully.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori deleted successfully.');
    }

    public function importKategori(Request $request)
    {
        $request->validate(
            [
                'file' => 'required|mimes:xlsx,xls,csv',
            ],
            [
                'file.mimes' => 'File harus berupa .xlsx, .xls, .csv',
            ]
        );

        Excel::import(new KategoriImport(), $request->file('file'));

        return redirect()->back()->with('success','Kategori berhasil di import');
    }
}
