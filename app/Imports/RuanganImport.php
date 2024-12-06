<?php

namespace App\Imports;

use App\Models\Ruangan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RuanganImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        foreach ($collection as $row) {
            Ruangan::create([
                'nama_ruangan' => $row['nama_ruangan'],
                'stok_ruangan' => isset($row['stok_ruangan']) && is_numeric($row['stok_ruangan']) ? $row['stok_ruangan'] : 1,
            ]);
        }
    }
}
