<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Dosen;
use App\Models\Keranjang;
use App\Models\MataKuliah;
use App\Models\Matkul;
use App\Models\Ruangan;
use App\Models\RuangLaboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

        $dosen = Dosen::all();
        $matkul = MataKuliah::all();
        $ruangLaboratorium = Ruangan::all();

        $dataKeranjang = Keranjang::with('barang')->where('user_id', $userID)->get();

        $barangKosong = $dataKeranjang->isEmpty();



        return view('pages.pengguna.keranjang.index', [
            'dataKeranjang' => $dataKeranjang,
            'barangKosong' => $barangKosong,
            'notifikasiKeranjang' => $dataKeranjang->sum('barang_id'),
            'dosen' => $dosen,
            'matkul' => $matkul,
            'ruangLaboratorium' => $ruangLaboratorium,
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
    public function store(Request $request)
    {
        $request->validate(
            [
                'barang_id' => 'required|exists:barangs,id',
                'jumlah_pinjam' => 'required|int|min:1',
                'tindakan_spo' => 'nullable|string',
            ]
        );

        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

        $dataKeranjang = Keranjang::where('user_id', $userID)
            ->where('barang_id', $request->barang_id)
            ->first();

        if ($dataKeranjang) {
            $dataKeranjang->update([
                'jumlah_pinjam' => $dataKeranjang->jumlah_pinjam + $request->jumlah_pinjam,
            ]);
        } else {
            Keranjang::create([
                'user_id' => $userID,
                'user_type' => $userType,
                'barang_id' => $request->barang_id,
                'jumlah' => $request->jumlah,
                'tindakan_spo' => $request->tindakan_spo,
            ]);
        }
        return redirect()->route('katalog.index')->with('success', 'Barang berhasil ditambahkan ke keranjang');
    }

    /**
     * Display the specified resource.
     */
    public function show()
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
        $dataKeranjang = Keranjang::findOrFail($id);

        if ($dataKeranjang->user_id !== auth()->id()) {
            return back()->with('error', 'Keranjang tidak ditemukan');
        }

        $dataKeranjang->delete();
        return back()->with('success', 'Keranjang berhasil dihapus');
    }
}
