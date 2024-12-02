{{-- <footer class=" w-full bg-white border-t dark:bg-gray-900">
    <div class="container mx-auto">
        <div class="grid grid-cols-2 gap-8 px-4 py-6 lg:py-8 md:grid-cols-3">
            <!-- Logo -->
            <div class="mb-6 md:mb-0">
                <a href="{{ route('beranda.index') }}" class="flex items-center">
                    <img src="{{ asset('logo/polindra.png') }}" style="width: 30%" alt="Logo Polindra" />
                    <span class="self-center text-2xl font-semibold text-green-500 whitespace-nowrap">SILK</span>
                </a>
            </div>

            <!-- Tautan -->
            <div>
                <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Tautan</h2>
                <ul class="font-medium text-gray-500 dark:text-gray-400">
                    <li class="mb-4">
                        <a href="{{ route('beranda.index') }}" class="hover:underline">Home</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('katalog.index') }}" class="hover:underline">Katalog</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('informasi.index') }}" class="hover:underline">Informasi</a>
                    </li>
                </ul>
            </div>

            <!-- Alamat dan Kontak -->
            <div>
                <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Alamat & Kontak</h2>
                <div>
                    <p class="flex font-medium text-gray-900 dark:text-white">
                        <span class="me-2"><i class="fa-solid fa-location-dot"></i></span>
                        Jl. Lohbener Lama No.08, Lohbener, Legok, Indramayu, Jawa Barat<br>45252
                    </p>
                    <p class="flex font-medium text-gray-900 dark:text-white mt-2">
                        <span class="me-2"><i class="fa-solid fa-phone"></i></span>
                        (0234) 5746464
                    </p>
                    <p class="flex font-medium text-gray-900 dark:text-white mt-2">
                        <span class="me-2"><i class="fa-solid fa-envelope"></i></span>
                        info@polindra.ac.id
                    </p>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
            © 2024 <a href="https://polindra.ac.id" class="hover:underline">Polindra</a>. All Rights Reserved.
        </span>
    </div>
</footer> --}}



<footer class="bg-white rounded-lg shadow dark:bg-gray-900 m-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="{{ route('beranda.index') }}" class="flex items-center">
                    <img src="{{ asset('logo/polindra.png') }}" style="width: 30%" alt="Logo Polindra" />
                    <span class="self-center text-2xl font-semibold text-green-500 whitespace-nowrap">SILK</span>
                </a>
            </div>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="{{ route('beranda.index') }}" class="hover:underline me-4 md:me-6">Beranda</a>
                </li>
                <li>
                    <a href="{{ route('katalog.index') }}" class="hover:underline me-4 md:me-6">Katalog</a>
                </li>
                <li>
                    <a href="{{ route('informasi.index') }}"class="hover:underline me-4 md:me-6">Informasi</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
            © 2024 <a href="https://polindra.ac.id" class="hover:underline">Polindra</a>. All Rights Reserved.
        </span>
    </div>
</footer>

