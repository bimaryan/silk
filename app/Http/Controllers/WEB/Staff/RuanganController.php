<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::paginate(5);
        return view("pages.staff.ruangan.index", ["ruangan" => $ruangan]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string'
        ]);

        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string'
        ]);

        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->back()->with('success', 'Ruangan berhasil dihapus!');
    }
}
