<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataKategori = Kategori::all(); // Mengambil semua kategori

        $kategoriName = $request->kategori;

        // Query barang sesuai filter kategori
        $query = Barang::with('kategori');

        $searchQuery = $request->search;

        if ($searchQuery) {
            $query->where('nama_barang', 'like', "%{$searchQuery}%");
        }

        if ($kategoriName && $kategoriName !== 'semua') {
            $query->whereHas('kategori', function ($query) use ($kategoriName) {
                $query->where('kategori', $kategoriName);
            });
        }

        // Lakukan pagination
        $dataBarang = $query->paginate(5)->appends($request->all());

        // Tentukan jika barang kosong
        $barangKosong = $dataBarang->isEmpty();

        $dataKeranjang = [];
        $notifikasiKeranjang = 0;

        if (auth()->check()) {
            $dataKeranjang = Keranjang::where('user_id', auth()->id())
                ->with('barang')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->count();
        }

        return view('pages.pengguna.katalog.index', [
            'dataBarang' => $dataBarang,
            'dataKategori' => $dataKategori,
            'barangKosong' => $barangKosong,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
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
                'tindakan_spo' => $request->tindakan_spo,
            ]);
        } else {
            Keranjang::create([
                'user_id' => $userID,
                'user_type' => $userType,
                'barang_id' => $request->barang_id,
                'jumlah_pinjam' => $request->jumlah_pinjam,
                'tindakan_spo' => $request->tindakan_spo,
            ]);
        }
        return redirect()->route('katalog.index')->with('success', 'Barang berhasil ditambahkan ke keranjang');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil data barang berdasarkan ID
        $userID = auth()->id();

        $data = Barang::with(['kategori', 'stock', 'satuan'])->findOrFail($id);

        $dataKeranjang = Keranjang::with('barang')->where('user_id', $userID)->get();

        if (auth()->check()) {
            $dataKeranjang = Keranjang::where('user_id', auth()->id())
                ->with('barang')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('barang_id');
        }

        return view('pages.pengguna.detail.index', [
            'data' => $data,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
        ]);
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
