<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

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

    public function deleteKategori(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori deleted successfully.');
    }
}
