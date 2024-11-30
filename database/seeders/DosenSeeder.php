<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'nama' => 'Muhammad Anis Al Hilmi',
            'nip' => '199002282019031012',
            'username' => 'anis',
            'email' => 'anis@gmail.com',
            'password' => Hash::make('@Polianis'),
            'jenis_kelamin' => 'Laki-laki',
        ]);
    }
}
