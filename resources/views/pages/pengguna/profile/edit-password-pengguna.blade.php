@extends('pages.pengguna.profile.index')

@section('content-profile')
<!-- Main Content -->
<div class="p-4">
    <h1 class="mb-4 text-2xl font-semibold">Ubah Kata Sandi</h1>
    <form action="{{ route('edit-password.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
            <input type="password" id="password" name="password" value=""
                class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
            <input type="password" id="password" name="konfirmasi_password" value=""
                class="block w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
        </div>

        <div class="flex justify-end space-x-4">
            <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded-md">Simpan</button>
        </div>
    </form>
</div>

@endsection
