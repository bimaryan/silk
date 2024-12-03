<?php

namespace Database\Seeders;

use App\Models\Stock;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stock = ([
            ['barang_id' => 1,
            'stock' => 10],
            ['barang_id' => 2,
            'stock' => 10],
            ['barang_id' => 3,
            'stock' => 10],
            ['barang_id' => 4,
            'stock' => 10],
            ['barang_id' => 5,
            'stock' => 10],
            ['barang_id' => 6,
            'stock' => 10],
            ['barang_id' => 7,
            'stock' => 10],
            ['barang_id' => 8,
            'stock' => 10],
            ['barang_id' => 9,
            'stock' => 10],
            ['barang_id' => 10,
            'stock' => 10],
        ]);

        Stock::insert($stock);
    }
}
