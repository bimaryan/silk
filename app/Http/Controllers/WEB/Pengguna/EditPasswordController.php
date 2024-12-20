<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataKeranjang = [
            'alat_bahan_id' => 0
        ];

        if (auth()->check()) {
            $dataKeranjang = Keranjang::where('user_id', auth()->id())
                ->with('alatBahan')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('alat_bahan_id');
        }

        return view('pages.pengguna.profile.edit-password-pengguna', [
            'dataKeranjang' => $dataKeranjang,
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
    public function update(Request $request, string $user)
    {
        if (Auth::guard('dosen')->check()) {
            $user = Auth::guard('dosen')->user();
            $request->validate([
                'password' => 'required|string',
                'konfirmasi_password' => 'required|string',
            ]);

            $user->password = Hash::make($request->password);
            $user->save();
        } elseif (Auth::guard('mahasiswa')->check()) {
            $user = Auth::guard('mahasiswa')->user();
            $request->validate([
                'password' => 'required|string',
                'konfirmasi_password' => 'required|string',
            ]);

            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            abort(404, 'User not found');
        }

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
