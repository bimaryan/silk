<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="data-peminjaman">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nim
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Barang
                </th>
                <th scope="col" class="px-6 py-3">
                    Jumlah Pinjam
                </th>
                <th scope="col" class="px-6 py-3">
                    Tanggal Peminjaman
                </th>
                <th scope="col" class="px-6 py-3">
                    Detail
                </th>
                <th scope="col" class="px-6 py-3">
                    Verifikasi
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($peminjamans as $item)
                @if ($item->status_pengembalian != 'Diserahkan')
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td scope="col" class="px-6 py-3">{{ $loop->iteration }}</td>
                        <td scope="col" class="px-6 py-3">{{ $item->mahasiswa->nim }}</td>
                        <td scope="col" class="px-6 py-3">{{ $item->barang->nama_barang }}</td>
                        <td scope="col" class="px-6 py-3">{{ $item->stock_pinjam }}</td>
                        <td scope="col" class="px-6 py-3">
                            {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            <div>
                                <button type="button" data-modal-target="detail{{ $item->id }}"
                                    data-modal-toggle="detail{{ $item->id }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                @include('components.modal.modaldetailVerifikasipeminjaman')
                            </div>
                        </td>
                        <td scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-6">
                                <form action="{{ route('verifikasi-peminjaman.update', $item->id) }}" method="POST"
                                    class="flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <select name="aprovals" id="aprovals" class="p-1 border rounded-md">
                                            <option value="Belum" {{ $item->aprovals == 'Belum' ? 'selected' : '' }}>
                                                Belum</option>
                                            <option value="Ya" {{ $item->aprovals == 'Ya' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="Tidak" {{ $item->aprovals == 'Tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <button type="submit"
                                            class="p-1 font-medium text-white bg-green-500 rounded-lg">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>