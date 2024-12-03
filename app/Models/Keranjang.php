<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs';

    protected $fillable = ['users_id', 'barang_id', 'stock_pinjam', 'tindakan_spo'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
