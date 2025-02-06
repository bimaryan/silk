<?php

namespace App\Exports;

use App\Models\Pengembalian;
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
        return Pengembalian::with(['user', 'peminjaman.peminjamanDetail.barang', 'pengembalianDetail.barang'])
            ->get()
            ->map(function ($data) {
                return [
                    'No' => $data->id,
                    'Nama' => $data->user->nama ?? $data->user->nama,
                    'Kelas' => $data->user->kelas->nama_kelas ?? '-',
                    'Mata Kuliah' => $data->peminjaman->matkul->mata_kuliah,
                    'Dosen Pengampu' => $data->peminjaman->nama_dosen,
                    'TanggalPeminjaman dan Pengembalian' => $data->peminjaman->tanggal_waktu_peminjaman . 'dan' . $data->peminjaman->waktu_pengembalian,
                    'Nama Barang' => $data->pengembalianDetail->pluck('barang.nama_barang')->implode(', '),
                    'Nama Anggota' => $data->peminjaman->anggota_kelompok,
                    'Status' => $data->persetujuan,

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
            'Nama',
            'Kelas',
            'Mata Kuliah',
            'Dosen Pengampu',
            'TanggalPeminjaman dan Pengembalian',
            'Nama Barang',
            'Nama Anggota',
            'Status',
        ];
    }
}
