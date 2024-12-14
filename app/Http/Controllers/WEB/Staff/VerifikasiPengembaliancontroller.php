<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class VerifikasiPengembaliancontroller extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::paginate(5);
        return view('pages.staff.verifikasi-pengembalian.index', compact('pengembalian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            ''
        ]);
    }
}
