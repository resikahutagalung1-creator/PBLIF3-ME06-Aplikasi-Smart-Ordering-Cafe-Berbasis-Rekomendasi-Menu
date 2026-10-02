<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

<div class="admin-container">

    <!-- =====================================================
         SIDEBAR
    ====================================================== -->

    <aside class="sidebar">

        <!-- LOGO -->

        <div class="logo">

            <div class="logo-icon">
                ☕
            </div>

            <div class="logo-text">

                <div class="logo-title">
                    SMART CAFE
                </div>

                <div class="logo-subtitle">
                    Smart Ordering Cafe
                </div>

            </div>

        </div>


        <!-- MENU SIDEBAR -->

        <ul class="sidebar-menu">

            <!-- DASHBOARD -->

            <li>
                <a href="/admin/dashboard" class="active">

                    <span class="menu-icon">
                        ⌂
                    </span>

                    <span class="menu-text">
                        Dashboard
                    </span>

                </a>
            </li>


            <!-- KELOLA MENU -->

            <li>
                <a href="#">

                    <span class="menu-icon">
                        ▤
                    </span>

                    <span class="menu-text">
                        Kelola Menu
                    </span>

                </a>
            </li>


            <!-- KELOLA DATA PENGGUNA -->

            <li>
                <a href="#">

                    <span class="menu-icon">
                        ♙
                    </span>

                    <span class="menu-text">
                        Kelola Data Pengguna
                    </span>

                </a>
            </li>

        </ul>


        <!-- =================================================
             BAGIAN BAWAH SIDEBAR
        ================================================== -->

        <div class="sidebar-bottom">

            <div class="sidebar-coffee">
                ☕
            </div>

            <div>
                Admin
            </div>

            <div>
                Smart Cafe
            </div>

            <div class="sidebar-bottom-line"></div>

        </div>

    </aside>


    <!-- =====================================================
         MAIN
    ====================================================== -->

    <main class="main">


        <!-- =================================================
             TOP BAR
        ================================================== -->

        <div class="top-bar">

            <div class="staff">

                <div class="staff-icon">
                    👤
                </div>

                <span>
                    Admin
                </span>

                <a
                    href="/admin/logout"
                    class="admin-top-logout"
                >
                    Logout
                </a>

            </div>

        </div>


        <!-- =================================================
             CONTENT
        ================================================== -->

        <div class="content">


            <!-- =================================================
                 JUDUL
            ================================================== -->

            <div class="page-title">

                <h1>
                    Selamat Datang, Admin!
                </h1>

                <p>
                    Kelola menu dan data pengguna Smart Cafe.
                </p>

                <div class="title-line"></div>

            </div>


            <!-- =================================================
                 STATISTIK
            ================================================== -->

            <div class="stats">


                <!-- TOTAL MENU -->

                <div class="stat">

                    <div class="stat-icon">
                        ☕
                    </div>

                    <div class="stat-content">

                        <div class="stat-title">
                            Total Menu
                        </div>

                        <div class="stat-number">
                            -
                        </div>

                    </div>

                    <div class="stat-arrow">
                        ↗
                    </div>

                </div>


                <!-- TOTAL PENGGUNA -->

                <div class="stat">

                    <div class="stat-icon">
                        👥
                    </div>

                    <div class="stat-content">

                        <div class="stat-title">
                            Total Pengguna
                        </div>

                        <div class="stat-number">
                            -
                        </div>

                    </div>

                    <div class="stat-arrow">
                        →
                    </div>

                </div>


                <!-- TOTAL KASIR -->

                <div class="stat">

                    <div class="stat-icon stat-icon-success">
                        ♙
                    </div>

                    <div class="stat-content">

                        <div class="stat-title">
                            Total Kasir
                        </div>

                        <div class="stat-number">
                            -
                        </div>

                    </div>

                    <div class="stat-arrow">
                        ↗
                    </div>

                </div>

            </div>


            <!-- =================================================
                 CARD MENU ADMIN
            ================================================== -->

            <div class="card">


                <!-- HEADER CARD -->

                <div class="card-header">

                    <div class="card-title-wrapper">

                        <div class="card-title-icon">
                            ▤
                        </div>

                        <div class="card-title">
                            Menu Admin
                        </div>

                    </div>

                </div>


                <!-- =================================================
                     MENU ADMIN
                ================================================== -->

                <div class="admin-menu-grid">


                    <!-- KELOLA MENU -->

                    <a
                        href="#"
                        class="admin-menu-card"
                    >

                        <div class="admin-menu-icon">
                            ☕
                        </div>

                        <div class="admin-menu-title">
                            Kelola Menu
                        </div>

                        <div class="admin-menu-description">
                            Tambah, ubah, dan hapus menu cafe.
                        </div>

                    </a>


                    <!-- KELOLA DATA PENGGUNA -->

                    <a
                        href="#"
                        class="admin-menu-card"
                    >

                        <div class="admin-menu-icon">
                            👥
                        </div>

                        <div class="admin-menu-title">
                            Kelola Data Pengguna
                        </div>

                        <div class="admin-menu-description">
                            Mengelola akun Admin dan Kasir.
                        </div>

                    </a>

                </div>

            </div>


            <!-- =================================================
                 QUOTE
            ================================================== -->

            <div class="bottom-quote">

                <div class="bottom-quote-icon">
                    ☕
                </div>

                <div class="bottom-quote-text">

                    <span>
                        Kelola cafe dengan
                    </span>

                    <span>
                        lebih mudah dan teratur 💚
                    </span>

                </div>

            </div>


        </div>

    </main>

</div>

</body>

</html>