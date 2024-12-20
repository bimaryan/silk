<div id="detail{{ $userId }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full p-4">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Verifikasi Pengembalian
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="detail{{ $userId }}">
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
                <div class="max-w-screen-xl mx-auto">
                    <!-- Card for Barang -->
                    @if ($loans->where('barang', '!=', null)->isNotEmpty())
                        <div
                            class="w-full text-center bg-white border border-gray-200 rounded-lg shadow p-3 dark:bg-gray-800 dark:border-gray-700 mb-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Barang</h4>
                            <div class="relative overflow-y-auto" style="max-height: 200px">
                                @foreach ($loans as $loan)
                                    @if ($loan->barang)
                                        <div
                                            class="flex justify-between items-center mb-1 bg-white p-2 border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                                            <div class="flex items-center gap-2">
                                                <img src="{{ asset($loan->barang->foto ?? 'image/barang.png') }}"
                                                    class="w-12" alt="gambar barang">
                                                <p class="text-sm ms-2">{{ $loan->barang->nama_barang ?? '-' }}</p>
                                            </div>
                                            <div class="px-4">
                                                <p class="text-sm text-gray-900">
                                                    Jumlah: <span>{{ $loan->stock_pinjam }}</span>
                                                </p>
                                                <p class="text-sm text-gray-900">
                                                    <span
                                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                        {{ $loan->barang->kategori->kategori ?? 'Kategori Tidak Diketahui' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Card for Ruangan (Positioned Below Barang Card) -->
                    @if ($loans->where('ruangan', '!=', null)->isNotEmpty())
                        <div
                            class="w-full relative overflow-y-auto text-center bg-white border border-gray-200 rounded-lg shadow p-3 dark:bg-gray-800 dark:border-gray-700">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Ruangan</h4>
                            <div class="relative overflow-y-auto" style="max-height: 200px">
                                @foreach ($loans->where('ruangan', '!=', null)->unique('ruangan_id') as $loan)
                                    @if ($loan->ruangan)
                                        <div
                                            class="flex w-full items-center justify-between gap-4 bg-white p-2 border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 mb-2">
                                            <div class="flex items-center gap-2">
                                                <img src="{{ asset($loan->ruangan->foto ?? 'image/barang.png') }}"
                                                    class="w-12" alt="gambar ruangan">
                                                <p class="text-sm font-medium">{{ $loan->ruangan->nama_ruangan }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
