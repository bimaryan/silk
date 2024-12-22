<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%"
        id="data-barang">
        <thead class=" text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
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
                    Nama Ruangan
                </th>
                <th scope="col" class="px-6 py-3">
                    Tanggal & Waktu Peminjaman
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Detail Barang
                </th>
                <th scope="col" class="px-6 py-3">
                    Persetujuan
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($peminjaman->isEmpty())
                <tr>
                    <td colspan="9" class="px-6 py-3 text-center text-gray-500 border">
                        Tidak ada data peminjaman
                    </td>
                </tr>
            @else
                @foreach ($peminjaman as $data)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td scope="col" class="px-6 py-3">
                            {{ $data->user->nama }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->user->kelas->nama_kelas ?? '-' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->matkul->mata_kuliah ?? '-' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->nama_dosen ?? '-' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->ruangan->nama_ruangan ?? '-' }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->tanggal_waktu_peminjaman }}
                        </td>
                        <td scope="col" class="flex items-center gap-2 px-6 py-3 justify-center">
                            <div>
                                <button type="button" data-modal-target="peminjaman{{ $data->id }}"
                                    data-modal-toggle="peminjaman{{ $data->id }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </td>
                        @include('components.modal.modaldetailVerifikasipeminjaman', [
                            'peminjaman' => $peminjaman,
                        ])
                        <td scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-6">
                                <form action="{{ route('updatePersetujuanBarang', $data->id) }}" method="POST"
                                    class="flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <select name="persetujuan" id="persetujuan" class="p-1 border rounded-md">
                                            <option value="Belum Diserahkan"
                                                {{ old('persetujuan', $data->persetujuan) == 'Belum Diserahkan' ? 'selected' : '' }}>
                                                Belum Diserahkan
                                            </option>
                                            <option value="Diserahkan"
                                                {{ old('persetujuan', $data->persetujuan) == 'Diserahkan' ? 'selected' : '' }}>
                                                Diserahkan
                                            </option>
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
                @endforeach
            @endif
        </tbody>
    </table>
</div>
