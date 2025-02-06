<div id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Laporan
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
                @foreach ($data->pengembalianDetail as $detail)
                    <div class="max-w-screen-xl mx-auto">
                        <div
                            class="w-full bg-white border border-gray-200 rounded-lg shadow p-3 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-between">
                                <div class="flex justify-center items-center gap-2">
                                    <div class="px-4">
                                        <img src="{{ asset('storage/' . $detail->barang->foto) ?? 'image/barang.png' }}"
                                            class="w-12" alt="ini gambar">
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-sm text-gray-900 font-semibold mb-1">
                                            {{ $detail->barang->nama_barang }}
                                        </p>
                                        <p class="text-sm text-gray-900">
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                {{ $detail->barang->kategori->kategori }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex justify-center items-center text-center">
                                    <div class="px-4">
                                        <p class="text-sm text-gray-900">
                                            Jumlah :
                                            <span>{{ $detail->jumlah_pinjam }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="tindakan_spo_{{ $detail->id }}"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">Tindakan
                                    SPO</label>
                                <textarea id="tindakan_spo_{{ $detail->id }}" rows="4" name="tindakan_spo" readonly
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $detail->tindakan_spo_pengguna ?? 'tidak ada tindakan' }}</textarea>
                            </div>
                            <div id="alasan-container-{{ $detail->id }}"
                                class="{{ $detail->status == 'Ditolak' ? '' : 'hidden' }}">
                                <label for="alasan_penolakan_{{ $detail->id }}"
                                    class="block mt-2 text-sm font-medium">
                                    Alasan Penolakan
                                </label>
                                <textarea id="alasan_penolakan_{{ $detail->id }}" name="alasan_penolakan[{{ $detail->id }}]" rows="2"
                                    readonly
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $detail->alasan_penolakan }}</textarea>
                            </div>
                            <script>
                                function toggleAlasan(id) {
                                    const status = document.getElementById('status_' + id).value;
                                    const alasanContainer = document.getElementById('alasan-container-' + id);
                                    alasanContainer.classList.toggle('hidden', status !== 'Ditolak');
                                }
                            </script>
                        </div>
                    </div>
                @endforeach
                <div
                    class="w-full bg-white border border-gray-200 rounded-lg shadow p-3 dark:bg-gray-800 dark:border-gray-700">
                        <label for="anggota_kelompok"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">Anggota Kelompok</label>
                        <textarea id="anggota_kelompok" rows="4" name="anggota_kelompok" readonly
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $detail->anggota_kelompok ?? 'Tidak ada anggota kelompok' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan alasan penolakan jika status Ditolak
    function toggleAlasan(id) {
        var status = document.getElementById('status_' + id).value;
        var alasanContainer = document.getElementById('alasan-container-' + id);
        if (status == 'Ditolak') {
            alasanContainer.classList.remove('hidden');
        } else {
            alasanContainer.classList.add('hidden');
        }
    }
</script>
