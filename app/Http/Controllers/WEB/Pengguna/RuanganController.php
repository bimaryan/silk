<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\PeminjamanRuangan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuanganController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $ruangans = Ruangan::paginate(6);

        $notifikasiKeranjang = null;

        if (Auth::guard('mahasiswa')->check()) {
            $notifikasiKeranjang = Peminjaman::where('mahasiswa_id', Auth::guard('mahasiswa')->id())->get();
        } elseif (Auth::guard('dosen')->check()) {
            $notifikasiKeranjang = Peminjaman::where('dosen_id', Auth::guard('dosen')->id())->get();
        }

        $ruanganKosong = $ruangans->isEmpty();

        return view('pages.pengguna.ruangan.index', [
            'user' => $user,
            'ruangans' => $ruangans,
            'ruanganKosong' => $ruanganKosong,
            'notifikasiKeranjang' => $notifikasiKeranjang,
        ]);
    }

    public function store(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
        ]);

        $dosen = Auth::guard('dosen')->user();

        if (!$dosen) {
            return back()->withErrors([
                'auth' => 'Anda harus login sebagai dosen untuk melakukan peminjaman ruangan.',
            ])->withInput();
        }

        if ($ruangan->stok_ruangan < 0) {
            return back()->withErrors([
                'stok' => 'Stok ruangan tidak mencukupi untuk melakukan peminjaman.',
            ])->withInput();
        }

        $ruangan = Ruangan::find($request['ruangan_id']);

        Peminjaman::create([
            'dosen_id' => $dosen ? $dosen->id : null,
            'ruangan_id' => $ruangan->id,
            'jenis_peminjaman' => 'Ruangan',
        ]);

        return redirect()->route('katalog-ruangan.index')->with('success', 'Ruangan berhasil ditambahkan ke keranjang.');
    }
}
