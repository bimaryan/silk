<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BarangExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * Mengambil data barang untuk ekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Barang::join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->join('satuans', 'barangs.satuan_id', '=', 'satuans.id')
            ->join('stocks', 'barangs.id', '=', 'stocks.barang_id')
            ->select(
                'barangs.nama_barang',
                'kategoris.kategori as kategori',
                'satuans.satuan as satuan',
                'stocks.stock as stok'
            )
            ->get();
    }

    /**
     * Mengatur header untuk setiap kolom pada file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Barang',
            'Kategori',
            'Satuan',
            'Stok',
        ];
    }
}
