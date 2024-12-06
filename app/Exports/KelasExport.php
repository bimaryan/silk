<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KelasExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Kelas::select('nama_kelas')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Kelas'
        ];
    }
}
