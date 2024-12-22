<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataKeranjang = [
            'barang_id' => 0
        ];

        if (auth()->check()) {
            $dataKeranjang = Keranjang::where('user_id', auth()->id())
                ->with('barang')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('barang_id');
        }

        $user = Auth::user();

        $kelas = Kelas::all();

        return view('pages.pengguna.profile.edit-profile-pengguna', [
            'user' => $user,
            'kelas' => $kelas,
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
    public function update(Request $request)
    {
        if (Auth::guard('dosen')->check()) {
            $user = Auth::guard('dosen')->user();

            $request->validate([
                'nama' => 'required',
                'nip' => 'required',
                'username' => 'required|unique:dosens,username,' . $user->id,
                'email' => 'required|string|email',
                'telepon' => 'required',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user->username = $request->username;
            $user->nip = $request->nip;
        } elseif (Auth::guard('mahasiswa')->check()) {
            $user = Auth::guard('mahasiswa')->user();

            $request->validate([
                'nama' => 'required',
                'nim' => 'required|unique:mahasiswas,nim,' . $user->id,
                'kelas_id' => 'required|exists:kelas,id',
                'email' => 'required|string|email',
                'telepon' => 'required',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user->nim = $request->nim;
            $user->kelas_id = $request->kelas_id;
        } else {
            abort(403, 'Unauthorized');
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->jenis_kelamin = $request->jenis_kelamin;

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('uploads/profile', 'public');
            $user->foto = $fotoPath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
