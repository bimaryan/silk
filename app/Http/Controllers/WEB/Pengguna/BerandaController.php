<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Dosen;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Keranjang;
use App\Models\MataKuliah;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $users = Auth::user();
        $kategori = $request->input('kategori');

        if (!$users) {
            return redirect()->route('login.index')->with('error', 'Anda harus login.');
        }

        if(Auth::guard('mahasiswa')->check()) {
            $notifikasiKeranjang = Peminjaman::get();
        } elseif(Auth::guard('dosen')->check()) {
            $notifikasiKeranjang = Peminjaman::get();
        }

        $validCategories = ['Alat', 'Bahan'];

        if ($kategori && $kategori !== 'Semua') {
            if (in_array($kategori, $validCategories)) {
                $barangs = Barang::whereHas('kategori', function ($query) use ($kategori) {
                    $query->where('kategori', $kategori);
                })->take(6)->get();
            } else {
                $barangs = collect();
            }
        } else {
            $barangs = Barang::whereHas('kategori', function ($query) use ($validCategories) {
                $query->whereIn('kategori', $validCategories);
            })->take(6)->get();
        }

        $kategoris = Kategori::whereIn('kategori', $validCategories)->get();

        $barangKosong = $barangs->isEmpty();

        return view('pages.pengguna.beranda.index', [
            'barangs' => $barangs,
            'kategoris' => $kategoris,
            'barangKosong' => $barangKosong,
            'notifikasiKeranjang' => $notifikasiKeranjang,
        ]);
    }

    public function show(string $nama_barang) {

    }
}
