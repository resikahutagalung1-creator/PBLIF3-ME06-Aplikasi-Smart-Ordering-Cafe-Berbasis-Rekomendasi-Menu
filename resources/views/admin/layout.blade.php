
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Smart Cafe')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>

<body>

<div class="admin-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <div class="logo-icon">☕</div>

            <div class="logo-text">
                <div class="logo-title">SMART CAFE</div>
                <div class="logo-subtitle">Smart Ordering Cafe</div>
            </div>
        </div>

        <ul class="sidebar-menu">

            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">⌂</span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.menu') }}"
                   class="{{ request()->routeIs('admin.menu*') ? 'active' : '' }}">
                    <span class="menu-icon">▤</span>
                    <span class="menu-text">Kelola Menu</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <span class="menu-icon">♙</span>
                    <span class="menu-text">Kelola Data Pengguna</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.meja') }}"
                   class="{{ request()->routeIs('admin.meja*') ? 'active' : '' }}">
                    <span class="menu-icon">▦</span>
                    <span class="menu-text">Kelola Meja</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-bottom">

            <div class="sidebar-coffee">☕</div>
            <div>Admin</div>
            <div>Smart Cafe</div>
            <div class="sidebar-bottom-line"></div>

        </div>

    </aside>

    <!-- MAIN -->
    <main class="main">

        <div class="top-bar">
            <div class="staff">
                <div class="staff-icon">👤</div>
                <span>Admin</span>

                <a href="/admin/logout" class="admin-top-logout">
                    Logout
                </a>
            </div>
        </div>

        <!-- KONTEN HALAMAN -->
        <div class="content">
            @yield('content')
        </div>

    </main>

</div>

@stack('scripts')

</body>
</html>