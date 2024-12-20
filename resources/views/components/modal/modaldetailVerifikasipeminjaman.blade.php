<!-- Modal Verifikasi Peminjaman -->
<div id="peminjaman{{ $data->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Peminjaman
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="peminjaman{{ $data->id }}">
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
                <form action="{{ route('verifikasi-peminjaman.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @foreach ($data->peminjamanDetail as $detail)
                    <input type="hidden" name="peminjaman_id" value="{{ $data->id }}">

                        <div class="max-w-screen-xl mx-auto">
                            <div class="w-full bg-white border border-gray-200 rounded-lg shadow p-3">
                                <div class="flex justify-between">
                                    <!-- Informasi Barang -->
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset($detail->foto ?? 'image/barang.png') }}" class="w-12"
                                            alt="Gambar">
                                        <div>
                                            <p class="text-sm font-semibold ms-4">{{ $detail->barang->nama_barang }}</p>
                                            <p class="text-xs text-gray-500 mt-1 ms-4">
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                    {{ $detail->barang->kategori->kategori }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="jumlah_pinjam" class="block py-2 text-sm font-medium">
                                        Jumlah Peminjaman
                                    </label>
                                    <input id="jumlah_pinjam" type="number" readonly value="{{ $detail->jumlah_pinjam }}"
                                        class="block  p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                <div class="mt-4">
                                    <label for="tindakan_spo_{{ $detail->id }}"
                                        class="block py-2 text-sm font-medium">
                                        Tindakan SPO
                                    </label>
                                    <textarea id="tindakan_spo_{{ $detail->id }}" rows="2" readonly
                                        class="block  p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $detail->tindakan_spo ?? 'Tidak ada tindakan' }}</textarea>
                                </div>
                                <div class="mt-4">
                                    <label for="status_{{ $detail->id }}" class="block py-2 text-sm font-medium">
                                        Status
                                    </label>
                                    <select id="status_{{ $detail->id }}" name="status[{{ $detail->id }}]"
                                        onchange="toggleAlasan({{ $detail->id }})"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="Diproses" {{ $detail->status == 'Diproses' ? 'selected' : '' }}>
                                            Diproses</option>
                                        <option value="Diterima" {{ $detail->status == 'Diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="Ditolak" {{ $detail->status == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>

                                <!-- Input Alasan Penolakan -->
                                <div class="mt-4">
                                    <div id="alasan-container-{{ $detail->id }}"
                                        class="{{ $detail->status == 'Ditolak' ? '' : 'hidden' }}">
                                        <label for="alasan_penolakan_{{ $detail->id }}"
                                            class="block py-2 text-sm font-medium">
                                            Alasan Penolakan
                                        </label>
                                        <textarea id="alasan_penolakan_{{ $detail->id }}" name="alasan_penolakan[{{ $detail->id }}]" rows="2"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $detail->alasan_penolakan }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    <div class="w-full bg-white border border-gray-200 rounded-lg shadow p-3">
                        <div class="flex justify-between">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset($detail->foto ?? 'image/barang.png') }}" class="w-12"
                                    alt="Gambar">
                                <div>
                                    <p class="text-sm font-semibold ms-4">
                                        {{ $detail->peminjaman->ruangan->nama_ruangan }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="anggota_kelompok" class="block py-2 text-sm font-medium">
                                Anggota Kelompok
                            </label>
                            <textarea id="anggota_kelompok" rows="2" readonly
                                class="block  p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $detail->peminjaman->anggota_kelompok ?? 'Tidak ada anggota kelompok' }}</textarea>
                        </div>
                    </div>
                    <!-- Tombol Submit -->
                    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-900">
                        Simpan Status Peminjaman
                    </button>
                </form>
                <script>
                    function toggleAlasan(id) {
                        const status = document.getElementById('status_' + id).value;
                        const alasanContainer = document.getElementById('alasan-container-' + id);
                        alasanContainer.classList.toggle('hidden', status !== 'Ditolak');
                    }
                </script>
            </div>

        </div>
    </div>
</div>
