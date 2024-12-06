<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Exports\RuanganExport;
use App\Http\Controllers\Controller;
use App\Imports\RuanganImport;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            'nama_ruangan' => $request->nama_ruangan,
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

    public function importRuangan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file.mimes' => 'File harus berupa .xlsx, .xls, .csv',
        ]);

        Excel::import(new RuanganImport(), $request->file('file'));
        return redirect()->back()->with('success', 'Ruangan berhasil diimport!');
    }

    public function exportRuangan()
    {
        return Excel::download(new RuanganExport, 'data_ruangan.xlsx');
    }
}
