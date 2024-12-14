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
        // Check if the authenticated user is a 'mahasiswa' or 'dosen'
        if (Auth::guard('mahasiswa')->check()) {
            $user = Auth::guard('mahasiswa')->user();
            $peminjamans = Peminjaman::with(['mahasiswa', 'barang.kategori', 'ruangan', 'matkul', 'dosen'])
                ->where('mahasiswa_id', $user->id)
                ->get()
                ->groupBy(function ($data) {
                    return $data->mahasiswa_id;
                });
        } elseif (Auth::guard('dosen')->check()) {
            $user = Auth::guard('dosen')->user();
            $peminjamans = Peminjaman::with(['mahasiswa', 'barang.kategori', 'ruangan', 'matkul', 'dosen'])
                ->where('dosen_id', $user->id)
                ->get()
                ->groupBy(function ($data) {
                    return $data->dosen_id;
                });
        } else {
            // Handle case if user is not authenticated
            return redirect()->route('login'); // or any other route
        }

        return view('pages.pengguna.informasi.index', compact('peminjamans'));
    }
}
