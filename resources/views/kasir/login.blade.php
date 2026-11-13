
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kasir - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<div class="auth-split">

    <div class="auth-visual">
        <div class="auth-overlay"></div>

        <div class="auth-brand">

            <h1>SMART CAFE</h1>
            <p>Good Food Good Mood</p>
        </div>

        <div class="auth-visual-bottom">
            <h2>Selamat Datang Kembali</h2>
            <p>Layani pelanggan dengan lebih cepat dan kelola pesanan cafe dengan mudah.</p>
        </div>
    </div>

    <div class="auth-form-section">

        <div class="auth-form-container">

            <div class="auth-heading">
                <span class="auth-label">STAFF AREA</span>
                <h2>Login Kasir</h2>
                <p>Silakan masuk menggunakan akun kasir Anda.</p>
            </div>

            @if (session('error'))
                <div class="auth-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="/kasir/login" method="POST">
                @csrf

                <div class="auth-input-group">
                    <label for="username">Username</label>

                    <div class="auth-input">
                        <i class="fa-solid fa-user"></i>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="auth-input-group">
                    <label for="password">Password</label>

                    <div class="auth-input">
                        <i class="fa-solid fa-lock"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="auth-button">
                    Masuk sebagai Kasir
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="auth-footer">
                <i class="fa-solid fa-shield-halved"></i>
                Halaman khusus Kasir
            </div>

        </div>

    </div>

</div>

</body>
</html>