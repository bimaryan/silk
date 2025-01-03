<nav class="fixed top-0 z-50 w-full shadow bg-gray-50 dark:text-white dark:bg-gray-900">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start gap-2 rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a class="flex flex-col items-center">
                    <img src="{{ asset('image/logo/silk.png') }}" class="hidden w-24 md:block"
                        alt="{{ asset('image/logo/silk.png') }}" />
                    <img src="{{ asset('image/logo/polindra.png') }}" class="w-10 md:hidden"
                        alt="{{ asset('image/logo/polindra.png') }}" />
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div class="flex items-center gap-4">
                        @if (Auth::user()->role->nama_role === 'Staff')
                            <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification"
                                class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400"
                                type="button">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 14 20">
                                    <path
                                        d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                                </svg>
                                <div
                                    class="absolute block w-5 h-5 bg-red-500 border-2 border-white rounded-full -top-0.5 start-2.5 dark:border-gray-900">
                                    <p class="text-white text-xs">
                                        {{ $notifikasi->count() ?? 0 }}
                                    </p>
                                </div>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdownNotification"
                                class="z-20 hidden max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700"
                                aria-labelledby="dropdownNotificationButton">
                                <div
                                    class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                                    Notifikasi
                                </div>
                                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @if ($notifikasi->isNotEmpty())
                                        @foreach ($notifikasi as $item)
                                            <a href="{{ $item->persetujuan === 'Belum Diserahkan' ? route('verifikasi-peminjaman.index', $item->id) : route('verifikasi-pengembalian.index', $item->id) }}"
                                                class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $item instanceof App\Models\Peminjaman ? 'Peminjaman' : 'Pengembalian' }}
                                                        - {{ $item->created_at->format('d M Y, H:i') }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        Nama: {{ $item->user->nama }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        Status: {{ $item->persetujuan }}
                                                    </p>
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        <p class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">Tidak ada
                                            notifikasi.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif




                        <div class="hidden md:block">
                            <div class="flex-col text-right md:flex">
                                <p class="text-sm">{{ Auth::user()->nama }}</p>
                                <p class="text-xs">
                                    {{ Auth::user()->role->nama_role ? Auth::user()->role->nama_role : 'No Role Assigned' }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="{{ asset('image/icon_profile.png') }}"
                                    alt="user photo">
                            </button>
                        </div>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown-user">
                        <ul class="py-1" role="none">
                            <li>
                                <a href="{{ route('logout.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Keluar <i class="fa-solid fa-right-from-bracket"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 mt-3 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Route::is('dashboard.index') ? 'bg-green-500 text-white' : '' }}">
                    <span class="flex-1 ms-3 whitespace-nowrap"><i
                            class="fa-solid fa-table-columns me-2"></i>Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->role->nama_role === 'Admin')
                <li>
                    <a id="pengguna" data-collapse-toggle="users" aria-controls="pengguna"
                        class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Request::is('pengguna/*') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap">
                            <i class="fa-solid fa-users me-2"></i>Pengguna</span><i
                            class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul id="users" class="hidden py-2 space-y-2" aria-labelledby="pengguna">
                        <li>
                            <a href="{{ route('admin-dan-staff.index') }}"
                                class="flex gap-1 items-center w-full p-2  transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ Route::is('admin-dan-staff.index') ? 'bg-gray-300' : '' }}">
                                <i class="fa-solid fa-user me-2"></i>Admin dan Staff
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('data-mahasiswa.index') }}"
                                class="flex gap-1 items-center w-full p-2  transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ Route::is('data-mahasiswa.index') ? 'bg-gray-300' : '' }}">
                                <i class="fa-solid fa-user me-2"></i>Mahasiswa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('data-dosen.index') }}"
                                class="flex gap-1 items-center w-full p-2  transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ Route::is('data-dosen.index') ? 'bg-gray-300' : '' }}">
                                <i class="fa-solid fa-user me-2"></i>Dosen
                            </a>
                        </li>
                    </ul>
                </li>
                <li>

                    <a href="{{ route('data-kelas.index') }}"
                        class="mt-2 flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Route::is('data-kelas.index') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i
                                class="fa-solid fa-landmark me-2"></i>Kelas</span>
                    </a>
                </li>
                <li>

                    <a href="{{ route('data-mata-kuliah.index') }}"
                        class="mt-2 flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Route::is('data-mata-kuliah.index') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-book"></i> Mata
                            Kuliah</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('data-spo.index') }}"
                        class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Route::is('data-spo.index') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-file-lines"></i> Dokumen
                            SPO</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan-peminjaman.index') }}"
                        class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Route::is('laporan-peminjaman.index') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i
                                class="fa-solid fa-chart-simple me-2"></i>Laporan
                            Peminjaman</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ url('settings/link-api') }}"
                        class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ request::is('settings/link-api') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-link"></i> Link API</span>
                    </a>
                </li> --}}
            @endif
            @if (Auth::user()->role->nama_role === 'Staff')
                <li>
                    <a id="kelolaproduk" data-collapse-toggle="dropdown"
                        class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Request::is('data/*') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-folder me-2"></i>Alat dan
                            Bahan</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>

                    <ul id="dropdown" class="hidden py-2 space-y-2" aria-labelledby="kelolaproduk">
                        <li>
                            <a href="{{ route('barang.index') }}"
                                class="flex gap-1 items-center w-full p-2  transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ Route::is('barang.index') ? 'bg-gray-300' : '' }}"><i
                                    class="fa-solid fa-folder-open"></i> Data
                                Barang</a>
                        </li>
                        <li>
                            <a href="{{ route('kategori.index') }}"
                                class="flex gap-1 items-center w-full p-2  transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ Route::is('kategori.index') ? 'bg-gray-300' : '' }}"><i
                                    class="fa-solid fa-folder-open"></i> Data
                                Kategori</a>
                        </li>
                        <li>
                            <a href="{{ route('satuan.index') }}"
                                class="flex gap-1 items-center w-full p-2  transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ Route::is('satuan.index') ? 'bg-gray-300' : '' }}"><i
                                    class="fa-solid fa-folder-open"></i> Data
                                Satuan</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('ruangan.index') }}"
                        class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Route::is('ruangan.index') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-door-open"></i> Ruang
                            Laboratorium</span>
                    </a>
                </li>
                <li>
                    <a id="verifikasi" data-collapse-toggle="dropdownVerifikasi"
                        class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Request::is('verifikasi/*') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-square-check me-2"></i>
                            Verifikasi</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>

                    <ul id="dropdownVerifikasi" class="hidden py-2 space-y-2" aria-labelledby="verifikasi">
                        <li>
                            <a href="{{ route('verifikasi-peminjaman.index') }}"
                                class="flex gap-1 items-center w-full p-2  transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700  {{ Route::is('verifikasi-peminjaman.index') ? 'bg-gray-300' : '' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-box"></i>
                                    Peminjaman</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('verifikasi-pengembalian.index') }}"
                                class="flex gap-1 items-center w-full p-2  transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700  {{ Route::is('verifikasi-pengembalian.index') ? 'bg-gray-300' : '' }}">
                                <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-box-open"></i>
                                    Pengembalian</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('laporan-peminjaman.index') }}"
                        class="flex items-center p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group  {{ Route::is('laporan-peminjaman.index') ? 'bg-green-500 text-white' : '' }}">
                        <span class="flex-1 ms-3 whitespace-nowrap"><i class="fa-solid fa-chart-simple"></i> Laporan
                            Peminjaman</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
