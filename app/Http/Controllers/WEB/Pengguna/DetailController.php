<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Keranjang;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $view = Barang::find($id);

        if (!$view) {
            return redirect('detail.index')->with('error', 'Data barang tidak ditemukan.');
        }

        $user = Auth::user();

        $notifikasiKeranjang = Keranjang::with(['mahasiswa', 'dosen', 'barang'])
        ->where('users_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

        if (!$view) {
            return redirect('/')->with('error', 'Data barang tidak ditemukan.');
        }

        return view('pages.pengguna.detail.index', [
            'view' => $view,
            'notifikasiKeranjang' => $notifikasiKeranjang
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
    public function store(Request $request, $barang)
    {
        $users = Auth::user();


        $totalBarang = Keranjang::where('users_id', $users->id)->count();

        if ($totalBarang >= 10) {
            return redirect()->route('keranjang.index')->with('error', 'Anda hanya dapat menambahkan maksimal 10 barang ke keranjang.');
        }

        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }
        Keranjang::create([
            'users_id' => $users->id,
            'barang_id' => $barang,
            'stock_pinjam' => $request->stock_pinjam,
            'tindakan_spo' => $request->tindakan_spo
        ]);

        return redirect()->route('beranda.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
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
    public function destroy(string $id)
    {
        //
    }
}
