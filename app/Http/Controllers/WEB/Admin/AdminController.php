<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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

        return view('pages.admin.pengguna.admindanstaff.index', ['users' => $users], ['role' => $role]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'username' => 'required',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id',
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

    public function update(Request $request, Admin $admin_dan_staff)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'username' => 'required',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id',
        ]);

        $admin_dan_staff->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil di diperbarui!');
    }

    public function destroy(Admin $admin_dan_staff)
    {
        $admin_dan_staff->delete();
        return redirect()->back()->with('success', 'Kelas berhasil di hapus!');
    }
}
