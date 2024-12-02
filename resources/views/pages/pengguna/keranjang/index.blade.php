@extends('pengguna')

@section('content')
    <div class="p-4 space-y-3">
        <div class="max-w-screen-xl p-4 mx-auto mt-14 bg-white rounded-xl">
            <h2 class="text-xl text-center font-medium">Keranjang</h2>
        </div>

        @foreach ($keranjang as $data)
            <div class="max-w-screen-xl p-4 mx-auto mt-14 bg-white rounded-xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="flex items-center gap-2">
                            <img src="{{ $data->barang->foto }}" class="w-12" alt="{{ $data->barang->foto }}">
                            <p class="text-sm">{{ $data->barang->nama_barang }}</p>
                        </div>
                    </div>
                    <div class="flex justify-center items-center text-center">
                        <div class="px-4">
                            <p class="text-sm text-gray-900">{{ $data->stock_pinjam }}</p>
                        </div>
                        <div class="px-4">
                            <form action="{{ route('keranjang.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
