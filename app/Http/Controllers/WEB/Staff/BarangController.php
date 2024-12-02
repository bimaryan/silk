<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Models\Stock;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $notifikasiPeminjaman = Peminjaman::with(['mahasiswa', 'barang'])
            ->where('status', '!=', 'Dikembalikan')
            ->latest()
            ->take(5)
            ->get();

        $query = Barang::query();

        if ($request->has('nama_barang') && $request->name != '') {
            $query->where('nama_barang', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // if ($request->has('kondisi') && $request->kondisi != '') {
        //     $query->whereHas('stock', function ($q) use ($request) {
        //         if ($request->kondisi == 'habis') {
        //             $q->where('stock', 0);
        //         } elseif ($request->kondisi == 'terpakai') {
        //             $q->where('is_stock_reduced', true);
        //         } elseif ($request->kondisi == 'hilang') {
        //             $q->where('is_stock_lost', true);
        //         } else {
        //             $q->where('stock', '>', 0);
        //         }
        //     });
        // }

        if ($request->has('stock') && $request->stock != '') {
            $query->whereHas('stock', function ($q) use ($request) {
                $q->where('stock', '>=', $request->stock);
            });
        }

        if ($request->has('satuan_id') && $request->satuan_id != '') {
            $query->where('satuan_id', $request->satuan_id);
        }

        $barangs = $query->get();

        $kategoris = Kategori::all();
        $satuans = Satuan::all();
        $stocks = Stock::all();

        return view('pages.staff.barang.index', compact('barangs', 'kategoris',  'satuans', 'stocks', 'notifikasiPeminjaman'));
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


        $filePath = $request->file('foto')->move('uploads/barang', time() . '_' . $request->file('foto')->getClientOriginalName());

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'foto' => $filePath,
            'kategori_id' => $request->kategori_id,
            'satuan_id' => $request->satuan_id,
            'kondisi_id' => 4,
        ]);

        Stock::create([
            'barang_id' => $barang->id,
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto && file_exists(public_path($barang->foto))) {
            unlink(public_path($barang->foto));
        }

        $barang->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    public function update(Request $request, Barang $barang)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan_id' => 'required|exists:satuans,id',
        ]);

        // Jika ada file foto yang diupload
        if ($request->hasFile('foto')) {
            // Menghapus foto lama jika ada
            if ($barang->foto && file_exists(public_path('uploads/barang' . $barang->foto))) {
                unlink(public_path('uploads/' . $barang->foto));
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->move('uploads/barang', time() . '_' . $request->file('foto')->getClientOriginalName());
            $barang->foto = $fotoPath;
        }

        // Update data barang
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
}
