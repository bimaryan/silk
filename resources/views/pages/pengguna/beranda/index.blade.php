@extends('pengguna')
@section('content')
    <style>
        .zoom-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .animate-card {
            transform: translateY(50px);
            opacity: 0;
            transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1), opacity 0.5s;
        }

        .animate-card.in-view {
            transform: translateY(0);
            opacity: 1;
        }

        .animate-slide {
            transform: translateX(15px);
            opacity: 0;
            transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1), opacity 0.5s;
        }

        .animate-slide.in-view {
            transform: translateX(0);
            opacity: 1;
        }
    </style>
    <div class="background">

        <div class="p-6 mx-auto ">
            <div class="flex items-center justify-center h-screen p-6">
                <div class="max-w-md space-y-5 animate-slide">
                    <h2 class="font-medium text-center text-green-500 text-8xl">SILK</h2>
                    <p class="text-lg font-semibold text-center text-white">
                        Sistem Laboratorium Kesehatan adalah sebuah sistem berbasis teknologi yang dirancang untuk
                        mempermudah proses peminjaman, pengembalian, serta pengelolaan inventaris laboratorium secara
                        digital.
                    </p>
                    <div class="flex items-center justify-center">
                        <a href="#filter-section"
                            class="px-4 py-3 font-semibold text-green-500 bg-gray-100 border border-green-500 rounded-xl border-1 text-m hover:bg-green-800 hover:text-white">Pinjam
                            Sekarang!</a>
                    </div>
                </div>
            </div>

            <div class="max-w-screen-xl mx-auto" id="filter-section">
                <div class="w-full p-6 space-y-5 bg-white rounded-xl">
                    <p class="text-3xl font-semibold text-center text-green-500">Alat dan Bahan Laboratorium</p>
                    <p class="text-center text-gray-500 text-m">Laboratorium Kesehatan Politeknik Negeri Indramayu memiliki
                        lebih dari 1500 alat laboratorium yang dapat dipinjam untuk mahasiswa. Ketersediaan alat
                        laboratorium
                        diperbarui secara akurat dan
                        real-time untuk menghindari tumpang tindih pemesanan.</p>

                    {{-- Form Filter --}}
                    <form method="GET" action="{{ route('beranda.index') }}"
                        class="flex items-center justify-center gap-2 mb-4">
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
                        <p class="mt-6 text-center text-gray-500">Tidak ada barang yang tersedia untuk kategori ini.</p>
                    @else
                        <div id="card-section" class="grid grid-cols-1 gap-2 md:grid-cols-3 animate-card">
                            @foreach ($barangs as $data)
                                <a href="{{ route('detail.index', ['nama_barang' => $data->nama_barang]) }}"
                                    class="w-full p-3 border border-green-500 rounded-lg shadow-lg max-w-m">
                                    <div class="flex justify-center w-full">

                                        <img src="{{ $data->foto ?? 'image/barang.png' }}" class="object-cover zoom-image"
                                            alt="{{ $data->nama_barang ?? 'Default Barang' }} " />
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

                    <div class="text-center">
                        <a href="{{ route('katalog.index') }}" class="font-medium text-green-500 text-m">Lihat Semua</a>
                    </div>
                </div>
            </div>
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
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let elem = document.documentElement;
            let fullscreenBtn = document.getElementById('fullscreen-btn');
            let icon = document.getElementById('fullscreen-icon');

            // Periksa status dari localStorage saat halaman dimuat
            if (localStorage.getItem('isFullScreen') === 'true') {
                elem.requestFullscreen();
                icon.classList.remove('fa-maximize');
                icon.classList.add('fa-minimize');
            }

            fullscreenBtn.addEventListener('click', function() {
                if (!document.fullscreenElement) {
                    // Masuk ke mode full screen
                    elem.requestFullscreen().then(() => {
                        localStorage.setItem('isFullScreen',
                            'true'); // Simpan status ke localStorage
                        icon.classList.remove('fa-maximize');
                        icon.classList.add('fa-minimize');
                    }).catch((err) => {
                        console.error(`Error trying to enable full-screen mode: ${err.message}`);
                    });
                } else {
                    // Keluar dari mode full screen
                    document.exitFullscreen().then(() => {
                        localStorage.setItem('isFullScreen',
                            'false'); // Simpan status ke localStorage
                        icon.classList.remove('fa-minimize');
                        icon.classList.add('fa-maximize');
                    }).catch((err) => {
                        console.error(`Error trying to exit full-screen mode: ${err.message}`);
                    });
                }
            });
        });
    </script>
@endsection
