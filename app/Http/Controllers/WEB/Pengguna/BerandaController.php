<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        // Data kategori
        $dataKategori = Kategori::all();

        // Filter berdasarkan kategori
        $kategoriName = $request->kategori;

        if ($kategoriName && $kategoriName !== 'semua') {
            $dataBarang = Barang::whereHas('kategori', function ($query) use ($kategoriName) {
                $query->where('kategori', $kategoriName);
            })->with('kategori')->take(8)->get();
        } else {
            $dataBarang = Barang::with('kategori')->take(8)->get();
        }

        // Check jika data barang kosong
        $barangKosong = $dataBarang->isEmpty();


        $notifikasiKeranjang = 0;
        $dataKeranjang = collect();
        $currentUser = auth()->guard('mahasiswa')->user() ?? auth()->guard('dosen')->user();

        if ($currentUser) {
            $dataKeranjang = Keranjang::where('user_id', $currentUser->id)
                ->with('barang')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('barang_id');
        }

        return view('pages.pengguna.beranda.index', [
            'dataBarang' => $dataBarang,
            'dataKategori' => $dataKategori,
            'barangKosong' => $barangKosong,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'dataKeranjang' => $dataKeranjang
        ]);
    }
}
