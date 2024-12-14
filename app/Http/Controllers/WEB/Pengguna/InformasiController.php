<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['mahasiswa', 'barang.kategori', 'ruangan', 'matkul', 'dosen'])
        ->get()
        ->groupBy(function ($data) {
            return $data->mahasiswa_id ?? $data->dosen_id;
        });

        return view('pages.pengguna.informasi.index', compact('peminjamans'));
    }
}
