@extends('pengguna')

@section('content')
    <div class="p-4 space-y-3">
        <div class="max-w-screen-xl p-4 mx-auto mt-14 bg-white rounded-xl">
            <h2 class="text-xl text-center font-medium">Keranjang</h2>
        </div>

        <div
            class="w-full text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            @if ($keranjang->isEmpty())
                <div class="flex justify-center items-center text-center">
                    <div class="px-4">
                        <p class="text-sm text-gray-900">Keranjang Kosong</p>
                    </div>
                </div>
            @endif
            @foreach ($keranjang as $data)
                <div class="max-w-screen-xl p-1 mx-auto bg-white rounded-xl">
                    <div
                        class="w-full text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $data->barang->foto }}" class="w-12" alt="{{ $data->barang->foto }}">
                                    <p class="text-sm">{{ $data->barang->nama_barang }}</p>
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
                                        <button type="submit" class="text-sm text-red-500 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="max-w-screen-xl p-4 mx-auto mt-14 bg-white rounded-xl">
            <form action="{{ route('keranjang.store', $data) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        Lengkap/Ketua Kelompok</label>
                    <input type="nama" id="nama" value="{{ auth()->user()->nama }}" disabled
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="name@flowbite.com" required />
                </div>
                <div class="mb-5">
                    <label for="nama_anggota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        Anggota</label>
                    <textarea id="nama_anggota" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Leave a comment..."></textarea>
                </div>
                <div class="mb-5">
                    <label for="kelas_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                    <input type="kelas_id" id="kelas_id" value="{{ auth()->user()->kelas->nama_kelas }}" disabled
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="name@flowbite.com" required />
                </div>
                <div class="mb-5">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dosen</label>
                    <select id="countries" name="dosen_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Pilih Dosen Pengampu</option>
                        @if ($keranjang->isEmpty())
                            @foreach ($keranjang as $dosen)
                                <option value="{{ $dosen->id }}"
                                    {{ $dosen->id == auth()->user()->dosen_id ? 'selected' : '' }}>
                                    {{ $dosen->nama }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="mb-5">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Kuliah</label>
                    <select id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Pilih Mata Kuliah</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="FR">France</option>
                        <option value="DE">Germany</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ruang Praktikum</label>
                    <select id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Pilih Ruang Praktikum</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="FR">France</option>
                        <option value="DE">Germany</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="tanggal_waktu_peminjaman" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Tanggal & Waktu Peminjaman
                    </label>
                    <input
                        type="datetime-local"
                        name="tanggal_waktu_peminjaman"
                        id="tanggal_waktu_peminjaman"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />
                </div>

                <div class="mb-5">
                    <label for="waktu_pengembalian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Waktu Pengembalian
                    </label>
                    <input
                        type="time"
                        name="waktu_pengembalian"
                        id="waktu_pengembalian"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>
    </div>
@endsection
