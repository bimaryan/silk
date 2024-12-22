@extends('index')
@section('content')
    <div class="p-4 mt-3 sm:ml-64">
        <div class="space-y-4 rounded-lg mt-14">
            <div class="p-4 bg-white rounded-lg shadow-lg flex items-center">
                <p class="text-lg font-semibold text-green-500">Mata Kuliah</p>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between mb-4">

                    <div class="flex items-center gap-2">
                        <button data-modal-target="tambah-matakuliah" data-modal-toggle="tambah-matakuliah"
                            class="justify-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-800">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        @include('components.modal.modaltambahMatakuliah')

                        <button class="justify-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-800"
                            data-modal-target="import-matakuliah" data-modal-toggle="import-matakuliah"
                            data-tooltip-target="import" data-tooltip-placement="left"><i
                                class="fa-solid fa-file-arrow-up"></i>
                        </button>

                        @include('components.modal.modalimportMatakuliah')
                    </div>
                    <div class="flex items-center gap-2">
                        <form method="GET" action="{{ route('data-mata-kuliah.index') }}" class="flex items-center gap-2">
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
                            <a href="{{ route('data-mata-kuliah.index') }}"
                                class="p-2 text-white bg-gray-500 rounded-md hover:bg-gray-600">
                                Reset
                            </a>
                        </form>
                    </div>
                </div>
                <div id='tableMatakuliah'>
                    @include('components.tables.tableMatakuliah', ['matakuliah' => $matakuliah])
                </div>
                <div class="mt-3 flex justify-center">
                    {{ $matakuliah->links() }}
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
