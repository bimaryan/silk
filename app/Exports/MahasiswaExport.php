<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MahasiswaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * Mengambil data mahasiswa.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Mahasiswa::with('kelas')
            ->select('id', 'nama', 'nim', 'kelas_id', 'email', 'telepon', 'jenis_kelamin')
            ->get()
            ->map(function ($mahasiswa) {
                return [
                    'ID' => $mahasiswa->id,
                    'Nama' => $mahasiswa->nama,
                    'NIM' => $mahasiswa->nim,
                    'Kelas' => $mahasiswa->kelas ? $mahasiswa->kelas->nama_kelas : 'Tidak Ada',
                    'Email' => $mahasiswa->email,
                    'Telepon' => $mahasiswa->telepon,
                    'Jenis Kelamin' => $mahasiswa->jenis_kelamin,
                ];
            });
    }

    /**
     * Menambahkan heading di atas kolom.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'NIM',
            'Kelas',
            'Email',
            'Telepon',
            'Jenis Kelamin',
        ];
    }
}
