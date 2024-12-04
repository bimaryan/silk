<?php

namespace App\Imports;

use App\Models\MataKuliah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MatkulImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            MataKuliah::create([
                "kode_mata_kuliah"=> $row["kd_matkul"],
                "mata_kuliah"=> $row["matkul"],
            ]);
        }
    }
}
