<div id="detail{{ $item->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full p-4">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Verifikasi Peminjaman
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="detail{{ $item->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4">
                <div class="relative overflow-x-auto rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Mata Kuliah
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kelas
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Ruangan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Barang
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jumlah Pinjam
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Anggota Kelompok
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col" class="px-6 py-3">
                                    {{ $item->matkul->mata_kuliah ?? 'Tidak ada mata kuliah' }}
                                </td>
                                <td scope="col" class="px-6 py-3">
                                    {{ $item->kelas->nama_kelas ?? 'Tidak ada kelas' }}
                                </td>
                                <td scope="col" class="px-6 py-3">
                                    {{ $item->ruangan->nama_ruangan ?? 'Tidak ada ruangan' }}
                                </td>
                                <td scope="col" class="px-6 py-3">
                                    {{ $item->barang->nama_barang ?? 'Tidak ada barang' }}
                                </td>
                                <td scope="col" class="px-6 py-3">
                                    {{ $item->stock_pinjam ?? 'Tidak ada jumlah pinjam' }}
                                </td>
                                <td scope="col" class="px-6 py-3">
                                    {{ $item->anggota_kelompok ?? 'Tidak ada anggota kelompok' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
