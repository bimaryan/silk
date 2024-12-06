<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuanganController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $ruangans = Ruangan::paginate(6);

        $ruanganKosong = $ruangans->isEmpty();

        return view('pages.pengguna.ruangan.index', [
            'user' => $user,
            'ruangans' => $ruangans,
            'ruanganKosong' => $ruanganKosong,
        ]);
    }

    public function show($ruangan)
    {
        $ruangans = Ruangan::where('nama_ruangan', $ruangan)->first();

        if (!$ruangans) {
            return redirect()->route('ruangan.index')->with('error', 'Ruangan tidak ditemukan.');
        }

        return view('pages.pengguna.ruangan.detail.index', [
            'ruangans' => $ruangans,
        ]);
    }

    public function store()
    {
        //INI BUAT PEMINJAMAN RUANGAN
    }

    public function update()
    {
        //INI BUAT UPDATE DARI PEMINJAMAN RUANGAN
    }
}
