@extends('pengguna')

@section('content')
    <div class="space-y-3 p-4">
        <div class="max-w-screen-xl p-6 mx-auto mt-14 bg-white rounded-xl">
            <div class="space-y-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="w-full">
                    <img src="{{ asset($view->foto ?? 'image/barang.png') }}" alt="{{ asset($view->foto) }}"
                        class="object-cover rounded-lg image">
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-xl font-semibold">{{ $view->nama_barang }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">{{ $view->kategori->kategori }}</span>
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">{{ $view->satuan->satuan }}</span>

                        </div>
                        <div>
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Sisa
                                {{ $view->stock->stock }}</span>
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('keranjang.store', ['barang' => $view->id]) }}" method="POST">
                            @csrf
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium">Kuantitas</p>
                                </div>
                                <div class="flex items-center border rounded-xl">
                                    <!-- Tombol Minus -->
                                    <button type="button" class="p-2" onclick="decrement()">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <!-- Input Kuantitas -->
                                    <input type="number" name="stock_pinjam" id="stock_pinjam" class="w-15 text-center"
                                        value="1" min="1" max="{{ $view->stock->stock }}" readonly>
                                    <!-- Tombol Plus -->
                                    <button type="button" class="p-2" onclick="increment()">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="px-4 py-2 w-full text-white bg-green-500 rounded-lg hover:bg-green-800">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-screen-xl p-6 mx-auto mt-14 bg-white rounded-xl">
            <div class="flex items-center">
                <div class="flex items-center gap-3">
                    <div>
                        <img src="{{ asset('image/icon_profile.png') }}" alt="" class="object-cover foto">
                    </div>
                    <div>
                        <p class="text-sm font-medium">Admin</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-screen-xl p-6 mx-auto mt-14 bg-white rounded-xl space-y-2">
            <div>
                <h2 class="text-lg font-medium">Deskripsi Barang</h2>
            </div>
            <div>
                <p class="text-sm text-gray-100">{!! nl2br(e($view->deskripsi)) !!}</p>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menambah jumlah_pinjam
        function increment() {
            let input = document.getElementById('stock_pinjam');
            let currentValue = parseInt(input.value);
            let maxValue = parseInt(input.getAttribute('max'));

            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        }

        // Fungsi untuk mengurangi jumlah_pinjam
        function decrement() {
            let input = document.getElementById('stock_pinjam');
            let currentValue = parseInt(input.value);
            let minValue = parseInt(input.getAttribute('min'));

            if (currentValue > minValue) {
                input.value = currentValue - 1;
            }
        }

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
    </script>
@endsection
