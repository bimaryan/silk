<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'user_id',
        'user_type',
        'peminjaman_id',
        'persetujuan',
        'tindakan_spo_pengguna',
    ];


    public function user()
    {
        return $this->morphTo();
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function pengembalianDetail()
    {
        return $this->hasMany(PengembalianDetail::class);
    }
}
