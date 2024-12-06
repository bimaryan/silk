@extends('pengguna')

@section('content')
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

    <div class="space-y-3 p-4 mt-5">
        <div class="max-w-screen-xl p-6 mx-auto mt-14 bg-white rounded-xl">
            <div class="space-y-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="w-full flex justify-center items-center">
                    <img src="{{ asset($view->foto ?? 'image/barang.png') }}" alt="{{ asset($view->foto) }}"
                        class="object-cover rounded-lg zoom-image" style=" width: 80%;">
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
                        <form action="{{ route('detail.store', ['barang' => $view->id]) }}" method="POST">
                            @csrf
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium">Jumlah Pinjam</p>
                                </div>
                                <div class="flex items-center border border-green-500 rounded-xl bg-green-500">
                                    <!-- Tombol Minus -->
                                    <button type="button" class="p-2 text-white" onclick="decrement()">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <!-- Input Kuantitas -->
                                    <input type="number" name="stock_pinjam" id="stock_pinjam"
                                        class="w-15 auto text-center font-bold " value="1" min="1"
                                        max="{{ $view->stock->stock }}" readonly>
                                    <!-- Tombol Plus -->
                                    <button type="button" class="p-2 text-white" onclick="increment()">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="tindakan_spo"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tindakan
                                    SPO</label>
                                <textarea id="tindakan_spo" rows="4" name="tindakan_spo"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Tulis tindakan SPO"></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="submit"
                                    class="px-4 py-2 w-full text-white bg-green-500 rounded-lg hover:bg-green-800">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
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
    </script>
@endsection
