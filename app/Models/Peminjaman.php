<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'mahasiswa_id',
        'ruangan_id',
        'matkul_id',
        'dosen_id',
        'dokumenspo_id',
        'nama_dosen',
        'barang_id',
        'stock_pinjam',
        'tanggal_waktu_peminjaman',
        'waktu_pengembalian',
        'anggota_kelompok',
        'status_pengembalian',
        'aprovals',
        'aprovals_pengembalian',
        'status',
        'tindakan_spo',
        'keterangan',
        'jenis_peminjaman',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'barang_id');
    }

    public function matkul()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function dokumenspo()
    {
        return $this->belongsTo(DokumenSpo::class, 'dokumenspo_id');
    }
}
