<?php

namespace Database\Seeders;

use App\Models\MataKuliah as ModelsMataKuliah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataKuliah extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsMataKuliah::create([
            'kode_mata_kuliah' => 'RPL-3',
            'mata_kuliah' => 'Pemrograman Web 1'
        ]);
    }
}
