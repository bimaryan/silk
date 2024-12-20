<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function editProfileIndex()
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

        $user = Auth::user();



        return view('pages.pengguna.profile.edit-profile-pengguna', [
            'user' => $user,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang
        ]);
    }

    public function updateProfile(Request $request, string $user)
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
                'kelas' => 'required',
                'email' => 'required|string|email',
                'telepon' => 'required',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user->nim = $request->nim;
            $user->kelas = $request->kelas;
        } else {
            abort(403, 'Unauthorized');
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->jenis_kelamin = $request->jenis_kelamin;

        if ($request->hasFile('foto')) {
            if ($user->foto !== null) {
                File::delete(public_path('foto/' . $user->foto));
            }
            $image = $request->file('foto');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('foto'), $name);
            $user->foto = $name;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }


    public function editPasswordIndex()
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

    public function updatePassword(Request $request, string $user)
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
}
