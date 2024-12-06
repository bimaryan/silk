@extends('pengguna')
@section('content')
    <main>
        <div class="space-y-3 p-4 mt-5">
            <div class="max-w-screen-xl p-6 mx-auto mt-14 bg-white rounded-xl">
                <div class="space-y-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="w-full flex justify-center items-center">
                        <img src="{{ asset($ruangans->foto ?? 'image/barang.png') }}" alt="{{ asset($ruangans->foto) }}"
                            class="object-cover rounded-lg border zoom-image" style=" width: 80%;">
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xl font-semibold">{{ $ruangans->nama_ruangan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
