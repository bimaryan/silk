<?php

namespace App\Exports;

use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MataKuliahExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MataKuliah::select('kode_mata_kuliah', 'mata_kuliah')->get();
    }

    public function headings(): array
    {
        return [
            'Kode Mata Kuliah',
            'Mata Kuliah',
        ];
    }
}
