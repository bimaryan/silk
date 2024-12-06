<?php

namespace App\Exports;

use App\Models\Ruangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RuanganExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil semua data dan tambahkan nomor urut
        $ruangans = Ruangan::select('nama_ruangan', 'stok_ruangan')->get();

        // Transformasi data untuk menambahkan nomor urut
        return $ruangans->map(function ($item, $index) {
            return [
                'No' => $index + 1, // Tambahkan nomor urut
                'Nama Ruangan' => $item->nama_ruangan,
                'Stok Ruangan' => $item->stok_ruangan,
            ];
        });
    }

    /**
     * Define the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Ruangan',
            'Stok Ruangan',
        ];
    }
}
