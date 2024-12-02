<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Keranjang;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $view = Barang::where('nama_barang', 'LIKE', '%' . request('search') . '%')->first();

        $user = Auth::user();

        $notifikasiKeranjang = Keranjang::with(['mahasiswa', 'dosen', 'barang'])
            ->where('users_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $kelas = Kelas::all();
        $dosen = Dosen::all();
        $matkul = MataKuliah::all();
        $stock = Stock::where('barang_id', $view->id)->first();
        $ruangan = Ruangan::all();

        if (!$view) {
            return redirect('/')->with('error', 'Data barang tidak ditemukan.');
        }

        return view('pages.pengguna.detail.index', [
            'view' => $view,
            'kelas' => $kelas,
            'stock' => $stock,
            'matkul' => $matkul,
            'ruangan' => $ruangan,
            'dosen' => $dosen,
            'notifikasiKeranjang' => $notifikasiKeranjang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Barang $barang)
    {
        $users = Auth::user()->id;

        // Ambil semua barang di keranjang untuk mahasiswa ini
        $totalBarang = Keranjang::where('users_id', $users)->count();

        // Cek apakah total barang di keranjang sudah mencapai batas maksimum
        if ($totalBarang >= 10) {
            return redirect()->route('detail.index', ['nama_barang' => $barang->nama_barang])
                ->with('error', 'Anda hanya dapat menambahkan maksimal 10 barang ke keranjang.');
        }

        // Cek apakah barang sudah ada di keranjang
        $keranjang = Keranjang::where('users_id', $users)
            ->where('barang_id', $barang->id) // Perbaiki dengan $barang->id
            ->first();

        if ($keranjang) {
            // Jika barang sudah ada di keranjang, tambahkan jumlahnya
            $newStock = $keranjang->stock_pinjam + $request->input('stock_pinjam');

            // Pastikan total stock_pinjam tidak melebihi batas maksimum
            if ($newStock > 10) {
                return redirect()->route('detail.index', ['nama_barang' => $barang->nama_barang])
                    ->with('error', 'Jumlah total barang tidak boleh melebihi 10.');
            }

            $keranjang->stock_pinjam = $newStock;
            $keranjang->save();
        } else {
            // Jika barang belum ada di keranjang, tambahkan entri baru
            $stockPinjam = $request->input('stock_pinjam');

            // Pastikan stock_pinjam tidak melebihi batas maksimum
            if ($stockPinjam > 10) {
                return redirect()->route('detail.index', ['nama_barang' => $barang->nama_barang])
                    ->with('error', 'Jumlah barang yang ditambahkan tidak boleh lebih dari 10.');
            }

            Keranjang::create([
                'users_id' => $users,
                'barang_id' => $barang->id, // Perbaiki dengan $barang->id
                'stock_pinjam' => $stockPinjam,
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('katalog.index')
            ->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
