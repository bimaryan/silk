<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Exports\MahasiswaExport;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $query = Mahasiswa::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('nim', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('jenis_kelamin', 'LIKE', "%{$search}%")
                ->orWhereHas('kelas', function ($q) use ($search) {
                    $q->where('nama_kelas', 'LIKE', "%{$search}%");
                });
        }

        $mahasiswa = $query->paginate(5)->appends($request->all());

        return view('pages.admin.pengguna.mahasiswa.index', ['mahasiswa' => $mahasiswa], ['kelas' => $kelas]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            // 'kelas_id' => 'required|string',
        ]);


        $validatedData['password'] = Hash::make('@Poli' . $validatedData['nim']);

        DB::transaction(function () use ($request) {
            $mahasiswa = new Mahasiswa();
            $mahasiswa->nama = $request->nama;
            $mahasiswa->nim = $request->nim;
            // $mahasiswa->kelas_id = $request->kelas_id;
            $mahasiswa->password = Hash::make($request->password);
            $mahasiswa->save();
        });

        return redirect()->back()->with('success', 'Pendaftaran sudah berhasil.');
    }

    public function update(Request $request, Mahasiswa $data_mahasiswa)
    {
        $request->validate([
            'foto' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'nama' => 'required|string',
            'nim' => 'required|string',
            // 'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($request->hasFile('foto')) {
            if ($data_mahasiswa->foto && file_exists(public_path($data_mahasiswa->foto))) {
                unlink(public_path($data_mahasiswa->foto));
            }

            $filepath = $request->file('foto')->move('foto_mahasiswa', time() . '_' . $request->file('foto')->getClientOriginalName());

            $data_mahasiswa->foto = $filepath;
        }

        $data_mahasiswa->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            // 'kelas_id' => $request->kelas_id,
        ]);


        return redirect()->back()->with('success', 'Mahasiswa berhasil di diperbarui!');
    }

    public function destroy(Mahasiswa $data_mahasiswa)
    {
        $data_mahasiswa->delete();
        return redirect()->back()->with('success', 'Mahasiswa berhasil di hapus!');
    }

    public function importMahasiswa(Request $request)
    {
        Excel::import(new MahasiswaImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Mahasiswa berhasil di import!');
    }

    public function exportMahasiswa()
    {
        return Excel::download(new MahasiswaExport, 'data_mahasiswa.xlsx');
    }
}
