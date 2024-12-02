<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Dosen;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Keranjang;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $kategori = $request->input('kategori');

        $notifikasiKeranjang = Keranjang::with(['mahasiswa', 'dosen', 'barang'])
            ->where('users_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $validCategories = ['Alat', 'Bahan'];

        if ($kategori && $kategori !== 'Semua') {
            if (in_array($kategori, $validCategories)) {
                $barangs = Barang::whereHas('kategori', function ($query) use ($kategori) {
                    $query->where('kategori', $kategori);
                })->paginate(6)->appends(['kategori' => $kategori]);
            } else {
                $barangs = collect();
            }
        } else {
            $barangs = Barang::whereHas('kategori', function ($query) use ($validCategories) {
                $query->whereIn('kategori', $validCategories);
            })->paginate(6);
        }

        $kategoris = Kategori::whereIn('kategori', $validCategories)->get();

        $barangKosong = $barangs->isEmpty();

        return view('pages.pengguna.katalog.index', [
            'barangs' => $barangs,
            'kategoris' => $kategoris,
            'barangKosong' => $barangKosong,
            'kategoriTerpilih' => $kategori,
            'notifikasiKeranjang' => $notifikasiKeranjang,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nama_barang)
    {
        $view = Barang::where('nama_barang', $nama_barang)->first();

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

        return view('peminjaman.detailbarang.index', [
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
