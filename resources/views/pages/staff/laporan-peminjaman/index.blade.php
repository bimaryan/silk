@extends('index')
@section('content')
    <div class="p-4 mt-3 sm:ml-64">
        <div class="space-y-4 rounded-lg mt-14">
            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-semibold text-green-500">Laporan Peminjaman</h3>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <a href="" data-tooltip-target="export" data-tooltip-placement="left"
                                class="justify-center px-4 py-2
                            text-white bg-green-500 rounded hover:bg-green-800">
                                <i class="fa-solid fa-file-arrow-down"></i>
                            </a>

                            <div id="export" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Export
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-lg">
                <form method="GET" action="{{ route('laporan-peminjaman.index') }}" class="mb-4 mt-2">
                    <div class="flex gap-4 items-center">
                        <!-- Filter Bulan -->
                        <select name="bulan"
                            class="p-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            <option value="">Pilih Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromDate(null, $i, 1)->format('F') }}
                                </option>
                            @endfor
                        </select>

                        <!-- Filter Tahun -->
                        <select name="tahun"
                            class="p-2 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            <option value="">Pilih Tahun</option>
                            @for ($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>

                        <!-- Tombol Submit -->
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                            Filter
                        </button>
                    </div>
                </form>
                
                <div id="tableLaporan">
                    @include('components.tables.tableLaporanpeinjaman', ['peminjamans' => $peminjamans])
                </div>

                <div class="mt-4">
                    {{ $peminjamans->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
