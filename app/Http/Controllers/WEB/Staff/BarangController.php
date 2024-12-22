<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Exports\BarangExport;
use App\Models\Stock;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\BarangImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        // $notifikasiPeminjaman = Peminjaman::with(['mahasiswa', 'barang'])
        //     ->where('status', '!=', 'Dikembalikan')
        //     ->latest()
        //     ->take(5)
        //     ->get();

        $query = Barang::query();

        $kategoris = Kategori::all();
        $satuans = Satuan::all();
        $stocks = Stock::all();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_barang', 'LIKE', "%{$search}%")
                ->orWhereHas('kategori', function ($q) use ($search) {
                    $q->where('kategori', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('satuan', function ($q) use ($search) {
                    $q->where('satuan', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('stock', function ($q) use ($search) {
                    $q->where('stock', 'LIKE', "%{$search}%");
                });
        }

        $barangs = $query->paginate(5)->appends($request->all());



        return view('pages.staff.barang.index', compact('barangs', 'kategoris', 'satuans', 'stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:1',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan_id' => 'required|exists:satuans,id',
        ], [
            'nama_barang.required' => 'Nama barang harus diisi',
            'stock.required' => 'Stok harus diisi',
            'stock.min' => 'Stok minimal 1',
        ]);


        $filePath = null;
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('uploads/barang', 'public');
        }

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'foto' => $filePath,
            'kategori_id' => $request->kategori_id,
            'satuan_id' => $request->satuan_id,
        ]);

        Stock::create([
            'barang_id' => $barang->id,
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan_id' => 'required|exists:satuans,id',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('uploads/barang', 'public');
            $barang->foto = $fotoPath;
        }

        $barang->update([
            'nama_barang' => $request->input('nama_barang'),
            'kategori_id' => $request->input('kategori_id'),
            'satuan_id' => $request->input('satuan_id'),
        ]);

        $stock = $barang->stock()->firstOrCreate(['barang_id' => $barang->id]);
        $stock->update([
            'stock' => $request->input('stock'),
        ]);

        return redirect()->back()->with('success', 'Barang berhasil diperbarui!');
    }

    public function importBarang(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ], [
            'file.mimes' => 'File harus berupa .xls, .xlsx'
        ]);

        Excel::import(new BarangImport, $request->file('file'));
        return redirect()->back()->with('success', 'Barang Berhasil di import');
    }

    public function exportBarang()
    {
        return Excel::download(new BarangExport, 'data_barang.xlsx');
    }
}
