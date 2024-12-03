@extends('pengguna')

@section('content')
    <main class="bg-gray-100">
        <div class="max-w-screen-xl p-6 mx-auto mt-14 ">
            <div class="flex justify-center items-center mt-6">
                <div>
                    <p class="text-2xl text-green-500 font-semibold">
                        Katalog Alat dan Bahan
                    </p>
                </div>
            </div>

            <form method="GET" action="{{ route('katalog.index') }}"
                class="flex items-center justify-center gap-2 mt-6 mb-4">
                {{-- Tombol Semua Kategori --}}
                <button type="submit" name="kategori" value="Semua"
                    class="px-3 py-2 rounded-lg border shadow-xl {{ request('kategori') == 'Semua' ? 'bg-green-800 text-white' : 'border-green-500 hover:bg-green-800 hover:text-white' }}">
                    Semua
                </button>

                {{-- Tombol untuk setiap kategori --}}
                @foreach ($kategoris as $kategori)
                    <button type="submit" name="kategori" value="{{ $kategori->kategori }}"
                        class="px-3 py-2 rounded-lg border shadow-xl {{ request('kategori') == $kategori->kategori ? 'bg-green-800 text-white' : 'border-green-500 hover:bg-green-800 hover:text-white' }}">
                        {{ $kategori->kategori }}
                    </button>
                @endforeach
            </form>

            {{-- Bagian Kartu Barang --}}
            @if ($barangKosong)
            <div class="align-center mx-auto block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <p class="mt-6 text-center text-gray-500">Tidak ada barang yang tersedia untuk kategori ini.</p>
            </div>
            @else
                <div id="card-section" class="grid grid-cols-1 gap-2 md:grid-cols-3 animate-card">
                    @foreach ($barangs as $data)
                        <a href="{{ route('detail.index', $data->id, ['nama_barang' => $data->nama_barang]) }}"
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
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
            <div class="mt-4">
                {{ $barangs->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </main>


    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: "#3085d6",
            });
        @endif

        // Display error message using SweetAlert2
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: "#3085d6",
            });
        @endif

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
