@extends('pengguna')

@section('content')

    <div class="p-4 space-y-3">
        <div
            class="max-w-screen-xl mx-auto mt-14 bg-white p-4 text-green-500 rounded-xl text-2xl font-semibold text-center shadow-lg">
            Keranjang
        </div>

        <br>

        <div class="max-w-screen-xl p-4 mx-auto mt-14 bg-white rounded-xl shadow-lg">
            @if (empty($dataKeranjang))
                <div class="flex justify-center items-center text-center text-red-500 font-semibold">
                    <p>Keranjang Anda kosong, tambahkan barang terlebih dahulu sebelum melanjutkan.</p>
                </div>
            @else
                @foreach ($dataKeranjang as $data)
                    <div class="max-w-screen-xl p-1 mx-auto">
                        <div
                            class="w-full text-center bg-white border border-gray-200 rounded-lg shadow p-2 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        @if (!empty($data->barang))
                                            <!-- Tampilkan Barang -->
                                            <img src="{{ asset($data->barang->foto ?? 'image/barang.png') }}"
                                                class="w-16 h-16" alt="gambar">
                                            <p class="text-sm ms-2">{{ $data->barang->nama_barang }}</p>

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
                                            <button type="submit"
                                            class="text-sm text-red-500 hover:underline">Hapus</button>
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
