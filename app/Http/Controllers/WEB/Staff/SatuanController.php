<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Imports\SatuanImport;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::paginate(5);
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

    public function importSatuan(Request $request) {
        $request->validate([
           'file' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file.mimes'=> 'File harus berupa .xlsx, .xls, .csv',
        ]);

        Excel::import(new SatuanImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Mahasiswa berhasil di import!');
    }
}
