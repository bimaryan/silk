<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DosenExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Dosen::select('nama', 'nip', 'email', 'username')->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIP',
            'Email',
            'Username',
        ];
    }
}
