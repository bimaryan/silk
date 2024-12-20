<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%"
        id="data-barang">
        <thead class=" text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
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
                    Tanggal & Waktu Peminjaman
                </th>
                <th scope="col" class="px-6 py-3">
                    Persetujuan
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($pengembalian->isEmpty())
                <tr>
                    <td colspan="8" class="px-6 py-3 text-center text-gray-500 border">
                        Tidak ada peminjaman
                    </td>
                </tr>
            @else
                @foreach ($pengembalian as $data)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        
                        <td scope="col" class="px-6 py-3">
                            {{ $data->user->nama }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->nama_dosen }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->matkul->mata_kuliah }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->ruangan->nama_ruangan }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->tanggal_waktu_peminjaman ?? '-' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                {{ $data->persetujuan }}
                            </span>
                        </td>
                        <td scope="col" class="flex items-center gap-2 px-6 py-3 justify-center">
                            <div>
                                <button type="button" data-modal-target="pengembalian{{ $data->id }}"
                                    data-modal-toggle="pengembalian{{ $data->id }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    @include('components.modal.modalPengembalian', [
                        'pengembalian' => $pengembalian,
                    ])
                @endforeach
            @endif

        </tbody>
    </table>
</div>