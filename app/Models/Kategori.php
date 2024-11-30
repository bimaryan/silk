<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = ['kategori'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenSpo::class, 'kategori_id');
    }
}
