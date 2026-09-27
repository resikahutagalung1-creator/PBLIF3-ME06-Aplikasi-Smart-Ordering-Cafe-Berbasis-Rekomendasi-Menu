<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Kasir - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
</head>

<body>

<div class="login-page">

    <div class="login-box">

        <div class="login-logo">

            <div class="icon">
                ☕
            </div>

            <h1>SMART CAFE</h1>

            <p>Login Kasir</p>

        </div>

        @if (session('error'))
    <div class="error-message">
        {{ session('error') }}
        </div>
    @endif

        <form action="/kasir/login" method="POST">
    @csrf

            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    required
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <button type="submit" class="login-button">
                Login
            </button>

        </form>


        <div class="login-note">
            Hanya untuk Admin dan Kasir
        </div>

    </div>

</div>

</body>

</html>