<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * Return collection of data for export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Peminjaman::with(['mahasiswa', 'barang.kondisi'])
            ->get()
            ->map(function ($data) {
                return [
                    'No' => $data->id,
                    'Nama Mahasiswa' => $data->mahasiswa->nama,
                    'Nama Barang' => $data->barang->nama_barang,
                    'Jumlah Pinjam' => $data->stock_pinjam,
                    'Tanggal Pinjam' => $data->tgl_pinjam,
                    'Waktu Pinjam' => $data->waktu_pinjam,
                    'Waktu Kembali' => $data->waktu_kembali,
                    'Kondisi Barang' => $data->barang->kondisi->kondisi,
                    'Status' => $data->status,
                ];
            });
    }

    /**
     * Return headings for each column.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Mahasiswa',
            'Nama Barang',
            'Jumlah Pinjam',
            'Tanggal Pinjam',
            'Waktu Pinjam',
            'Waktu Kembali',
            'Kondisi Barang',
            'Status',
        ];
    }
}
