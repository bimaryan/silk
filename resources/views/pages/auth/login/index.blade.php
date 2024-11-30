<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- @vite('resources/css/app.css') --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('image/logo/polindra.png') }}" type="image/x-icon">
    <title>SILK &mdash; Login</title>
    <style>
        .background {
            position: relative;
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('image/gedungGSC.jpg') }}');
            background-size: cover;
            background-position: center;
            filter: blur(3px);
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="flex flex-col items-center justify-center h-screen p-4 space-y-4 background">
        <div class="flex justify-center">
            <img src="{{ asset('image/logo/polindra.png') }}" alt="" class="object-cover w-full h-24">
        </div>

        <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-6 text-3xl font-bold text-center text-green-500">Masuk</h2>

            <form action="{{ route('login.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf

                <!-- Email -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Username/NIM</label>
                    <input type="text" id="name" name="identifier"
                        class="w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan Username/NIM">
                    {{-- @error('identifier')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror --}}
                </div>

                <!-- Password -->
                <div class="relative ">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Kata Sandi</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Masukkan Password">
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 mt-7 mr-3">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>

                </div>

                <div>
                    {{-- CAPTCHA --}}
                    <label for="captcha" class="block mb-2 text-sm font-medium text-gray-600">Kode Verifikasi</label>
                    <div class="flex gap-2 items-center">
                        <div>
                            <div
                                class="px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                {{ $captcha }}
                            </div>
                        </div>
                        <div>
                            <input type="text" id="captcha" name="captcha"
                                class="w-full px-5 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Masukkan kode verifikasi">
                        </div>
                    </div>
                    @error('captcha')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <p class="mt-4 text-sm text-right text-gray-600">
                    <a href="{{ route('forgot-password.index') }}" class="text-green-500 hover:underline">Lupa kata sandi?</a>
                </p>
                <!-- Login Button -->
                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Masuk</button>
            </form>
        </div>
    </div>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', () => {
                // Toggle tipe input
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.replace('text-gray-500', 'text-green-500'); // Ganti warna ikon
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.replace('text-green-500', 'text-gray-500'); // Kembalikan warna ikon
                }
            });
        });
    </script>
</body>

</html>
