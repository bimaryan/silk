<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow
{

    // public function model(array $row)
    // {
    //     $kelas = Kelas::firstOrCreate([
    //         'nama_kelas' => $row['kelas'],
    //     ]);

    //     return new Mahasiswa([

    //     ]);
    // }
    public function collection(Collection $collection)
    {
        $error = []; // Array untuk menyimpan pesan error

        foreach ($collection as $key => $row) {
            try {
                // Validasi bahwa kolom 'kelas' ada dan tidak kosong
                if (!isset($row['nama']) || empty($row['nama'])) {
                    throw new Exception("Baris " . ($key + 1) . ": Kolom 'nama' tidak boleh kosong.");
                }
                if (!isset($row['nim']) || empty($row['nim'])) {
                    throw new Exception("Baris " . ($key + 1) . ": Kolom 'nim' tidak boleh kosong.");
                }
                if (!isset($row['kelas']) || empty($row['kelas'])) {
                    throw new Exception("Baris " . ($key + 1) . ": Kolom 'kelas' tidak boleh kosong.");
                }

                $kelas = Kelas::firstOrCreate([
                    'nama_kelas' => $row['kelas']
                ]);

                Mahasiswa::firstOrCreate([
                    'nama' => $row['nama'],
                    'nim' => $row['nim'],
                    'kelas_id' => $kelas->id,
                    'password' => Hash::make('@Poli' . $row['nim']),
                ]);
            } catch (Exception $e) {
                // Tangkap pesan error dan tambahkan ke array
                $error[] = $e->getMessage();
            }
        }

        // Jika ada error, lemparkan exception
        if (!empty($error)) {
            throw new Exception(implode("\n", $error));
        }
    }
}
