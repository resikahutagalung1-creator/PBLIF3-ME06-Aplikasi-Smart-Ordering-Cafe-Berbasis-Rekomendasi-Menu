
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Cafe - Makanan Enak, Suasana Menyenangkan</title>

    <link rel="stylesheet" href="{{ asset('css/smart-cafe.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<!-- NAVBAR -->
<header class="navbar">

    <a href="/" class="brand">
        <span class="brand-icon">
            <i class="fa-solid fa-mug-hot"></i>
        </span>

        <span>
            <strong>SMART CAFE</strong>
            <small>Makanan Enak, Suasana Menyenangkan</small>
        </span>
    </a>

    <nav class="nav-links">
        <a href="#home">Beranda</a>
        <a href="#menu">Menu Favorit</a>
        <a href="#about">Tentang Kami</a>
        <a href="#features">Keunggulan</a>
    </nav>

    <a href="{{ route('pelanggan.index') }}" class="nav-button">
        Pesan Sekarang
        <i class="fa-solid fa-arrow-right"></i>
    </a>

</header>


<main>

    <!-- HERO -->
    <section class="hero" id="home">

        <div class="hero-overlay"></div>

        <div class="hero-content">

            <span class="hero-label">
                SELAMAT DATANG DI SMART CAFE
            </span>

            <h1>
                Makanan Enak,<br>
                <span>Suasana Menyenangkan.</span>
            </h1>

            <p>
                Temukan makanan dan minuman favoritmu dengan
                pengalaman pemesanan yang lebih mudah dan praktis.
            </p>

            <a href="{{ route('pelanggan.index') }}" class="primary-button">
                Mulai Memesan
                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div class="hero-note">
                Nikmati setiap momen bersama Smart Cafe.
            </div>

        </div>

    </section>


    <!-- MENU FAVORIT -->
    <section class="menu-section" id="menu">

        <div class="section-heading">

            <span class="section-label">MENU PILIHAN</span>

            <h2>Menu Favorit</h2>

            <p>
                Pilihan menu yang siap menemani hari-harimu.
            </p>

        </div>


        <div class="menu-grid">

            @forelse ($menus as $menu)

                <article class="menu-card">

                    <img
                        <img src="{{ asset('images/menu/' . $menu->gambar) }}"
     alt="{{ $menu->nama_menu }}"
                    >

                    <div class="menu-info">

                        <span class="menu-category">
                            MENU SMART CAFE
                        </span>

                        <h3>{{ $menu->nama_menu }}</h3>

                        <p>{{ $menu->deskripsi }}</p>

                        <div class="menu-price">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </div>

                        <div class="menu-rating">
                            <i class="fa-solid fa-fire"></i>
                            Menu pilihan pelanggan
                        </div>

                    </div>

                </article>

            @empty

                <div class="empty-menu">
                    <i class="fa-solid fa-utensils"></i>

                    <h3>Menu Belum Tersedia</h3>

                    <p>
                        Saat ini belum ada menu yang tersedia.
                        Silakan kunjungi kembali nanti.
                    </p>
                </div>

            @endforelse

        </div>


        <div class="menu-action">

            <a href="{{ route('pelanggan.index') }}" class="outline-button">
                Lihat Semua Menu
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>

    </section>


    <!-- TENTANG SMART CAFE -->
    <section class="about-section" id="about">

        <div class="about-image">

            <img src="{{ asset('suasana cafe.png') }}" alt="Suasana Cafe">

        </div>


        <div class="about-content">

            <span class="section-label">
                TENTANG SMART CAFE
            </span>

            <h2>
                Lebih dari Sekadar Tempat Menikmati Kopi
            </h2>

            <p>
                Smart Cafe hadir untuk memberikan pengalaman menikmati
                makanan dan minuman dengan cara yang lebih mudah.
                Kami menghadirkan pilihan menu yang beragam serta
                sistem pemesanan digital yang praktis.
            </p>

            <p>
                Dengan Smart Cafe, pelanggan dapat melihat menu,
                menemukan rekomendasi, melakukan pemesanan,
                dan memantau status pesanan dengan mudah.
            </p>

            <a href="{{ route('pelanggan.index') }}" class="primary-button">
                Jelajahi Menu
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>

    </section>


    <!-- KEUNGGULAN -->
    <section class="features-section" id="features">

        <div class="section-heading">

            <span class="section-label">
                KEUNGGULAN SMART CAFE
            </span>

            <h2>Kenapa Memilih Smart Cafe?</h2>

            <p>
                Pengalaman pemesanan yang dirancang lebih praktis.
            </p>

        </div>


        <div class="features-grid">

            <article class="feature-card">

                <div class="feature-icon">
                    <i class="fa-solid fa-utensils"></i>
                </div>

                <h3>Pilihan Menu Beragam</h3>

                <p>
                    Temukan berbagai makanan dan minuman sesuai selera.
                </p>

            </article>


            <article class="feature-card">

                <div class="feature-icon">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>

                <h3>Rekomendasi Menu</h3>

                <p>
                    Dapatkan rekomendasi untuk membantu memilih menu.
                </p>

            </article>


            <article class="feature-card">

                <div class="feature-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>

                <h3>Pemesanan Praktis</h3>

                <p>
                    Pilih menu dan lakukan pemesanan secara digital.
                </p>

            </article>


            <article class="feature-card">

                <div class="feature-icon">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>

                <h3>Status Pesanan</h3>

                <p>
                    Pantau perkembangan pesanan dengan lebih mudah.
                </p>

            </article>

        </div>

    </section>


    <!-- AJAKAN MEMESAN -->
    <section class="closing-section">

        <span class="section-label">
            KAFE FAVORITMU
        </span>

        <h2>
            Sudah Siap Menikmati Favoritmu?
        </h2>

        <p>
            Pilih menu kesukaanmu dan pesan sekarang di Smart Cafe.
        </p>

        <a href="{{ route('pelanggan.index') }}" class="primary-button">
            Mulai Memesan
            <i class="fa-solid fa-arrow-right"></i>
        </a>

    </section>

</main>


<!-- FOOTER -->
<footer class="footer">

    <div class="footer-brand">

        <strong>
            <i class="fa-solid fa-mug-hot"></i>
            SMART CAFE
        </strong>

        <p>Makanan Enak, Suasana Menyenangkan</p>

    </div>

    <p>
        &copy; {{ date('Y') }} Smart Ordering Café.
        Hak Cipta Dilindungi.
    </p>

</footer>


<script src="{{ asset('js/smart-cafe.js') }}"></script>

</body>
</html>