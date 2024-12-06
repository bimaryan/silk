<?php

namespace App\Imports;

use App\Models\Dosen;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Dosen::create([
                'nama' => $row['nama'],
                'nip' => $row['nip'],
                'email' => $row['email'],
                'username' => $row['username'],
                'password' => Hash::make('@Poli' . $row['nama']),
            ]);
        }
    }
}
