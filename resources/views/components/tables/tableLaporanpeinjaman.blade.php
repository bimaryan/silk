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
<<<<<<< HEAD
            @if ($laporan->isEmpty())
=======
            @if ($pengembalian->isEmpty())
>>>>>>> 73a6ef1 (p)
                <tr
                    class="bg-white border-b dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="8" class="px-6 py-4 text-center">Tidak ada data</td>
                </tr>
            @endif
<<<<<<< HEAD
            @foreach ($laporan as $data)
=======
            @foreach ($pengembalian as $data)
>>>>>>> 73a6ef1 (p)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td scope="col" class="px-6 py-3">
                        {{ $loop->iteration }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->user->nama }}
                    </td>
                    <td scope="col" class="px-6 py-3">
<<<<<<< HEAD
                        {{ $data->user->kelas->nama_kelas }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->matkul->mata_kuliah }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->nama_dosen }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->created_at }} / {{ $data->waktu_pengembalian }}
=======
                        {{ $data->user->kelas->nama_kelas ?? '-' }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->peminjaman->matkul->mata_kuliah ?? '-' }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->peminjaman->nama_dosen }}
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->created_at }} / {{ $data->peminjaman->waktu_pengembalian }}
>>>>>>> 73a6ef1 (p)
                    </td>
                    <td scope="col" class="px-6 py-3">
                        {{ $data->persetujuan }}
                    </td>
                    <td scope="col" class="px-6 py-3 text-center">
<<<<<<< HEAD
                        <div>
                            <button type="button" data-modal-target="detail{{ $data->id }}"
                                data-modal-toggle="detail{{ $data->id }}"
                                class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @include('components.modal.modaldetaillaporan', [
                            'laporan' => $laporan,
                        ])
=======
                        <form action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center px-2 py-2 text-sm text-white bg-red-500 rounded">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
>>>>>>> 73a6ef1 (p)
            @endforeach
        </tbody>
    </table>
</div>
