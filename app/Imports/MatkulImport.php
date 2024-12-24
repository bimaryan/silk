<?php

namespace App\Imports;

use App\Models\MataKuliah;
use Exception;
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
        $error = [];

        foreach ($collection as $key => $row) {
            try {
                if (!isset($row['kd_matkul']) || empty($row['kd_matkul'])) {
                    throw new Exception("Baris " . ($key + 1) . ": Kolom 'kd_matkul' tidak boleh kosong.");
                }
                if (!isset($row['matkul']) || empty($row['matkul'])) {
                    throw new Exception("Baris " . ($key + 1) . ": Kolom 'matkul' tidak boleh kosong.");
                }

                MataKuliah::create([
                    'kode_mata_kuliah' => $row['kd_matkul'],
                    'mata_kuliah' => $row['matkul'],
                ]);
            } catch (Exception $e) {
                $error[] = $e->getMessage();
            }
        }

        if (!empty($error)) {
            throw new Exception(implode("\n", $error));
        }
    }
}
