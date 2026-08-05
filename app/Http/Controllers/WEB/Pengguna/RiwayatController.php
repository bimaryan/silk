<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $currentUser = auth()->guard('mahasiswa')->user() ?? auth()->guard('dosen')->user();

        // Data keranjang untuk pengguna yang sedang login
        $notifikasiKeranjang = 0;
        $dataKeranjang = collect();
        $riwayat = collect();
        $userType = null;
        $userID = null;

        if ($currentUser) {
            $userID = $currentUser->id;
            $userType = $currentUser->getMorphClass();
            $dataKeranjang = Keranjang::where('user_id', $userID)
                ->with('barang')
                ->get();

            // Hitung jumlah total item di keranjang
            $notifikasiKeranjang = $dataKeranjang->sum('barang_id');

            // Ambil data peminjaman terkait user yang login
            $riwayat = Pengembalian::with([
                 'peminjaman.peminjamanDetail.barang',
                'user',
            ])->whereIn('persetujuan', ['Dikembalikan'])->where('user_id', $userID)->orderBy('created_at', 'desc')->get();
        }

        // Kirim data ke view
        return view('pages.pengguna.riwayat.index', [
            'riwayat' => $riwayat,
            'dataKeranjang' => $dataKeranjang,
            'notifikasiKeranjang' => $notifikasiKeranjang,
            'userType' => $userType,
            'userID' => $userID
        ]);
    }

}
