<?php

namespace App\Imports;

use App\Models\Stock;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kondisi;
use App\Models\Kategori;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Cari atau buat kategori, kondisi, dan satuan berdasarkan nama dari Excel
            $kategori = Kategori::firstOrCreate(['kategori' => $row['kategori']]);
            $kondisi = Kondisi::firstOrCreate(['kondisi' => $row['kondisi'] ?? 'baik']);
            $satuan = Satuan::firstOrCreate(['satuan' => $row['satuan']]);

            // Buat barang baru dengan relasi yang benar
            $barang = Barang::create([
                'nama_barang' => $row['nama_barang'],
                'kategori_id' => $kategori->id,
                'kondisi_id' => $kondisi->id,
                'satuan_id' => $satuan->id,
            ]);

            // Buat stok barang
            Stock::create([
                'barang_id' => $barang->id,
                'stock' => $row['stok'],
            ]);
        }
    }
}

