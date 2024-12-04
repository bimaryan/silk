<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\Persentase;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriAlat = DB::table('kategoris')->where('kategori', 'Alat')->value('id');
        $kategoriBahan = DB::table('kategoris')->where('kategori', 'Bahan')->value('id');

        $satuanIds = DB::table('satuans')->pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            $kategori_id = ($i % 2 == 0) ? $kategoriBahan : $kategoriAlat;

            $barang = Barang::create([
                'nama_barang' => 'Barang Contoh ' . $i,
                'foto' => 'https://placehold.co/600x400.jpg',
                'satuan_id' => $satuanIds[array_rand($satuanIds)],
                'kategori_id' => $kategori_id,
            ]);


            Stock::create([
                'barang_id' => $barang->id,
                'stock' => rand(1, 200),
            ]);
        }
    }
}
