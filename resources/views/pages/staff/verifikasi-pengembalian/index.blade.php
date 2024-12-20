@extends('index')
@section('content')
    <div class="p-4 mt-3 sm:ml-64">
        <div class="space-y-4 rounded-lg mt-14">
            <div class="p-4 bg-white rounded-lg shadow-lg flex items-center">
                <p class="text-lg font-semibold text-green-500">Verifikasi Pengembalian</p>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div class="flex items-center gap-2 mb-4">
                    <form method="GET" action="{{ route('ruangan.index') }}" class="flex items-center gap-2">
                        <!-- Input pencarian -->
                        <input type="text" name="search" placeholder="Pencarian" value="{{ request('search') }}"
                            class="p-2 border rounded-md w-full focus:outline-none focus:ring-2 focus:ring-green-500">

                        <!-- Tombol submit -->
                        <button type="submit" class="p-2 text-white bg-green-500 rounded-md hover:bg-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14" />
                            </svg>
                        </button>

                        <!-- Tombol reset -->
                        <a href="{{ route('ruangan.index') }}"
                            class="p-2 text-white bg-gray-500 rounded-md hover:bg-gray-600">
                            Reset
                        </a>
                    </form>
                </div>
                <div id="tablePeminjaman">
                    @include('components.tables.tableVerifikasipengembalian')
                </div>

                {{-- <div class="mt-4">
                    {{ $peminjamans->links() }}
                </div> --}}
            </div>
        </div>
    </div>
@endsection
