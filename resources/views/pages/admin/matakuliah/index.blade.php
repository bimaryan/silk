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
                        <h3 class="text-2xl font-semibold text-green-500">Mata Kuliah</h3>
                    </div>
                    <div class="flex items-center space-x-2">
                        {{-- START : MODAL EXPORT MATA KULIAH --}}
                        <a href="{{ route('export-mata-kuliah') }}" data-tooltip-target="export" data-tooltip-placement="left"
                            class="justify-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-800">
                            <i class="fa-solid fa-file-arrow-down"></i>
                        </a>

                        <div id="export" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Export
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        {{-- END : MODAL EXPORT MATA KULIAH --}}

                        <button class="justify-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-800"
                            data-modal-target="import-matakuliah" data-modal-toggle="import-matakuliah"
                            data-tooltip-target="import" data-tooltip-placement="left"><i
                                class="fa-solid fa-file-arrow-up"></i>
                        </button>

                        <div id="import" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Import
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        @include('components.modal.modalimportMatakuliah')

                        <button data-modal-target="tambah-matakuliah" data-modal-toggle="tambah-matakuliah"
                            class="justify-center px-4 py-2 text-white bg-green-500 rounded hover:bg-green-800"><i
                                class="fa-solid fa-plus"></i>
                        </button>

                        {{-- MODAL TAMBAH KELAS --}}
                        @include('components.modal.modaltambahMatakuliah')
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div id='tableMatakuliah'>
                    @include('components.tables.tableMatakuliah', ['matakuliah' => $matakuliah])
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
        <script>
            $(document).ready(function() {
                // Apply filter ketika button filter di klik
                $('#applyFilter').on('click', function(e) {
                    e.preventDefault();
                    loadTable();
                });

                // Handle pagination link click event
                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    loadTable(page);
                });

                function loadTable(page = 1) {
                    $.ajax({
                        url: "{{ route('data-mata-kuliah.index') }}",
                        method: "GET",
                        data: {
                            // name: $('#filterName').val(),
                            // kategori_id: $('#filterKategori').val(),
                            // kondisi: $('#filterKondisi').val(),
                            // stock: $('#filterStock').val(),
                            // satuan_id: $('#filterSatuan').val(),
                            // page: page
                        },
                        success: function(response) {
                            // Replace table and pagination links
                            $('#tableMatakuliah').html($(response).find('#tableMatakuliah').html());
                        }
                    });
                }
            });
            $(document).ready(function() {
                $('#data-matakuliah').DataTable({
                    paging: true,
                    scrollCollapse: true,
                    scrollY: '300px'
                });
            });
        </script>
    @endsection
