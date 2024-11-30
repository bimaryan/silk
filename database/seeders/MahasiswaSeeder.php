<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create([
            'nama' => 'Gustian Prayoga Januar',
            'nim' => '2205042',
            'email' => 'mahasiswa1@gmail.com',
            'password' => Hash::make('mahasiswa'),
            'kelas_id' => 1,
        ]);

        Mahasiswa::create([
            'nama' => 'Bima Ryan Alfarizi',
            'nim' => '2205036',
            'email' => 'crazygamedev212@gmail.com',
            'password' => Hash::make('mahasiswa'),
            'kelas_id' => 2,
        ]);
    }
}
