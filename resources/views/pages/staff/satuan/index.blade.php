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
                        <h3 class="text-2xl font-semibold text-green-500">Data Satuan</h3>
                    </div>
                    <div>
                        <button data-modal-target="import-satuan" data-modal-toggle="import-satuan"
                            class="justify-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-800"
                            data-tooltip-target="import" data-tooltip-placement="left">
                            <i class="fa-solid fa-file-arrow-up"></i>
                        </button>

                        <div id="import" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Import
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        {{-- MODAL IMPORT SATUAN --}}
                        @include('components.modal.modalimportSatuan')

                        <button data-modal-target="tambah-satuan" data-modal-toggle="tambah-satuan"
                            class="justify-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-800">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        {{-- MODAL TAMBAH SATUAN --}}
                        @include('components.modal.modaltambahSatuan')
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div id="tableSatuan">
                    @include('components.tables.tableSatuan', ['satuan' => $satuan])
                </div>
                <div class="mt-4">
                    {{ $satuan->links() }}
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
