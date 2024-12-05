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
                'nama_ruangan' => $row['ruangan'],
                'stok_ruangan' => isset($row['stok']) && is_numeric($row['stok']) ? $row['stok'] : 1,
            ]);
        }
    }
}
