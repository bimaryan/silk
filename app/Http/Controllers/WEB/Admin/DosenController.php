<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::get();

        return view('pages.admin.pengguna.dosen.index', compact('dosen'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'username' => 'required',

        ], [
            'nama.required' => 'Nama harus di isi',
            'nip.required' => 'NIP harus di isi',
            'username.required' => 'Username harus di isi',
        ]);

        $validatedData['password'] = Hash::make('polindra');

        Dosen::create($validatedData);

        return redirect()->back()->with('success', 'Pendaftaran sudah berhasil.');
    }

    public function update(Request $request, Dosen $data_dosen)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'username' => 'required',
        ]);

        $data_dosen->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'username' => $request->username,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil di diperbarui!');
    }

    public function destroy(Dosen $data_dosen)
    {
        $data_dosen->delete();

        return redirect()->back()->with('success', 'Mahasiswa berhasil di hapus!');
    }
}
