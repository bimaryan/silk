@extends('pengguna')
@section('content')
    <main>
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

        <div class="max-w-screen-xl p-6 mx-auto mt-14">
            <div class="mt-5 bg-white p-4 text-green-500 rounded-xl text-2xl font-semibold text-center shadow-lg">
                Katalog Ruangan
            </div>

            <br>

            @if ($ruanganKosong)
                <div
                    class="align-center mx-auto block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <p class="mt-6 text-center text-gray-500">Tidak ada ruangan yang tersedia.</p>
                </div>
            @else
                <div id="card-section" class="grid grid-cols-1 gap-2 md:grid-cols-3 animate-card">
                    @foreach ($ruangans as $data)
                        <a href="{{ route('ruangan.show', ['ruangan' => $data->nama_ruangan]) }}"
                            class="w-full p-3 border border-green-500 bg-white rounded-lg shadow-lg max-w-m">
                            <div class="flex justify-center w-full">
                                <img src="{{ asset($data->foto ?? 'image/barang.png') }}"
                                    alt="{{ asset($data->foto ?? 'Tidak ada foto') }}" class="object-cover zoom-image" />
                            </div>
                            <div class="mt-1">
                                <p class="font-normal">{{ $data->nama_ruangan }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
            <div class="mt-4">
                {{ $ruangans->links() }}
            </div>
        </div>
    </main>
@endsection
