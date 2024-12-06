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

            @if (session('error'))
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "{{ session('error') }}",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                </script>
            @endif

            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-semibold text-green-500">Verifikasi Peminjaman Barang</h3>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-lg">

                <div id="tablePeminjaman">
                    @include('components.tables.tableVerifikasipeminjaman', ['peminjamans' => $peminjamans])
                </div>

                <div class="mt-4">
                    {{ $peminjamans->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
