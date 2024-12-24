<?php

namespace App\Imports;

use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\ValidationException;

class KelasImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $error = []; // Array untuk menyimpan pesan error

        foreach ($collection as $key => $row) {
            try {
                // Validasi bahwa kolom 'kelas' ada dan tidak kosong
                if (!isset($row['kelas']) || empty($row['kelas'])) {
                    throw new \Exception("Baris " . ($key + 1) . ": Kolom 'kelas' tidak boleh kosong.");
                }

                // Masukkan data ke dalam database
                Kelas::create([
                    'nama_kelas' => $row['kelas'],
                ]);
            } catch (\Exception $e) {
                // Tangkap pesan error dan tambahkan ke array
                $error[] = $e->getMessage();
            }
        }

        // Jika ada error, lemparkan exception
        if (!empty($error)) {
            throw new \Exception(implode("\n", $error));
        }
    }
}
