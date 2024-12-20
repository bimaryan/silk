<?php

namespace App\Http\Controllers\WEB\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\DokumenSPO;
use App\Models\Dosen;
use App\Models\Keranjang;
use App\Models\MataKuliah;
use App\Models\Matkul;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Ruangan;
use App\Models\RuangLaboratorium;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {


        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();

        $dosen = Dosen::all();
        $matkul = MataKuliah::all();
        $ruangLaboratorium = Ruangan::all();
        $dokumenSpo = DokumenSPO::all();

        $dataKeranjang = Keranjang::with('barang')->where('user_id', $userID)->get();
        if ($dataKeranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }
        $barangKosong = $dataKeranjang->isEmpty();



        return view('pages.pengguna.keranjang.index', [
            'dataKeranjang' => $dataKeranjang,
            'barangKosong' => $barangKosong,
            'notifikasiKeranjang' => $dataKeranjang->sum('barang_id'),
            'dosen' => $dosen,
            'matkul' => $matkul,
            'ruangLaboratorium' => $ruangLaboratorium,
            'dokumenSpo' => $dokumenSpo
        ]);
    }

    public function store(Request $request)
    {
        $userID = auth()->id();
        $userType = auth()->user()->getMorphClass();
        $dataKeranjang = Keranjang::with('barang')->where('user_id', $userID)->get();

        if ($dataKeranjang->isEmpty()) {
            return back()->with('error', 'Keranjang Anda kosong. Silakan tambahkan barang terlebih dahulu.');
        }

        $request->validate([
            'waktu_pengembalian' => 'nullable|date_format:H:i',
            'dokumenspo_id' => 'required|exists:dokumen_spos,id',
            'nama_dosen' => 'required|string|max:255',
            'tanggal_waktu_peminjaman' => 'required|date|after_or_equal:today',
            'ruangan_id' => 'required|exists:ruangans,id',
            'matkul_id' => 'required|exists:mata_kuliahs,id',
            'anggota_kelompok' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'user_id' => $userID,
                'user_type' => $userType,
                'matkul_id' => $request->matkul_id,
                'ruangan_id' => $request->ruangan_id,
                'nama_dosen' => $request->nama_dosen,
                'tanggal_waktu_peminjaman' => $request->tanggal_waktu_peminjaman,
                'waktu_pengembalian' => $request->waktu_pengembalian,
                'persetujuan' => 'Belum Diserahkan',
                'dokumenspo_id' => $request->dokumenspo_id,
                'anggota_kelompok' => $request->anggota_kelompok,
                'jenis_peminjaman' => 'Barang',
            ]);

            foreach ($dataKeranjang as $keranjang) {
                PeminjamanDetail::create([
                    'peminjaman_id' => $peminjaman->id,
                    'barang_id' => $keranjang->barang_id,
                    'jumlah_pinjam' => $keranjang->jumlah_pinjam,
                    'tindakan_spo' => $keranjang->tindakan_spo,
                    'status' => 'Diproses',
                    'alasan_penolakan' => null
                ]);
            }

            Keranjang::where('user_id', $userID)->delete();

            DB::commit();
            return redirect()->route('informasi.index')->with('success', 'Peminjaman berhasil dibuat.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses peminjaman: ' . $e->getMessage());
        }
    }
}
