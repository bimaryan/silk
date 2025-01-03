<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::all();
        $query = Admin::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('nip', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%");
        }

        $users = $query->paginate(5)->appends($request->all());

        // Ambil notifikasi terkait peminjaman yang belum diproses
        $peminjamanNotifications = Peminjaman::where('persetujuan', 'Belum Diserahkan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil notifikasi terkait pengembalian yang perlu verifikasi
        $pengembalianNotifications = Pengembalian::where('persetujuan', 'Menunggu Verifikasi')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Gabungkan notifikasi
        $notifikasi = $peminjamanNotifications->merge($pengembalianNotifications);

        return view('pages.admin.pengguna.admindanstaff.index', ['users' => $users, 'role' => $role, 'notifikasi' => $notifikasi]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'username' => 'required',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id',
        ],[
            'nama.required' => 'Nama harus di isi',
            'nip.required' => 'NIP harus di isi',
            'username.required' => 'Username harus di isi',
            'password.required' => 'Password harus di isi',
            'role_id.required' => 'Role harus di isi',
        ]);

        Admin::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'username' => 'required',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id',
        ]);

        $adminstaff = Admin::findOrFail($id);

        $adminstaff->nama = $request->nama;
        $adminstaff->nip = $request->nip;
        $adminstaff->username = $request->username;

        if ($request->filled('password')) {
            $adminstaff->password = Hash::make($request->password);
        }

        $adminstaff->save();

        $role = Role::findOrFail($request->role_id);
        $adminstaff->role()->associate($role);

        return redirect()->back()->with('success', 'Pengguna berhasil di diperbarui!');
    }

    public function destroy(Admin $admin_dan_staff)
    {
        $admin_dan_staff->delete();
        return redirect()->back()->with('success', 'Kelas berhasil di hapus!');
    }
}
