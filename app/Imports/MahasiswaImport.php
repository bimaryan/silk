<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    
    public function model(array $row)
    {
        $kelas = Kelas::firstOrCreate([
            'nama_kelas' => $row['kelas'],
        ]);

        return new Mahasiswa([
            'nama' => $row['nama'],
            'nim' => $row['nim'],
            'kelas_id' => $kelas->id,
            'password' => Hash::make('@Poli' . $row['nim']),
        ]);
    }
}