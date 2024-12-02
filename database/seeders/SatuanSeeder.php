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
        $satuans = [
            [
                'satuan' => 'pcs',
            ],
            [
                'satuan' => 'unit',
            ],
            [
                'satuan' => 'kg',
            ],
            [
                'satuan' => 'm',
            ],
            [
                'satuan' => 'cm',
            ],
            [
                'satuan' => 'ml',
            ],
            [
                'satuan' => 'liter',
            ],
            [
                'satuan' => 'box',
            ],
            [
                'satuan' => 'pack',
            ],
        ];

        foreach ($satuans as $satuan) {
            Satuan::create($satuan);
        }
    }
}
