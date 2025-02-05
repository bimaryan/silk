<div class="relative overflow-x-auto shadow-lg rounded-lg mt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%"
        id="data-barang">
        <thead class=" text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Peminjam
                </th>
                <th scope="col" class="px-6 py-3">
                    Dosen Pengampu
                </th>
                <th scope="col" class="px-6 py-3">
                    Mata Kuliah
                </th>
                <th scope="col" class="px-6 py-3">
                    Ruang Praktikum
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
            @if ($riwayat->isEmpty())
                <tr>
                    <td colspan="8" class="px-6 py-3 text-center text-gray-500 border">
                        Tidak ada riwayat peminjaman
                    </td>
                </tr>
            @else
                @if ($riwayat->first()->first()->status_pengambalian != 'Diserahkan')
                    @foreach ($riwayat as $userId => $data)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                {{ $data->user->nama }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $data->peminjaman->nama_dosen }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $data->peminjaman->matkul->mata_kuliah }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $data->peminjaman->ruangan->nama_ruangan }}
                            </td>
                            <td class="px-6 py-3">
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    {{ $data->persetujuan }}
                                </span>
                            </td>
                            <td class="flex items-center gap-2 px-6 py-3 justify-center">
                                <button type="button" data-modal-target="detail{{ $data->id }}"
                                    data-modal-toggle="detail{{ $data->id }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @include('components.modal.modalriwayatPengguna', [
                            'riwayat' => $riwayat,
                        ])
                    @endforeach
                @endif
            @endif
        </tbody>
    </table>
</div>
