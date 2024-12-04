@extends('index')
@section('content')
    <div class="p-4 mt-3 sm:ml-64">
        <div class="space-y-4 rounded-lg mt-14">
            @if (session('success'))
                <script>
                    Swal.fire({
                        title: "Success",
                        text: "{{ session('success') }}",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    });
                </script>
            @endif
            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-semibold text-green-500">Data Barang</h3>
                    </div>
                    <div>
                        <button data-modal-target="import-barang" data-modal-toggle="import-barang"
                            class="px-3 py-2 text-white bg-green-500 rounded hover:bg-green-800">
                            <i class="fa-solid fa-upload"></i>
                        </button>
                        {{-- MODAL IMPORT BARANG --}}
                        @include('components.modal.modalimportBarang')

                        <button data-modal-target="tambah-barang" data-modal-toggle="tambah-barang"
                            class="px-3 py-2 text-white bg-green-500 rounded hover:bg-green-800">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        {{-- MODAL TAMBAH BARANG --}}
                        @include('components.modal.modaltambahBarang')
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div class="mb-4">
                    <form method="GET" action="{{ route('barang.index') }}" class="flex items-center gap-2">
                        <input type="text" name="search" placeholder="Cari barang, kategori, satuan, atau stok..."
                            value="{{ request('search') }}"
                            class="p-2 border rounded-md w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                        <button type="submit"
                            class="p-2 text-white bg-green-500 rounded-md hover:bg-green-800">Cari</button>
                        <a href="{{ route('barang.index') }}"
                            class="p-2 text-white bg-gray-500 rounded-md hover:bg-gray-600">Reset</a>
                    </form>
                </div>

                <div id="tableBarang">
                    @include('components.tables.tableBarang', ['barangs' => $barangs])
                </div>
                <div class="mt-4">
                    {{ $barangs->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
