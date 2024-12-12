@extends('pengguna')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: "#3085d6",
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: "#3085d6",
            });
        </script>
    @endif

    <div class="p-4 space-y-3 mt-5">
        <div
            class="max-w-screen-xl mx-auto mt-14 bg-white p-4 text-green-500 rounded-xl text-2xl font-semibold text-center shadow-lg">
            Keranjang
        </div>

        <br>

        <div class="max-w-screen-xl p-4 mx-auto mt-14 bg-white rounded-xl shadow-lg">
            @if ($keranjang->isEmpty())
                <div class="flex justify-center items-center text-center text-red-500 font-semibold">
                    <p>Keranjang Anda kosong, tambahkan barang terlebih dahulu sebelum melanjutkan.</p>
                </div>
            @else
                @foreach ($keranjang as $data)
                    <div class="max-w-screen-xl p-1 mx-auto">
                        <div
                            class="w-full text-center bg-white border border-gray-200 rounded-lg shadow p-2 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        @if (!empty($data->barang))
                                            <!-- Tampilkan Barang -->
                                            <img src="{{ asset($data->barang->foto ?? 'image/barang.png') }}" class="w-12"
                                                alt="{{ $data->barang->foto }}">
                                            <p class="text-sm">{{ $data->barang->nama_barang }}</p>
                                        @elseif (!empty($data->ruangan))
                                            <!-- Tampilkan Ruangan -->
                                            <img src="{{ asset($data->ruangan->foto ?? 'image/barang.png') }}"
                                                class="w-12" alt="{{ $data->ruangan->foto }}">
                                            <p class="text-sm">{{ $data->ruangan->nama_ruangan }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-center items-center text-center">
                                    <div class="px-4">
                                        <p class="text-sm text-gray-900">{{ $data->stock_pinjam }}</p>
                                    </div>
                                    <div class="px-4">
                                        <form action="{{ route('keranjang.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <hr class="my-5" />

                <form action="{{ route('keranjang.update', $keranjang->first()->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if (Auth::guard('mahasiswa')->check())
                        <div class="mb-5">
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Lengkap/Ketua Kelompok</label>
                            <input type="nama" id="nama" value="{{ auth()->user()->nama }}" disabled
                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="mb-5">
                            <label for="anggota_kelompok"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Anggota</label>
                            <textarea id="anggota_kelompok" rows="4" name="anggota_kelompok"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-5">
                            <label for="kelas_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                            <input type="kelas_id" id="kelas_id" value="{{ auth()->user()->kelas->nama_kelas }}" disabled
                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="nama_dosen"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Nama
                                Dosen</label>
                            <input type="text" id="nama_dosen" name="nama_dosen"
                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        {{-- START SELECT DOSEN --}}
                        {{-- <div class="mb-5">
                            <label for="dosen_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dosen</label>
                            <select id="dosen_id" name="dosen_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>--- Pilih Dosen Pengampu ---</option>
                                @if ($dosen->isEmpty())
                                    <option>Tidak ada data dosen tersedia</option>
                                @else
                                    @foreach ($dosen as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div> --}}
                        {{-- END SELECT DOSEN --}}

                        <div class="mb-5">
                            <label for="matkul_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata
                                Kuliah</label>
                            <select id="matkul_id" name="matkul_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>---- Pilih Mata Kuliah ---</option>
                                @if ($matkul->isEmpty())
                                    <option>Tidak ada data mata kuliah tersedia</option>
                                @else
                                    @foreach ($matkul as $matkuls)
                                        <option value="{{ $matkuls->id }}">{{ $matkuls->mata_kuliah }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="ruangan_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ruang
                                Praktikum</label>
                            <select id="ruangan_id" name="ruangan_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>--- Pilih Ruang Praktikum ---</option>
                                @if ($ruangan->isEmpty())
                                    <option>Tidak ada Mata Kuliah</option>
                                @else
                                    @foreach ($ruangan as $ruangans)
                                        <option value="{{ $ruangans->id }}">{{ $ruangans->nama_ruangan }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="tanggal_waktu_peminjaman"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal & Waktu Peminjaman
                            </label>
                            <input type="datetime-local" name="tanggal_waktu_peminjaman" id="tanggal_waktu_peminjaman"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="waktu_pengembalian"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Waktu Pengembalian
                            </label>
                            <input type="time" name="waktu_pengembalian" id="waktu_pengembalian"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                    @elseif(Auth::guard('dosen')->check())
                        <div class="mb-5">
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Dosen</label>
                            <input type="nama" id="nama" value="{{ auth()->user()->nama }}" disabled
                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="tanggal_waktu_peminjaman"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal & Waktu Peminjaman
                            </label>
                            <input type="datetime-local" name="tanggal_waktu_peminjaman" id="tanggal_waktu_peminjaman"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="waktu_pengembalian"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Waktu Pengembalian
                            </label>
                            <input type="time" name="waktu_pengembalian" id="waktu_pengembalian"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="keterangan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                            <input type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                    @endif

                    <button type="submit"
                        class="text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Submit</button>
                </form>
            @endif
        </div>
    </div>
@endsection
