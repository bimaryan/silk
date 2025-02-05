<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%">
        <thead class=" text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Peminjam
                </th>
                <th scope="col" class="px-6 py-3">
                    Kelas
                </th>
                <th scope="col" class="px-6 py-3">
                    Mata Kuliah
                </th>
                <th scope="col" class="px-6 py-3">
                    Dosen Pengampu
                </th>
                <th scope="col" class="px-6 py-3">
                    Tanggal Peminjaman dan Pengembalian
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @if (!$laporan->isEmpty())
                @foreach ($laporan as $data)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td scope="col" class="px-6 py-3">
                            {{ $loop->iteration }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->user->nama ?? 'N/A' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->user->kelas->nama_kelas ?? 'N/A' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->peminjaman->matkul->mata_kuliah ?? 'N/A' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->peminjaman->nama_dosen ?? 'N/A' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->peminjaman->tanggal_waktu_peminjaman }} / {{ $data->peminjaman->waktu_pengembalian ?? 'N/A' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->persetujuan ?? 'N/A' }}
                        </td>
                        <td scope="col" class="px-6 py-3 text-center">
                            <div>
                                <button type="button" data-modal-target="detail{{ $data->id }}"
                                    data-modal-toggle="detail{{ $data->id }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                @include('components.modal.modallaporan', ['data' => $data])
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="px-6 py-3 text-center">
                        Tidak ada data laporan peminjaman.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
