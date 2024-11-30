<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nip', 'username', 'email', 'password', 'role_id', 'foto'];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
