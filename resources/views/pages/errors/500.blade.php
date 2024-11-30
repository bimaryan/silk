<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/f74deb4653.js" crossorigin="anonymous"></script>
    <title>500 - Internal Server Error</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="max-w-md p-6 bg-white border border-gray-200 rounded-lg shadow-lg text-center">
        <div class="flex justify-center mb-4">
            <i class="bi bi-exclamation-circle text-red-500 text-6xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">500 Internal Server Error</h2>
        <p class="text-gray-600 mb-4">Oops! Something went wrong on our server.</p>
        <a href="{{ route('login.index') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-red-600">
            Go Back
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>

</html>
