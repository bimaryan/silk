<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';

    protected $fillable = [
        'kode_mata_kuliah',
        'mata_kuliah',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'matkul_id');
    }
}
