<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Cafe</title>

    <!-- CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('css/smart-cafe.css') }}"
    >
</head>

<body>

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <header class="header">

        <!-- LOGO -->
        <div class="brand">

            <div class="brand-logo">

                <span class="steam steam-1"></span>
                <span class="steam steam-2"></span>
                <span class="steam steam-3"></span>

                <div class="cup">

                    <div class="cup-body"></div>

                    <div class="cup-handle"></div>

                    <div class="cup-saucer"></div>

                </div>

            </div>

            <div class="brand-text">

                <div class="brand-name">
                    SMART CAFE
                </div>

                <div class="brand-tagline">
                    Good Food&nbsp;&nbsp;Good Mood
                </div>

            </div>

        </div>



    </header>


    <!-- =====================================================
         HERO
    ====================================================== -->

    <main class="hero">

        <!-- Background Overlay -->
        <div class="hero-overlay"></div>


        <div class="hero-container">


            <!-- =================================================
                 WELCOME TEXT
            ================================================== -->

            <section class="welcome-section">

                <div class="welcome-small">
                    Selamat Datang di
                </div>

                <h1>
                    Smart Cafe
                </h1>

                <p>
                    Pesan makanan dan minuman favorit Anda dengan mudah,<br>
                    cepat, dan praktis. Nikmati pengalaman terbaik di Smart Cafe.
                </p>


                <!-- ORNAMEN -->
                <div class="ornament">

                    <span class="ornament-line"></span>

                    <span class="coffee-small">
                        ☕
                    </span>

                    <span class="ornament-line"></span>

                </div>

            </section>


            <!-- =================================================
                 PILIHAN AKSES
            ================================================== -->

            <section class="access-container">


                <!-- =================================================
                     PELANGGAN
                ================================================== -->

                <div class="access-card customer-card">

                    <div class="access-icon customer-icon">

                        <span class="big-cup">
                            ☕
                        </span>

                    </div>


                    <h2>
                        Pelanggan
                    </h2>


                    <p>
                        Pesan menu favorit Anda<br>
                        langsung dari website.
                    </p>


                    <!--
                        PELANGGAN TIDAK PERLU LOGIN.
                        Tombol diarahkan ke halaman pelanggan.
                    -->

                    <a
                        href="{{ route('pelanggan.index') }}"
                        class="access-button customer-button"
                    >

                        <span>
                            Pesan Menu
                        </span>

                        <span class="arrow">
                            →
                        </span>

                    </a>

                </div>


                <!-- =================================================
                     KASIR
                ================================================== -->

                <div class="access-card cashier-card">

                    <div class="access-icon cashier-icon">

                        <span class="person">
                            ●
                        </span>

                        <span class="person-body">
                            ●
                        </span>

                        <span class="lock">
                            🔒
                        </span>

                    </div>


                    <h2>
                        Kasir
                    </h2>


                    <p>
                        Login untuk mengelola<br>
                        pesanan dan transaksi.
                    </p>


                    <!--
                        LOGIN KASIR
                    -->

                    <a
                        href="{{ url('/login?role=kasir') }}"
                        class="access-button cashier-button"
                    >

                        <span>
                            Login Kasir
                        </span>

                        <span class="arrow">
                            →
                        </span>

                    </a>

                </div>


                <!-- =================================================
                     ADMIN
                ================================================== -->

                <div class="access-card admin-card">

                    <div class="access-icon admin-icon">
                        ⚙
                    </div>


                    <h2>
                        Admin
                    </h2>


                    <p>
                        Login untuk mengelola menu,<br>
                        kasir, dan laporan.
                    </p>


                    <!--
                        LOGIN ADMIN
                    -->

                    <a
                        href="{{ url('/login?role=admin') }}"
                        class="access-button admin-button"
                    >

                        <span>
                            Login Admin
                        </span>

                        <span class="arrow">
                            →
                        </span>

                    </a>

                </div>


            </section>

        </div>

    </main>


    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer class="footer">

        <div class="footer-line"></div>

        <span class="footer-icon">
            ☕
        </span>

        <span class="footer-text">
            Smart Ordering Café
        </span>

        <span class="footer-icon">
            ☕
        </span>

        <div class="footer-line"></div>

    </footer>


    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script
        src="{{ asset('js/smart-cafe.js') }}"
    ></script>

</body>

</html>