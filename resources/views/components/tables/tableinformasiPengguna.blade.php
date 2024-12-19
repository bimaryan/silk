<div class="relative overflow-x-auto rounded-lg shadow-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="data-barang">
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
                    Tanggal & Waktu Peminjaman
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
            @if ($peminjamans->isEmpty())
                <tr>
                    <td colspan="8" class="px-6 py-3 text-center text-gray-500 border">
                        Tidak ada peminjaman
                    </td>
                </tr>
            @else
                @if ($peminjamans->first()->first()->status === 'Dikembalikan')
                    @foreach ($peminjamans as $userId => $loans)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                @if ($loans->first()->mahasiswa_id)
                                    {{ $loans->first()->mahasiswa->nama }}
                                @elseif ($loans->first()->dosen_id)
                                    {{ $loans->first()->dosen->nama }}
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                {{ $loans->first()->nama_dosen ?? '-' }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $loans->first()->matkul->mata_kuliah ?? '-' }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $loans->first()->ruangan->nama_ruangan ?? '-' }}
                            </td>
                            <td class="px-6 py-3">
                                {{ $loans->first()->tanggal_waktu_peminjaman ?? '-' }}
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $status = $loans->first()->status;
                                @endphp
                                <span
                                    class="text-{{ $status === 'Menunggu Persetujuan' ? 'yellow' : ($status === 'Dipinjamkan' ? 'green' : 'red') }}-100 text-{{ $status === 'Menunggu Persetujuan' ? 'yellow' : ($status === 'Dipinjamkan' ? 'green' : 'red') }}-500 text-xs">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="flex items-center gap-2 px-6 py-3 justify-center">
                                <button type="button" data-modal-target="detail{{ $userId }}"
                                    data-modal-toggle="detail{{ $userId }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                {{-- <button type="button" data-modal-target="pengembalian{{ $userId }}"
                                data-modal-toggle="pengembalian{{ $userId }}"
                                class="flex items-center px-2 py-2 text-sm text-white bg-purple-500 rounded">
                                <i class="fa-solid fa-boxes-packing"></i>
                            </button> --}}
                            </td>
                        </tr>
                    @endforeach
                    @include('components.modal.modalinformasiPengguna')
                    {{-- @include('components.modal.modalpengembalianPengguna') --}}
                @endif
            @endif
        </tbody>
    </table>
</div>
