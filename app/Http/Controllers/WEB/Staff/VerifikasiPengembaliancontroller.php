<?php

namespace App\Http\Controllers\WEB\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifikasiPengembaliancontroller extends Controller
{
    public function index()
    {
        return view('pages.staff.verifikasi-pengembalian.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            ''
        ]);
    }
}
