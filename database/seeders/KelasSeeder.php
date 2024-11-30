<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = [
            ['nama_kelas' => 'D3 KP 1A'],
            ['nama_kelas' => 'D3 KP 1B'],
            ['nama_kelas' => 'D3 KP 1C'],
        ];

        foreach ($kelas as $kelas) {
            Kelas::create($kelas);
        }
    }
}
