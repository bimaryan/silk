<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Keranjang;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EditProfileController extends Controller
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
        $kelas = Kelas::all();

        if (Auth::guard('mahasiswa')->check()) {
            $user = Auth::guard('mahasiswa')->user();
        } elseif (Auth::guard('dosen')->check()) {
            $user = Auth::guard('dosen')->user();
        } else {
            abort(404, 'User not found');
        }

        return view('pages.pengguna.profile.editProfile', compact('user', 'kelas', 'notifikasiKeranjang'));
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
