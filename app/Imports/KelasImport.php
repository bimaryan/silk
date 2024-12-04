<?php

namespace App\Imports;

use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class KelasImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $i = 1;

        foreach ($collection as $row) {
            if ($i > 1) {
                $data['nama_kelas'] = !empty($row[0]) ? $row[0] : '';
                Kelas::create($data);
            }
            $i++;

        }
    }
}
