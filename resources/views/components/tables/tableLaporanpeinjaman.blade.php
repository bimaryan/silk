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
            @if($peminjamans->isEmpty())
            <tr class="bg-white border-b dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                <td colspan="8" class="px-6 py-4 text-center">Tidak ada data</td>
            </tr>
            @endif
            @foreach ($peminjamans as $data)
                @if ($data->status_pengembalian == 'Diserahkan')
                    <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td scope="col" class="px-6 py-3">
                            {{ $loop->iteration }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->mahasiswa->nama }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->kelas->nama_kelas }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->matkul->mata_kuliah }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->dosen->nama }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->created_at }} / {{ $data->waktu_pengembalian }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->status }}
                        </td>
                        <td scope="col" class="px-6 py-3 text-center">
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center px-2 py-2 text-sm text-white bg-red-500 rounded">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
