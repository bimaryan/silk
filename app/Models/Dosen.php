<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';

    protected $fillable = [
        'nama',
        'nip',
        'username',
        'password',
        'email',
        'telepon',
        'jenis_kelamin',
        'foto',
    ];

    // public function dosen()
    // {
    //     return $this->hasMany(Peminjaman::class, 'dosen_id');
    // }

    public function keranjang()
    {
        return $this->morphMany(Keranjang::class, 'user');
    }

    public function peminjaman()
    {
        return $this->morphMany(Peminjaman::class, 'user');
    }

    public function pengembalian()
    {
        return $this->morphMany(Pengembalian::class, 'user');
    }
}
