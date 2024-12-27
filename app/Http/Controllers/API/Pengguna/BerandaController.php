<?php

namespace App\Http\Controllers\API\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Keranjang;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        // Data kategoriphp artisan vendor:publish --provider=BeyondCode\\ErdGenerator\\ErdGeneratorServiceProvider
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


        if (auth()->check()) {
            $dataKeranjang = Keranjang::where('user_id', auth()->id())
                ->with('barang')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('barang_id');
        }

        return response()->json([
            'dataBarang' => $dataBarang,
            'dataKategori' => $dataKategori,
            'barangKosong' => $barangKosong,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'dataKeranjang' => $dataKeranjang
        ]);
    }
}
