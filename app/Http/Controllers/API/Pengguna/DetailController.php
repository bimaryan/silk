<?php

namespace App\Http\Controllers\API\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index($nama_barang)
    {
        $detailBarang = Barang::with(['kategori', 'satuan'])
        ->where('nama_barang', $nama_barang)
        ->first();

        if (!$detailBarang) {
            return response()->json(['error' => 'Data barang tidak ditemukan.'], 404);
        }

        return response()->json([
            'messages' => 'Detail Barang',
            'data' => $detailBarang,
        ]);
    }
}
