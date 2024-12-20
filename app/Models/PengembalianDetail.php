<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianDetail extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_details';

    protected $fillable = [
        'pengembalian_id',
        'barang_id',
        'jumlah_pinjam',
        'jumlah_kembali',
        'kondisi',
        'catatan',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
