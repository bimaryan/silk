<div id="form-peminjaman" tabindex="-1"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Form Peminjaman</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="form-peminjaman">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (Auth::guard('mahasiswa')->check())
                        <div class="mb-5">
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nama Lengkap/Ketua Kelompok
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ auth()->user()->nama }}"
                                readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div class="mb-5">
                            <label for="anggota_kelompok"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nama Anggota
                            </label>
                            <textarea id="anggota_kelompok" name="anggota_kelompok" rows="4"
                                class="block w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg"></textarea>
                        </div>
                        <div class="mb-5">
                            <label for="kelas_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Kelas
                            </label>
                            <input type="text" id="kelas_id" name="kelas_id"
                                value="{{ auth()->user()->kelas->nama_kelas }}" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div class="mb-5">
                            <label for="nama_dosen"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Dosen Pengampu
                            </label>
                            <input type="text" id="nama_dosen" name="nama_dosen"
                                placeholder="Masukkan Nama Dosen Pengampu"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div class="mb-5">
                            <label for="matkul_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Mata Kuliah
                            </label>
                            <select id="matkul_id" name="matkul_id" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach ($matkul as $data)
                                    <option value="{{ $data->id }}">{{ $data->mata_kuliah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="ruangan_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Ruang Praktikum
                            </label>
                            <select id="ruangan_id" name="ruangan_id" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="">Pilih Ruang Praktikum</option>
                                @foreach ($ruangLaboratorium as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- batas --}}
                    <div class="mb-5">
                        <label for="tanggal_waktu_peminjaman"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tanggal & Waktu Peminjaman
                        </label>
                        <input type="datetime-local" name="tanggal_waktu_peminjaman" id="tanggal_waktu_peminjaman"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                    <div class="mb-5">
                        <label for="waktu_pengembalian"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Waktu Pengembalian
                        </label>
                        <input type="time" name="waktu_pengembalian" id="waktu_pengembalian" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                    </div>
                    @if (Auth::guard('mahasiswa')->check())
                        <div class="mb-5">
                            <label for="dokumenspo_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Dokumen SPO
                            </label>
                            <select id="dokumenspo_id" name="dokumenspo_id" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="">Pilih Dokumen SPO</option>
                                @foreach ($dokumenSpo as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_dokumen }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <button type="submit"
                        class="w-full text-sm font-medium px-5 py-2.5 text-white bg-green-500 rounded-lg hover:bg-green-800">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
