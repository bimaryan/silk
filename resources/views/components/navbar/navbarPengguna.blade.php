<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('beranda.index') }}" class="flex flex-col items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('image/logo/silk.png') }}" class="hidden w-24 md:block "
                alt="{{ asset('image/logo/silk.png') }}" />
            <img src="{{ asset('image/logo/polindra.png') }}" class="w-10 md:hidden"
                alt="{{ asset('image/logo/polindra.png') }}" />
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification"
                class="me-4 relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400"
                type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25q0-.075.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2" />
                </svg>
                <div
                    class="absolute block w-5 h-5 bg-red-500 border-2 border-white rounded-full -top-0.5 start-2.5 dark:border-gray-900">
                    <p class="text-white text-xs">
                        {{ $dataKeranjang->count() ?? 0 }}
                    </p>
                </div>
            </button>

            <!-- Dropdown keranjang -->
            <div id="dropdownNotification"
                class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700"
                aria-labelledby="dropdownNotificationButton">
                <div
                    class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                    Keranjang
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @if ($dataKeranjang->isNotEmpty())
                            @foreach ($dataKeranjang as $item)
                                <div class="flex items-center px-4 py-3">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item->barang->nama_barang }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah:
                                            {{ $item->jumlah_pinjam }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">Keranjang Anda kosong.</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('peminjaman.create') }}"
                    class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
                    <div class="inline-flex items-center ">
                        <svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                            <path
                                d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                        </svg>
                        Lihat Semua
                    </div>
                </a>
            </div>

            <button type="button"
                class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="user photo">
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                id="user-dropdown">
                <div class="px-4 py-3">
                    @if (Auth::guard('mahasiswa')->check())
                        <span
                            class="block text-sm text-gray-900 dark:text-white">{{ Auth::guard('mahasiswa')->user()->nama }}</span>
                        <span
                            class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ Auth::guard('mahasiswa')->user()->kelas ?? '-' }}</span>
                    @elseif (Auth::guard('dosen')->check())
                        <span
                            class="block text-sm text-gray-900 dark:text-white">{{ Auth::guard('dosen')->user()->nama }}</span>
                    @endif
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <a href="{{ route('edit-profile.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('logout.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                            Keluar
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <button data-collapse-toggle="navbar-user" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col p-4 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="{{ route('beranda.index') }}"
                        class="block py-2 px-3 rounded md:bg-transparent md:p-0
           {{ Route::is('beranda.index') ? 'text-white bg-green-700 md:text-green-700 md:bg-transparent' : 'text-gray-900 md:hover:text-green-700 dark:text-white dark:hover:bg-gray-700' }}"
                        aria-current="page">Home</a>
                </li>
                <li>
                    <a href="{{ route('katalog.index') }}"
                        class="block py-2 px-3 rounded md:border-0 md:p-0
           {{ Route::is('katalog.index') ? 'text-white bg-green-700 md:text-green-700 md:bg-transparent' : 'text-gray-900 md:hover:text-green-700 dark:text-white dark:hover:bg-gray-700' }}">Katalog</a>
                </li>
                <li>
                    <a href=""
                        class="block py-2 px-3 rounded md:border-0 md:p-0
           {{ Route::is('ruangan.index') ? 'text-white bg-green-700 md:text-green-700 md:bg-transparent' : 'text-gray-900 md:hover:text-green-700 dark:text-white dark:hover:bg-gray-700' }}">Ruangan</a>
                </li>
                
                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="informasidropdown" class="flex items-center justify-between w-full py-2 px-3 rounded md:border-0 md:p-0
           {{ Route::is('informasi.index') ? 'text-white bg-green-700 md:text-green-700 md:bg-transparent' : 'text-gray-900 md:hover:text-green-700 dark:text-white dark:hover:bg-gray-700' }}">Informasi 
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="informasidropdown" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                          <li>
                            <a href="{{ route('informasi-peminjaman.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Peminjaman</a>
                          </li>
                          <li>
                            <a href="{{ route('informasi-pengembalian.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pengembalian</a>
                          </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href=""
                        class="block py-2 px-3 rounded md:border-0 md:p-0
           {{ Route::is('') ? 'text-white bg-green-700 md:text-green-700 md:bg-transparent' : 'text-gray-900 md:hover:text-green-700 dark:text-white dark:hover:bg-gray-700' }}">Riwayat
                        Peminjaman</a>
                </li>
            </ul>
        </div>
    </div>

</nav>
