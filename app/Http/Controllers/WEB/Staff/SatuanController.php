<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::get();
        return view('pages.staff.satuan.index', ['satuan' => $satuan]);
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
}
