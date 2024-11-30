<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo/polindra.png') }}" type="image/x-icon">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            padding: 20px;
            text-align: center;
        }

        .card h1 {
            color: #333;
            font-size: 24px;
        }

        .card p {
            font-size: 16px;
            color: #666;
        }

        .card a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .card a:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="card">
        <img src="{{ asset('logo/polindra.png') }}" alt="" class="object-cover w-full h-24">
        <h1>Lupa Kata Sandi</h1>
        <p>Klik link di bawah ini untuk mereset kata sandi Anda:</p>
        <a href="{{ route('reset-password.index', ['token' => $token]) }}">Reset Password</a>
    </div>

</body>

</html>
