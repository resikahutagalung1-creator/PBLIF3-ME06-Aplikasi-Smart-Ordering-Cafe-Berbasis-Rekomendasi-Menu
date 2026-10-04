<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Cafe</title>


    <!-- =====================================================
         CSS
    ====================================================== -->

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

        <div class="brand">


            <!-- =================================================
                 LOGO SMART CAFE
            ================================================== -->

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


            <!-- =================================================
                 BRAND TEXT
            ================================================== -->

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


        <!-- BACKGROUND OVERLAY -->

        <div class="hero-overlay"></div>



        <div class="hero-container">


            <!-- =================================================
                 WELCOME SECTION
            ================================================== -->

            <section class="welcome-section">


                <div class="welcome-small">
                    Selamat Datang di
                </div>


                <h1>
                    Smart Cafe
                </h1>


                <p>
                    Pesan makanan dan minuman favorit Anda dengan mudah,
                    <br>
                    cepat, dan praktis. Nikmati pengalaman terbaik di Smart Cafe.
                </p>



                <!-- =================================================
                     ORNAMENT
                ================================================== -->

                <div class="ornament">

                    <span class="ornament-line"></span>

                    <span class="coffee-small"></span>

                    <span class="ornament-line"></span>

                </div>

            </section>



            <!-- =================================================
                 ACCESS CONTAINER
            ================================================== -->

            <section class="access-container">



                <!-- =================================================
                     PELANGGAN
                ================================================== -->

                <div class="access-card customer-card">


                    <!-- IKON CANGKIR KOPI -->

                    <div class="access-icon customer-icon">

                        <svg
                            viewBox="0 0 48 48"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >

                            <!-- Uap kopi -->

                            <path
                                d="M17 12 C14 9, 19 7, 17 4"
                            ></path>

                            <path
                                d="M24 12 C21 9, 26 7, 24 4"
                            ></path>

                            <path
                                d="M31 12 C28 9, 33 7, 31 4"
                            ></path>


                            <!-- Badan cangkir -->

                            <path
                                d="M9 17 H34 V27
                                   C34 34 29 38 21.5 38
                                   C14 38 9 34 9 27 Z"
                            ></path>


                            <!-- Pegangan cangkir -->

                            <path
                                d="M34 20 H38
                                   C42 20 43 23 43 26
                                   C43 30 41 32 37 32
                                   H34"
                            ></path>


                            <!-- Alas cangkir -->

                            <path
                                d="M7 41 H38"
                            ></path>

                        </svg>

                    </div>



                    <h2>
                        Pelanggan
                    </h2>


                    <p>
                        Pesan menu favorit Anda
                        <br>
                        langsung dari website.
                    </p>



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


                    <!-- IKON KASIR -->

                    <div class="access-icon cashier-icon">

                        <svg
                            viewBox="0 0 48 48"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >

                            <!-- Kepala -->

                            <circle
                                cx="22"
                                cy="14"
                                r="5"
                            ></circle>


                            <!-- Badan -->

                            <path
                                d="M12 34
                                   C12.8 26.5 16.2 22.5 22 22.5
                                   C27.8 22.5 31.2 26.5 32 34"
                            ></path>


                            <!-- Kotak kecil / tanda kasir -->

                            <rect
                                x="29"
                                y="27"
                                width="10"
                                height="10"
                                rx="2"
                            ></rect>


                            <path
                                d="M34 29.5 V34.5"
                            ></path>

                            <path
                                d="M31.5 32 H36.5"
                            ></path>

                        </svg>

                    </div>



                    <h2>
                        Kasir
                    </h2>


                    <p>
                        Login untuk mengelola
                        <br>
                        pesanan dan transaksi.
                    </p>



                    <a
                       href="{{ url('/kasir/login') }}"
                       class="access-button cashier-button"
>
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


                    <!-- IKON ADMIN -->

                    <div class="access-icon admin-icon">

                        <svg
                            viewBox="0 0 48 48"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                        >

                            <!-- Gear -->

                            <path
                                d="
                                M24 8
                                L27 10
                                L30.5 9
                                L32.5 12
                                L36 13
                                L35.5 17
                                L38 20
                                L35.5 23
                                L36 27
                                L32.5 28
                                L30.5 31
                                L27 30
                                L24 32
                                L21 30
                                L17.5 31
                                L15.5 28
                                L12 27
                                L12.5 23
                                L10 20
                                L12.5 17
                                L12 13
                                L15.5 12
                                L17.5 9
                                L21 10
                                Z
                                "
                            ></path>


                            <!-- Lingkaran tengah -->

                            <circle
                                cx="24"
                                cy="20"
                                r="5"
                            ></circle>

                        </svg>

                    </div>



                    <h2>
                        Admin
                    </h2>


                    <p>
                        Login untuk mengelola menu,
                        <br>
                        kasir, dan laporan.
                    </p>



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


        <span class="footer-icon"></span>


        <span class="footer-text">
            Smart Ordering Café
        </span>


        <span class="footer-icon"></span>


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