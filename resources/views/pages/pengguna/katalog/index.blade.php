@extends('pengguna')

@section('content')
    <div class="w-full  p-6 mx-auto mt-14">
        <div class="mt-5 bg-white p-4 text-green-500 rounded-xl text-2xl font-semibold text-center shadow-lg">
            Katalog Alat dan Bahan Laboratorium
        </div>

        <form method="GET" action="{{ route('katalog.index') }}" class="flex items-center justify-center gap-2 mt-6 mb-4">
            <button type="submit" name="kategori" value="semua"
                class="px-3 py-2 rounded-lg border shadow-xl {{ request('kategori') == 'semua' ? 'bg-green-800 text-white' : 'border-green-500 hover:bg-green-800 hover:text-white bg-white' }}">
                Semua
            </button>

            @foreach ($dataKategori as $kategori)
                <button type="submit" name="kategori" value="{{ $kategori->id }}"
                    class="px-3 py-2 rounded-lg border shadow-xl {{ request('kategori') == $kategori->id ? 'bg-green-800 text-white' : 'border-green-500 hover:bg-green-800 hover:text-white bg-white' }}">
                    {{ $kategori->kategori }}
                </button>
            @endforeach
        </form>

        {{-- Bagian Kartu Barang --}}
        @if ($barangKosong)
            <div
                class="align-center mx-auto block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <p class="mt-6 text-center text-gray-500">Tidak ada barang yang tersedia untuk kategori ini.</p>
            </div>
        @else
            <div id="card-section" class="grid grid-cols-1 gap-4 md:grid-cols-4 animate-card">
                @foreach ($dataBarang as $data)
                    <a href="{{ route('katalog.show', ['katalog' => $data->id]) }}"
                        class="w-full p-3 border border-green-500 bg-white rounded-lg shadow-lg max-w-m">
                        <div class="flex justify-center w-full">
                            <img src="{{ asset($data->foto ?? 'image/barang.png') }}" class="object-cover zoom-image"
                                alt="{{ $data->nama_barang }}" />
                        </div>
                        <div class="mt-1">
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ $data->kategori->kategori }}
                            </span>
                        </div>
                        <div class="mt-1">
                            <p class="font-normal">{{ Str::limit($data->nama_barang, 50) }}</p>
                            <p class="text-sm text-gray-500">Stok : <span>{{ $data->stock->stock }}</span></p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-4">
            {{ $dataBarang->links() }}
        </div>
    </div>


    <script>


        document.addEventListener('DOMContentLoaded', () => {
            const scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, scrollPosition);
                sessionStorage.removeItem('scrollPosition');
            }
        });

        window.addEventListener('beforeunload', () => {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });

        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.animate-card');

            const observerOptions = {
                threshold: 0.1,
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    } else {
                        entry.target.classList.remove('in-view');
                    }
                });
            }, observerOptions);

            cards.forEach(card => {
                observer.observe(card);
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.animate-slide');

            const observerOptions = {
                threshold: 0.1,
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    } else {
                        entry.target.classList.remove('in-view');
                    }
                });
            }, observerOptions);

            slides.forEach(slide => {
                observer.observe(slide);
            });
        });
    </script>
@endsection
