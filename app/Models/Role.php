<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_role',
    ];

    const ADMIN = 1;

    const STAFF = 2;

    public function admin() {
        return $this->hasMany(Admin::class);
    }
}
