<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSpo extends Model
{
    use HasFactory;

    protected $table = 'dokumen_spos';

    protected $fillable = [
        'nama_dokumen',
        'kategori',
        'sub_kategori',
        'file',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
