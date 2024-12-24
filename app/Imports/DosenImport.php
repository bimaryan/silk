<?php

namespace App\Imports;

use App\Models\Dosen;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $error = [];
        foreach ($collection as $key => $row) {

            if (!isset($row['nama']) || empty($row['nama'])) {
                throw new Exception("Baris " . ($key + 1) . ": Kolom 'nama' tidak boleh kosong.");
            }
            if (!isset($row['nip']) || empty($row['nip'])) {
                throw new Exception("Baris " . ($key + 1) . ": Kolom 'nip' tidak boleh kosong.");
            }
            if (!isset($row['username']) || empty($row['username'])) {
                throw new Exception("Baris " . ($key + 1) . ": Kolom 'username' tidak boleh kosong.");
            }

            Dosen::firstOrCreate([
                'nama' => $row['nama'],
                'nip' => $row['nip'],
                'username' => $row['username'],
                'password' => Hash::make('@Poli' . $row['username']),
            ]);
            try {
            } catch (Exception $e) {
                $error[] = $e->getMessage();
            }
        }

        if (!empty($error)) {
            throw new Exception(implode("\n", $error));
        }
    }
}
