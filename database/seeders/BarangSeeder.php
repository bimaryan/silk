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

        $items = [
            ['nama' => 'Mikroskop Binokuler', 'is_bahan' => false],
            ['nama' => 'Gelas Ukur 100ml', 'is_bahan' => false],
            ['nama' => 'Tabung Reaksi Kaca', 'is_bahan' => false],
            ['nama' => 'Timbangan Digital', 'is_bahan' => false],
            ['nama' => 'Pipet Tetes', 'is_bahan' => false],
            ['nama' => 'Alkohol 70%', 'is_bahan' => true],
            ['nama' => 'Aquadest 1 Liter', 'is_bahan' => true],
            ['nama' => 'Asam Klorida (HCl) 0.1N', 'is_bahan' => true],
            ['nama' => 'Natrium Klorida (NaCl)', 'is_bahan' => true],
            ['nama' => 'Kertas Saring', 'is_bahan' => true],
        ];

        foreach ($items as $item) {
            $kategori_id = $item['is_bahan'] ? $kategoriBahan : $kategoriAlat;

            $barang = Barang::create([
                'nama_barang' => $item['nama'],
                'kategori_id' => $kategori_id,
                'satuan_id' => $satuanIds[array_rand($satuanIds)], // Pilih satuan acak
                'foto' => 'https://placehold.co/600x400.jpg', // Placeholder gambar
            ]);


            Stock::create([
                'barang_id' => $barang->id,
                'stock' => rand(1, 200),
            ]);
        }
    }
}
