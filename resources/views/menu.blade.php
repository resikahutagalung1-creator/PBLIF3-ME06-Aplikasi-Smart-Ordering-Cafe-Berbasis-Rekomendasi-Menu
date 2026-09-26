<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF TOKEN UNTUK KERANJANG --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smart Cafe - Menu</title>

    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">

</head>


<body>

<div class="menu-page">


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <header class="top-header">

        <div class="logo-area">

            <div class="logo-circle">
                ☕
            </div>

            <div class="logo-text">

                <h1>
                    SMART CAFE
                </h1>

                <span>
                    Smart Ordering Café
                </span>

            </div>

        </div>


        <div class="customer-area">

            <div class="customer-name">

                <span class="hello">
                    Halo,
                </span>

                <strong>
                    {{ session('nama_pelanggan', 'Pelanggan') }}
                </strong>

            </div>


            <div class="table-info">

                Meja {{ session('nomor_meja', '-') }}

            </div>


            {{-- =================================================
                TOMBOL KERANJANG
            ================================================== --}}

            <button
                type="button"
                class="header-cart"
                id="cartButton"
            >

                🛒

                <span id="cartCount">
                    {{ collect(session('keranjang', []))->sum('jumlah') }}
                </span>

            </button>

        </div>

    </header>



    {{-- =========================================================
        CONTENT
    ========================================================== --}}

    <div class="menu-container">


        {{-- =====================================================
            SIDEBAR KATEGORI
        ====================================================== --}}

        <aside class="category-sidebar">


            <div class="sidebar-title">

                <span>
                    SMART CAFE
                </span>

                <h2>
                    Kategori
                </h2>

            </div>



            {{-- =================================================
                SEMUA MENU
            ================================================== --}}

            <a
                href="{{ route('menu.index') }}"
                class="category-item {{ !request('kategori') ? 'active' : '' }}"
                title="Semua Menu"
            >

                <span class="category-icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path d="M3 10.5L12 3l9 7.5"></path>

                        <path d="M5.5 9.5V21h13V9.5"></path>

                        <path d="M9.5 21v-6h5v6"></path>

                    </svg>

                </span>


                <span>
                    Semua Menu
                </span>

            </a>



            {{-- =================================================
                KATEGORI
            ================================================== --}}

            @foreach($kategoris as $kategori)

                <a
                    href="{{ route('menu.index', ['kategori' => $kategori->kategori_id]) }}"
                    class="category-item {{ request('kategori') == $kategori->kategori_id ? 'active' : '' }}"
                    title="{{ $kategori->nama_kategori }}"
                >

                    <span class="category-icon">


                        {{-- =====================================
                            COFFEE
                        ====================================== --}}

                        @if($kategori->nama_kategori == 'Coffee')

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Z"></path>

                                <path d="M17 11h1.5a2.5 2.5 0 0 1 0 5H17"></path>

                                <path d="M7 5c0 1 1 1 1 2"></path>

                                <path d="M11 4c0 1 1 1 1 2"></path>

                            </svg>



                        {{-- =====================================
                            NON COFFEE
                        ====================================== --}}

                        @elseif($kategori->nama_kategori == 'Non Coffee')

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M7 5h10"></path>

                                <path d="M8 5l1 15h6l1-15"></path>

                                <path d="M9 9h6"></path>

                                <path d="M10 3h4"></path>

                            </svg>



                        {{-- =====================================
                            SNACK
                        ====================================== --}}

                        @elseif($kategori->nama_kategori == 'Snack')

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M5 8h14"></path>

                                <path d="M6 8l1.5 11h9L18 8"></path>

                                <path d="M9 5v2"></path>

                                <path d="M12 4v3"></path>

                                <path d="M15 5v2"></path>

                            </svg>



                        {{-- =====================================
                            MAKANAN
                        ====================================== --}}

                        @elseif($kategori->nama_kategori == 'Makanan')

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M4 12h16"></path>

                                <path d="M5 12a7 7 0 0 0 14 0"></path>

                                <path d="M7 16h10"></path>

                                <path d="M12 5v2"></path>

                                <path d="M9 7c.5-1 1.5-1.5 3-1.5S14.5 6 15 7"></path>

                            </svg>



                        {{-- =====================================
                            DESSERT
                        ====================================== --}}

                        @elseif($kategori->nama_kategori == 'Dessert')

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M5 10h14"></path>

                                <path d="M6 10c0 5 2 8 6 8s6-3 6-8"></path>

                                <path d="M8 7c1-2 2-3 4-3s3 1 4 3"></path>

                                <path d="M9 18h6"></path>

                            </svg>



                        {{-- =====================================
                            DEFAULT
                        ====================================== --}}

                        @else

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="8"
                                ></circle>

                                <path d="M12 8v4l3 2"></path>

                            </svg>

                        @endif


                    </span>


                    <span>
                        {{ $kategori->nama_kategori }}
                    </span>

                </a>

            @endforeach


        </aside>



        {{-- =====================================================
            MAIN MENU
        ====================================================== --}}

        <main class="menu-main">


            {{-- =================================================
                HEADING
            ================================================== --}}

            <div class="menu-heading">

                <div>

                    <span class="small-label">
                        SMART CAFE
                    </span>

                    <h2>
                        Mau pesan apa hari ini?
                    </h2>

                    <p>
                        Pilih menu favorit kamu dan mulai memesan.
                    </p>

                </div>

            </div>



            {{-- =================================================
                SEARCH
            ================================================== --}}

            <form
                action="{{ route('menu.index') }}"
                method="GET"
                class="search-form"
            >

                @if(request('kategori'))

                    <input
                        type="hidden"
                        name="kategori"
                        value="{{ request('kategori') }}"
                    >

                @endif


                <div class="search-input-wrapper">

                    <span class="search-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >

                            <circle
                                cx="11"
                                cy="11"
                                r="7"
                            ></circle>

                            <path d="M20 20l-4-4"></path>

                        </svg>

                    </span>


                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari makanan atau minuman..."
                    >

                </div>


                <button type="submit">
                    Cari
                </button>

            </form>



            {{-- =================================================
                MENU HEADER
            ================================================== --}}

            <div class="menu-list-header">

                <div>

                    <h3>
                        Daftar Menu
                    </h3>

                    <p>
                        {{ $menus->count() }} menu tersedia
                    </p>

                </div>

            </div>



            {{-- =================================================
                MENU CARD
            ================================================== --}}

            @if($menus->count() > 0)

                <div class="menu-grid">


                    @foreach($menus as $menu)

                        <div
                            class="menu-card"
                            data-menu-id="{{ $menu->menu_id }}"
                            data-menu-name="{{ $menu->nama_menu }}"
                            data-menu-price="{{ number_format($menu->harga, 0, ',', '.') }}"
                            data-menu-description="{{ $menu->deskripsi ?? 'Menu pilihan Smart Cafe untuk menemani hari kamu.' }}"
                            data-menu-stock="{{ $menu->stok }}"
                            data-menu-category="{{ $menu->kategori->nama_kategori ?? 'Menu' }}"
                            data-menu-image="{{ $menu->gambar ? asset('images/menu/' . $menu->gambar) : '' }}"
                        >


                            <a
                                href="{{ route('menu.show', $menu->menu_id) }}"
                                class="menu-detail-link"
                            >


                                {{-- =================================
                                    FOTO
                                ================================== --}}

                                <div class="menu-photo">


                                    @if($menu->gambar)

                                        <img
                                            src="{{ asset('images/menu/' . $menu->gambar) }}"
                                            alt="{{ $menu->nama_menu }}"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >


                                        <div
                                            class="photo-placeholder"
                                            style="display:none;"
                                        >

                                            <svg
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >

                                                <path d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Z"></path>

                                                <path d="M17 11h1.5a2.5 2.5 0 0 1 0 5H17"></path>

                                            </svg>

                                        </div>


                                    @else

                                        <div class="photo-placeholder">

                                            <svg
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >

                                                <path d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Z"></path>

                                                <path d="M17 11h1.5a2.5 2.5 0 0 1 0 5H17"></path>

                                            </svg>

                                        </div>

                                    @endif


                                    <span class="category-badge">

                                        {{ $menu->kategori->nama_kategori ?? 'Menu' }}

                                    </span>


                                </div>



                                {{-- =================================
                                    CARD CONTENT
                                ================================== --}}

                                <div class="menu-card-content">


                                    <h4>
                                        {{ $menu->nama_menu }}
                                    </h4>


                                    @if($menu->deskripsi)

                                        <p class="menu-description">

                                            {{ $menu->deskripsi }}

                                        </p>

                                    @else

                                        <p class="menu-description">

                                            Menu pilihan Smart Cafe untuk menemani hari kamu.

                                        </p>

                                    @endif



                                    <div class="menu-card-bottom">


                                        <div class="price-area">

                                            <span class="price">

                                                Rp
                                                {{ number_format($menu->harga, 0, ',', '.') }}

                                            </span>


                                            <small>

                                                Stok {{ $menu->stok }}

                                            </small>

                                        </div>



                                        {{-- =================================
                                            TOMBOL PESAN
                                        ================================== --}}

                                        <button
                                            type="button"
                                            class="order-button"
                                            data-menu-id="{{ $menu->menu_id }}"
                                        >

                                            <svg
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >

                                                <circle
                                                    cx="9"
                                                    cy="20"
                                                    r="1"
                                                ></circle>

                                                <circle
                                                    cx="19"
                                                    cy="20"
                                                    r="1"
                                                ></circle>

                                                <path d="M3 4h2l2.5 11h10L20 7H6"></path>

                                            </svg>


                                            <span>
                                                Pesan Sekarang
                                            </span>

                                        </button>


                                    </div>


                                </div>


                            </a>


                        </div>

                    @endforeach


                </div>


            @else


                {{-- =============================================
                    EMPTY MENU
                ============================================== --}}

                <div class="empty-menu">

                    <div class="empty-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >

                            <circle
                                cx="12"
                                cy="12"
                                r="8"
                            ></circle>

                            <path d="M8 12h8"></path>

                        </svg>

                    </div>


                    <h3>
                        Menu tidak ditemukan
                    </h3>


                    <p>
                        Coba gunakan kata pencarian atau kategori lain.
                    </p>

                </div>

            @endif


        </main>

    </div>

</div>



{{-- ============================================================
    MODAL DETAIL MENU
============================================================= --}}

<div
    class="menu-detail-overlay"
    id="menuDetailOverlay"
>


    <div
        class="menu-detail-modal"
        id="menuDetailModal"
    >


        {{-- =================================================
            CLOSE
        ================================================== --}}

        <button
            type="button"
            class="detail-close"
            id="detailClose"
        >
            ×
        </button>



        {{-- =================================================
            FOTO DETAIL
        ================================================== --}}

        <div class="detail-image-area">

            <img
                src=""
                alt=""
                id="detailImage"
            >


            <div
                class="detail-image-placeholder"
                id="detailImagePlaceholder"
            >

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >

                    <path d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Z"></path>

                    <path d="M17 11h1.5a2.5 2.5 0 0 1 0 5H17"></path>

                </svg>

            </div>


            <span
                class="detail-category"
                id="detailCategory"
            >
                Coffee
            </span>

        </div>



        {{-- =================================================
            DETAIL CONTENT
        ================================================== --}}

        <div class="detail-content">


            <div class="detail-heading">

                <div>

                    <h2 id="detailName">
                        Cafe Latte
                    </h2>

                    <p
                        class="detail-price"
                        id="detailPrice"
                    >
                        Rp25.000
                    </p>

                </div>


                <div
                    class="detail-stock"
                    id="detailStock"
                >
                    Stok 10
                </div>

            </div>



            {{-- DESKRIPSI --}}

            <p
                class="detail-description"
                id="detailDescription"
            >
                Espresso dengan susu segar.
            </p>



            {{-- =================================================
                PILIHAN / TAG
            ================================================== --}}

            <div class="detail-section">

                <h4>
                    Pilihan
                </h4>

                <div class="detail-options">

                    <button
                        type="button"
                        class="detail-option active"
                    >
                        Normal
                    </button>

                    <button
                        type="button"
                        class="detail-option"
                    >
                        Less Sugar
                    </button>

                </div>

            </div>



            {{-- =================================================
                JUMLAH
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-row-title">

                    <h4>
                        Jumlah
                    </h4>

                </div>


                <div class="quantity-control">

                    <button
                        type="button"
                        id="quantityMinus"
                    >
                        −
                    </button>


                    <span id="quantityValue">
                        1
                    </span>


                    <button
                        type="button"
                        id="quantityPlus"
                    >
                        +
                    </button>

                </div>

            </div>



            {{-- =================================================
                CATATAN
            ================================================== --}}

            <div class="detail-section">

                <h4>

                    Catatan

                    <span>
                        (opsional)
                    </span>

                </h4>


                <textarea
                    id="detailNote"
                    placeholder="Contoh: less ice, tanpa gula, dll."
                ></textarea>

            </div>



            {{-- =================================================
                BUTTON PESAN
            ================================================== --}}

            <button
                type="button"
                class="detail-order-button"
                id="detailOrderButton"
            >

                <span>
                    Pesan Sekarang
                </span>

                <strong id="detailTotal">
                    Rp25.000
                </strong>

            </button>


        </div>



        {{-- =====================================================
            REKOMENDASI
        ====================================================== --}}

        <div class="recommendation-section">


            <div class="recommendation-title">

                <span>
                    ✨
                </span>

                <h3>
                    Mungkin kamu juga suka
                </h3>

            </div>


            <div class="recommendation-grid">


                @foreach($menus->take(3) as $recommendation)

                    <div
                        class="recommendation-card"
                        data-menu-id="{{ $recommendation->menu_id }}"
                    >


                        <div class="recommendation-image">

                            @if($recommendation->gambar)

                                <img
                                    src="{{ asset('images/menu/' . $recommendation->gambar) }}"
                                    alt="{{ $recommendation->nama_menu }}"
                                >

                            @else

                                <div class="recommendation-placeholder">

                                    ☕

                                </div>

                            @endif

                        </div>


                        <div class="recommendation-info">

                            <h4>
                                {{ $recommendation->nama_menu }}
                            </h4>

                            <span>

                                Rp
                                {{ number_format($recommendation->harga, 0, ',', '.') }}

                            </span>


                            <button
                                type="button"
                                class="recommendation-button"
                                data-menu-id="{{ $recommendation->menu_id }}"
                            >

                                Pesan

                            </button>

                        </div>


                    </div>

                @endforeach


            </div>

        </div>


    </div>

</div>



{{-- ============================================================
    JAVASCRIPT
============================================================= --}}

<script src="{{ asset('js/menu.js') }}"></script>


</body>

</html>