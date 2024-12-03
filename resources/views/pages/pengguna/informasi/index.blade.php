@extends('pengguna')

@section('content')
    <div class="max-w-screen-xl mx-auto p-6 mt-14">
        <div class="flex justify-center items-center mt-6">
            <div>
                <p class="text-2xl text-green-500 font-semibold">
                    Informasi Peminjaman
                </p>
            </div>
        </div>

        <hr class="my-3">

        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Pemberitahuan!</span> Silahkan datang ke lab terpadu untuk mengambil atau
                mengembalikan barang
                yang di pinjam, sertakan bukti peminjaman.
            </div>
        </div>

        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full bg-white text-sm text-center text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs bg-gray-300 text-gray-700 uppercase dark:text-gray-400 bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        @if (Auth::guard('mahasiswa')->check())
                            <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                        @elseif(Auth::guard('dosen')->check())
                            <th scope="col" class="px-6 py-3">Nama Dosen</th>
                        @endif
                        <th scope="col" class="px-6 py-3">Nama Barang</th>
                        <th scope="col" class="px-6 py-3">Jumlah Barang</th>
                        <th scope="col" class="px-6 py-3">Sisa Waktu</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($peminjaman->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-3 text-center text-gray-500 border">
                                Tidak ada peminjaman
                            </td>
                        </tr>
                    @else
                        @foreach ($peminjaman as $data)
                            @if ($data->status != 'Dikembalikan')
                                <tr class="border-gray-200 border-b">
                                    <td scope="col" class="px-6 py-3">
                                        {{ $loop->iteration }}
                                    </td>
                                    @if (Auth::guard('mahasiswa')->check())
                                        <td scope="col" class="px-6 py-3">
                                            {{ $data->mahasiswa->nama }}
                                        </td>
                                    @elseif(Auth::guard('dosen')->check())
                                        <td scope="col" class="px-6 py-3">
                                            {{ $data->dosen->nama }}
                                        </td>
                                    @endif
                                    <td scope="col" class="px-6 py-3">
                                        {{ $data->keranjang->barang->nama_barang }}
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        {{ $data->keranjang->stock_pinjam }}
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        <span id="time-remaining-{{ $data->id }}" class="text-red-500"></span>
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        {{ $data->status }}
                                    </td>
                                    <td scope="col" class="px-6 py-3 flex justify-center items-center gap-2">
                                        <div>
                                            <button type="button" data-modal-target="detail{{ $data->id }}"
                                                data-modal-toggle="detail{{ $data->id }}"
                                                class="py-2 px-2 bg-yellow-400 rounded text-sm text-white flex items-center">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    function updateTimeRemaining(dataId, waktu_pengembalian) {
                                        const timeElement = document.getElementById(`time-remaining-${dataId}`);
                                        const now = new Date().getTime();
                                        let distance = waktu_pengembalian - now;

                                        if (distance < 0) {
                                            timeElement.innerHTML = "Waktu Kembali Sudah Lewat";
                                            return;
                                        }

                                        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                        timeElement.innerHTML = `${hours} Jam ${minutes} Menit ${seconds} Detik`;
                                    }

                                    @foreach ($peminjaman as $data)
                                        const waktu_pengembalian = {{ $data->waktu_kembali_unix }} * 1000;
                                        setInterval(() => updateTimeRemaining({{ $data->id }}, waktu_pengembalian), 1000);
                                    @endforeach
                                });
                            </script>

                            <div id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Detail Peminjaman
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="detail{{ $data->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>

                                        <div class="p-4 flex flex-col md:flex-row items-center gap-5">
                                            <div class="w-44 flex justify-center rounded-lg">
                                                <img src="{{ asset($data->foto ?? 'image/barang.png') }}" alt="">
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div class="space-y-2">
                                                    @if (Auth::guard('mahasiswa')->check())
                                                        <p
                                                            class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                            <span>Nim Mahasiswa</span>
                                                            <span>:</span>
                                                        </p>
                                                        <p
                                                            class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                            <span>Nama Mahasiswa</span>
                                                            <span>:</span>
                                                        </p>
                                                        <p
                                                            class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                            <span>Kelas Mahasiswa</span>
                                                            <span>:</span>
                                                        </p>
                                                    @elseif(Auth::guard('dosen')->check())
                                                        <p
                                                            class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                            <span>Nama Dosen</span>
                                                            <span>:</span>
                                                        </p>
                                                    @endif
                                                    <p
                                                        class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                        <span>Nama Ruangan</span>
                                                        <span>:</span>
                                                    </p>
                                                    <p
                                                        class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                        <span>Nama Barang</span>
                                                        <span>:</span>
                                                    </p>
                                                    <p
                                                        class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                        <span>Jumlah Barang</span>
                                                        <span>:</span>
                                                    </p>
                                                    <p
                                                        class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                        <span>Tanggal Peminjaman</span>
                                                        <span>:</span>
                                                    </p>
                                                    <p
                                                        class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                        <span>Waktu Pengembalian</span>
                                                        <span>:</span>
                                                    </p>
                                                    <p
                                                        class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                        <span>Tindakan SPO</span>
                                                        <span>:</span>
                                                    </p>
                                                    <p
                                                        class="text-sm text-gray-900 dark:text-white font-medium flex justify-between">
                                                        <span>Status</span>
                                                        <span>:</span>
                                                    </p>
                                                </div>
                                                <div class="space-y-2">
                                                    @if (Auth::guard('mahasiswa')->check())
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $data->mahasiswa->nim }}
                                                        </p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $data->mahasiswa->nama }}
                                                        </p>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ Auth::user()->kelas->nama_kelas }}
                                                        </p>
                                                    @elseif(Auth::guard('dosen')->check())
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ Auth::user()->dosen->nama }}
                                                        </p>
                                                    @endif
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $data->ruangan->nama_ruangan ?? 'null' }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $data->keranjang->barang->nama_barang }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $data->keranjang->stock_pinjam }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($data->tanggal_waktu_peminjaman)->format('d M Y') }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($data->waktu_pengembalian)->format('H:i') }}
                                                        WIB
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $data->keranjang->tindakan_spo ?? 'Tidak ada keterangan' }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $data->status }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $peminjaman->links() }}
        </div>
    </div>
@endsection
