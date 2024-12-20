@extends('pages.pengguna.profile.index')

@section('content-profile')
    <div class="p-4">

        <h1 class="mb-4 text-2xl font-semibold">Pengaturan Data Diri </h1>
        <form action="{{ route('edit-profile.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex items-center mb-6">
                <div class="relative overflow-hidden border border-4 border-green-500 rounded-full d-full">
                    @if (isset(auth()->user()->foto) && auth()->user()->foto != '')
                        <img id="profileImage" src="{{ asset(auth()->user()->foto) }}" alt="Foto Profil"
                            class="object-cover rounded-full" style="width: 130px; height: 130px;">
                    @else
                        <!-- Tampilan default jika tidak ada gambar -->
                        <div class="flex items-center justify-center bg-gray-200 rounded-full"
                            style="width: 130px; height: 130px;">
                            <i class="text-2xl text-gray-500 fas fa-upload"></i>
                        </div>
                    @endif

                    <!-- Ikon Upload FontAwesome di tengah untuk kondisi hover -->
                    <div
                        class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-50 opacity-0 hover:opacity-100">
                        <i class="text-white fas fa-upload text-1xl"></i>
                    </div>

                    <input type="file" id="uploadImage" name="foto" accept="image/*"
                        class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer">
                </div>
            </div>

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama
                    Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly
                    class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
            </div>

            @if (Auth::guard('mahasiswa')->check())
                <div class="mb-4">
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="nim" name="nim" value="{{ auth()->user()->nim }}" readonly
                        class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 disabled:bg-gray-100">
                </div>
                <div class="mb-4">
                    <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <input type="text" id="kelas" name="kelas" value="{{ auth()->user()->kelas }}" readonly
                        class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 disabled:bg-gray-100">
                </div>

            @elseif (Auth::guard('dosen')->check())
                <div class="mb-4">
                    <label for="nip" class="block text-sm font-medium text-gray-700">NIP/NIDN</label>
                    <input type="text" id="nip" name="nip" value="{{ auth()->user()->nip }}"
                        class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 disabled:bg-gray-100">
                </div>
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" value="{{ auth()->user()->username }}"
                        class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 disabled:bg-gray-100">
                </div>
            @endif

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                    class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">No.
                    Handphone</label>
                <input type="text" id="phone" name="telepon" value="{{ auth()->user()->telepon }}"
                    class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
            </div>
            <div class="mb-6">
                <span class="block mb-4 text-sm font-medium text-gray-700">Jenis Kelamin</span>
                <div class="flex items-center mb-4">
                    <input id="laki-laki" type="radio" value="Laki-laki" name="jenis_kelamin"
                        {{ auth()->user()->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="laki-laki"
                        class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Laki-laki</label>
                </div>
                <div class="flex items-center mb-4">
                    <input id="perempuan" type="radio" value="Perempuan" name="jenis_kelamin"
                        {{ auth()->user()->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="perempuan"
                        class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Perempuan</label>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection
