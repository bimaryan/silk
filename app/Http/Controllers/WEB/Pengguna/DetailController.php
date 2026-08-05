<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\AlatBahan;
use App\Models\Barang;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Barang::where('id', $request->id)->first();

        $dataKeranjang = collect();
        $notifikasiKeranjang = 0;
        $currentUser = auth()->guard('mahasiswa')->user() ?? auth()->guard('dosen')->user();

        if ($currentUser) {
            $dataKeranjang = Keranjang::where('user_id', $currentUser->id)
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
        //
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
