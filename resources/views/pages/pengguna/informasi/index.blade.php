@extends('pengguna')

@section('content')
    <div class="max-w-screen-xl p-6 mx-auto mt-14">
        <div class="mt-5 bg-white p-4 text-green-500 rounded-xl text-2xl font-semibold text-center shadow-lg">
            Informasi Peminjaman
        </div>

        <div class="flex items-center shadow-lg p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 mt-4 dark:bg-gray-800 dark:text-yellow-300"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Pemberitahuan!</span> Silahkan datang ke lab terpadu untuk mengambil atau
                mengembalikan barang
                yang di pinjam, sertakan bukti peminjaman.
            </div>
        </div>
        <div>
            @include('components.tables.tableinformasiPengguna', [
                'peminjamans' => $peminjamans,
            ])
        </div>
    </div>
@endsection
