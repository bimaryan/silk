<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="data-laporan">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Mahasiswa
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Barang
                </th>
                <th scope="col" class="px-6 py-3">
                    Jumlah Pinjam
                </th>
                <th scope="col" class="px-6 py-3">
                    Tanggal Dipinjam
                </th>
                <th scope="col" class="px-6 py-3">
                    Jam Pinjam
                </th>
                <th scope="col" class="px-6 py-3">
                    Jam Kembali
                </th>
                <th scope="col" class="px-6 py-3">
                    Kondisi
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
            </tr>
        </thead>
        <tbody>
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
                            {{ $data->barang->nama_barang }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->stock_pinjam }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->tgl_pinjam }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->waktu_pinjam }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->waktu_pinjam }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->barang->kondisi->kondisi }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->status }}
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
