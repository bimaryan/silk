<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satuan::create([
            'satuan' => 'pcs',
        ]);
        Satuan::create([
            'satuan' => 'unit',
        ]);
        Satuan::create([
            'satuan' => 'kg',
        ]);
        Satuan::create([
            'satuan' => 'm',
        ]);
        Satuan::create([
            'satuan' => 'cm',
        ]);
        Satuan::create([
            'satuan' => 'ml',
        ]);
        Satuan::create([
            'satuan' => 'liter',
        ]);
        Satuan::create([
            'satuan' => 'box',
        ]);
        Satuan::create([
            'satuan' => 'pack',
        ]);
    }
}
