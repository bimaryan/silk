<div id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Pengembalian
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="detail{{ $data->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <form action="{{ route('pengembalians.update', $data->id) }}" method="POST">
                    @csrf
                    @foreach ($data->pengembalianDetail as $detail)
                        <div class="max-w-screen-xl mx-auto">
                            <div class="w-full bg-white border border-gray-200 rounded-lg shadow p-3">
                                <div class="flex justify-between">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset($detail->alatBahan->foto ?? 'image/barang.png') }}"
                                            class="w-12" alt="ini gambar">
                                        <div>
                                            <p class="text-sm ms-2">{{ $detail->alatBahan->nama }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                    {{ $detail->alatBahan->kategori->kategori }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <p>
                                        Jumlah peminjaman :
                                        <span>
                                            {{ $data->peminjaman->peminjamanDetail->where('alat_bahan_id', $detail->alat_bahan_id)->first()->jumlah ?? '-' }}
                                        </span>
                                    </p>
                                </div>
                                {{-- INPUT --}}
                                <div class="mt-2">
                                    <label for="jumlah_barang_kembali_{{ $detail->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                        barang kembali</label>
                                    <input type="text" id="jumlah_barang_kembali_{{ $detail->id }}"
                                        name="jumlah[{{ $detail->id }}]" value="{{ $detail->jumlah_kembali }}"
                                        readonly
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                </div>
                                <div class="mt-2">
                                    <label for="kondisi_{{ $detail->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kondisi</label>
                                    <input type="text" id="kondisi_{{ $detail->id }}"
                                        name="kondisi[{{ $detail->id }}]" value="{{ $detail->kondisi }}" readonly
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                </div>
                                @if (in_array($detail->kondisi, ['Hilang', 'Rusak']))
                                    <div class="mt-2">
                                        <label for="catatan_{{ $detail->id }}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan
                                            untuk pengguna</label>
                                        <textarea id="catatan_{{ $detail->id }}" name="catatan[{{ $detail->id }}]" rows="2"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $detail->catatan }}</textarea>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Tombol Submit -->
                    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Simpan
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
