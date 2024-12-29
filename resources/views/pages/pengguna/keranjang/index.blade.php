@extends('pengguna')

@section('content')

    <div class="max-w-screen-xl p-6 mx-auto">
        <div class="bg-white p-4 text-green-500 rounded-xl text-2xl font-semibold text-center shadow-lg">
            Keranjang
        </div>

        <br>

        <div class="max-w-screen-xl p-4 mx-auto bg-white rounded-xl shadow-lg">
            @if (empty($dataKeranjang))
                <div class="flex justify-center items-center text-center text-red-500 font-semibold">
                    <p>Keranjang Anda kosong, tambahkan barang terlebih dahulu sebelum melanjutkan.</p>
                </div>
            @else
                @foreach ($dataKeranjang as $data)
                    <div class="max-w-screen-xl p-1 mx-auto">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="flex items-center gap-2">
                                    @if (!empty($data->barang))
                                        <!-- Tampilkan Barang -->
                                        <img src="{{ asset('storage/' . $data->barang->foto) ?? 'image/barang.png' }}"
                                            class="w-16 h-16" alt="{{ $data->barang->nama_barang }}">
                                        <p class="text-sm ms-2">{{ $data->barang->nama_barang }}</p>
                                        <p
                                            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ $data->barang->kategori->kategori }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-center items-center text-center">
                                <div class="px-4">
                                    <p class="text-sm text-gray-900">{{ $data->jumlah_pinjam }}</p>
                                </div>
                                <div class="px-4">
                                    <form action="{{ route('keranjang.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-m text-red-500 cursor-pointer hover:underline"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="tindakan_spo_{{ $data->id }}"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left">
                                Tindakan SPO
                            </label>
                            <textarea id="tindakan_spo_{{ $data->id }}" rows="4" name="tindakan_SPO" readonly
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $data->tindakan_spo ?? '-' }}</textarea>
                        </div>
                    </div>
                @endforeach

                <hr class="my-5" />
                <button data-modal-target="form-peminjaman" data-modal-toggle="form-peminjaman"
                    class="px-4 py-2 w-full text-white bg-green-500 rounded-lg hover:bg-green-800" type="button">Form
                    Peminjaman
                </button>

                @include('components.modal.modalPeminjaman')
            @endif
        </div>
    </div>
@endsection
