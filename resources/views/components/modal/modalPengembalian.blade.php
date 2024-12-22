<div id="pengembalian{{ $data->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Pengembalian
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="pengembalian{{ $data->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <form action="{{ route('pengembalian.proses', $data->id) }}" method="POST">
                    @csrf
                    @foreach ($data->peminjamanDetail as $detail)
                        <div class="max-w-screen-xl mx-auto">
                            <div class="w-full bg-white border border-gray-200 rounded-lg shadow p-3">
                                <div class="flex justify-between">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset($detail->foto ?? 'image/barang.png') }}" class="w-12"
                                            alt="Gambar">
                                        <div>
                                            <p class="text-sm font-semibold">{{ $detail->barang->nama_barang }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                    {{ $detail->barang->kategori->kategori }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 mt-3">
                                    <label for="jumlah_pinjam_{{ $detail->id }}" class="block text-sm font-medium">
                                        Jumlah Peminjaman
                                    </label>
                                    <input type="number" id="jumlah_pinjam_{{ $detail->id }}"
                                        name="jumlah_pinjam[{{ $detail->id }}]" value="{{ $detail->jumlah_pinjam }}" readonly
                                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" />
                                </div>
                                <div class="mb-4">
                                    <label for="jumlah_kembali_{{ $detail->id }}" class="block text-sm font-medium">
                                        Jumlah Kembali
                                    </label>
                                    <input type="number" id="jumlah_kembali_{{ $detail->id }}"
                                        name="jumlah_kembali[{{ $detail->id }}]" min="0"
                                        max="{{ $detail->jumlah }}" placeholder="Masukkan jumlah barang kembali"
                                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" />
                                </div>
                                <div class="mb-4">
                                    <label for="kondisi_{{ $detail->id }}" class="block text-sm font-medium">
                                        Kondisi Barang
                                    </label>
                                    <select id="kondisi_{{ $detail->id }}" name="kondisi[{{ $detail->id }}]"
                                        class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border border-gray-300">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Dikembalikan">Dikembalikan</option>
                                        <option value="Hilang">Hilang</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Habis">Habis</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        <label for="tindakan_spo_pengguna" class="block text-sm font-medium">
                            Tindakan yang sudah dilakukan
                        </label>
                        <textarea id="tindakan_spo_pengguna" name="tindakan_spo_pengguna" rows="4"
                            class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border border-gray-300" placeholder="Masukkan tindakan SPO"></textarea>
                    </div>
                    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Ajukan Pengembalian
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
