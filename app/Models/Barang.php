<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = ['nama_barang', 'kategori_id', 'satuan_id', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'barang_id', 'id');
    }

    public function peminjamanDetail() 
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function pengembalianDetail()
    {
        return $this->hasMany(PengembalianDetail::class);
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'barang_id');
    }
}
