<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = ['barang_id', 'stock'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'stock_id');
    }
}
