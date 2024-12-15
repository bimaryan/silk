@extends('pengguna')
@section('content')
    <div class="max-w-screen-xl p-6 mx-auto mt-14">
        <div class="mt-5 bg-white p-4 text-green-500 rounded-xl text-2xl font-semibold text-center shadow-lg">
            Riwayat Peminjaman
        </div>

        <div>
            @include('components.tables.tableriwayatPengguna', [
                'riwayat' => $riwayat,
            ])
        </div>
    </div>
@endsection
