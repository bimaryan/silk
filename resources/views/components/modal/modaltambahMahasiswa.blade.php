<div id="barang" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full p-4">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Mahasiswa
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="barang">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->

            <form action="{{ route('data-mahasiswa.store') }}" class="p-4 md:p-5" method="POST">
                @csrf
                <div class="gap-2">
                    <div class="mb-2">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama" id="nama" placeholder="Masukan Nama Lengkap"
                            class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="number" name="nim" id="nim" placeholder="Masukan NIM" inputmode="numeric"
                            class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        @error('nim')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="kelas_id" class="block text-sm font-medium text-gray-700">Pilih
                            Kelas</label>
                        <select name="kelas_id" id="kelas_id"
                            class="block w-full p-2 mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                </div>
                <button type="submit"
                    class="text-white bg-green-500 mt-4 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
            </form>
        </div>
    </div>
</div>
