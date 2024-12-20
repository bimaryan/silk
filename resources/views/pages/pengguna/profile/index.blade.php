<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- @vite('resources/css/app.css') --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/f74deb4653.js" crossorigin="anonymous"></script>
    <link rel="icon" href="{{ asset('logo/polindra.png') }}" type="image/x-icon">
    <title>SILK &mdash; Profile</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        body {
            font-family: "Montserrat", sans-serif;
            font-style: normal;
        }

        .background {
            position: relative;
            width: 100%;
            height: 100%;
            /* background-image: url('{{ asset('image/iteralab.png') }}'); */
            background-size: cover;
            background-position: center;
        }

        .background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background-color: rgba(0, 0, 0, 0.5); */
            z-index: -1;
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('components.navbar.navbarPengguna')
    <div>
        @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: "#3085d6",
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: "#3085d6",
            });
        </script>
    @endif
        <div class="max-w-screen-xl p-6 mx-auto mt-14">
            <div class="mt-4">
                <div class="p-4 mt-4 bg-white border rounded-lg shadow-lg">
                    <nav class="bg-white dark:bg-gray-700">
                        <div class="max-w-screen-xl px-4 py-3 mx-auto">
                            <div class="flex items-center">
                                <ul class="flex flex-row mt-0 space-x-8 text-sm font-medium rtl:space-x-reverse">
                                    <li>
                                        <a href="{{ route('edit-profile.index') }}"
                                            class="block text-grey-600  {{ Route::is('edit-profile.index') ? 'text-green-500' : '' }}">Data
                                            Diri</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('edit-password.index') }}"
                                            class="block text-gray-600 {{ Route::is('edit-password.index') ? 'text-green-500' : '' }}">Ubah
                                            Kata Sandi</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>

                    <hr class="my-1" />

                    @yield('content-profile')
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>

</html>
