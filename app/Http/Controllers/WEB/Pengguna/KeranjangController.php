<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Auth::user();

        $notifikasiKeranjang = Keranjang::with(['mahasiswa', 'dosen', 'barang'])
            ->where('users_id', $users->id)
            ->latest()
            ->take(5)
            ->get();

        $keranjang = Keranjang::with('barang')
            ->where('users_id', $users->id)
            ->latest()
            ->get();

        return view('pages.pengguna.keranjang.index', compact('keranjang', 'notifikasiKeranjang'));
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
    public function store(Request $request, Keranjang $keranjang)
    { {
            // Validasi input
            $request->validate([
                'dosen_id' => 'required|exists:dosens,id', // Pastikan dosen_id ada di tabel dosens
            ]);

            try {
                // Simpan data ke tabel keranjangs
                $keranjang = new Keranjang();
                $keranjang->users_id = auth()->user()->id; // Mengambil ID pengguna yang login
                $keranjang->dosen_id = $request->dosen_id; // Ambil dari form select
                $keranjang->created_at = now(); // Waktu saat ini
                $keranjang->updated_at = now(); // Waktu saat ini
                $keranjang->save();

                // Redirect dengan pesan sukses
                return redirect()->back()->with('success', 'Data berhasil ditambahkan ke keranjang!');
            } catch (\Exception $e) {
                // Tangani error
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
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
    public function destroy(Keranjang $keranjang)
    {
        // Pastikan mahasiswa hanya dapat menghapus barang miliknya
        if ($keranjang->users_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan');
        }

        $keranjang->delete();

        return redirect()->route('keranjang.index')
            ->with('success', 'Barang berhasil dihapus dari keranjang.');
    }
}
