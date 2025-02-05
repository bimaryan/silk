<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'user_type',
        'matkul_id',
        'ruangan_id',
        'nama_dosen',
        'tanggal_waktu_peminjaman',
        'waktu_pengembalian',
        'persetujuan',
        'dokumenspo_id',
        'anggota_kelompok',
        'jenis_peminjaman',
    ];

    public function user()
    {
        return $this->morphTo();
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function matkul()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }


    public function dokumenspo()
    {
        return $this->belongsTo(DokumenSpo::class, 'dokumenspo_id');
    }

    public function peminjamanDetail()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

}
