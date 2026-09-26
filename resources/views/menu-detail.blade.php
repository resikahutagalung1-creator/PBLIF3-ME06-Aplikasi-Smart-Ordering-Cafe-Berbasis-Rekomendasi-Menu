<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    
<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $menu->nama_menu }} - Smart Cafe
    </title>

    <link
        rel="stylesheet"
        href="{{ asset('css/menu-detail.css') }}"
    >

</head>


<body>


<div class="detail-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <header class="top-header">


        <a
            href="{{ route('menu.index') }}"
            class="logo-area"
        >

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

        </a>



        <div class="customer-area">


            <div class="customer-name">

                <span>
                    Halo,
                </span>

                <strong>
                    {{ session('nama_pelanggan', 'Pelanggan') }}
                </strong>

            </div>


            <div class="table-info">

                Meja {{ session('nomor_meja', '-') }}

            </div>


            <button
                type="button"
                class="header-cart"
                id="cartButton"
            >

                🛒

                <span id="cartCount">
                    0
                </span>

            </button>


        </div>


    </header>



    {{-- =====================================================
         BACK BUTTON
    ====================================================== --}}

    <div class="back-container">

        <a
            href="{{ route('menu.index') }}"
            class="back-button"
        >

            <span>
                ←
            </span>

            Kembali ke Menu

        </a>

    </div>



    {{-- =====================================================
         DETAIL CONTAINER
    ====================================================== --}}

    <main class="detail-container">


        {{-- =================================================
             DETAIL PRODUK
        ================================================== --}}

        <section class="detail-card">


            {{-- FOTO --}}

            <div class="detail-photo">


                @if($menu->gambar)

                    <img
                        src="{{ asset('images/menu/' . $menu->gambar) }}"
                        alt="{{ $menu->nama_menu }}"
                        onerror="this.style.display='none'; document.getElementById('detailPlaceholder').style.display='flex';"
                    >


                    <div
                        id="detailPlaceholder"
                        class="detail-placeholder"
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

                            <path d="M7 5c0 1 1 1 1 2"></path>

                            <path d="M11 4c0 1 1 1 1 2"></path>

                        </svg>

                    </div>


                @else

                    <div class="detail-placeholder">

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

                            <path d="M7 5c0 1 1 1 1 2"></path>

                            <path d="M11 4c0 1 1 1 1 2"></path>

                        </svg>

                    </div>

                @endif


            </div>



            {{-- INFORMASI MENU --}}

            <div class="detail-content">


                {{-- KATEGORI --}}

                <span class="detail-category">

                    {{ $menu->kategori->nama_kategori ?? 'Menu' }}

                </span>



                {{-- NAMA --}}

                <h2>

                    {{ $menu->nama_menu }}

                </h2>



                {{-- HARGA --}}

                <div class="detail-price">

                    Rp {{ number_format($menu->harga, 0, ',', '.') }}

                </div>



                {{-- DESKRIPSI --}}

                <p class="detail-description">

                    @if($menu->deskripsi)

                        {{ $menu->deskripsi }}

                    @else

                        Nikmati {{ $menu->nama_menu }}
                        dengan cita rasa khas Smart Cafe.

                    @endif

                </p>



                {{-- RASA --}}

                <div class="option-section">

                    <h4>
                        Rasa
                    </h4>


                    <div class="taste-options">

                        <button
                            type="button"
                            class="taste-option active"
                        >
                            Manis
                        </button>


                        <button
                            type="button"
                            class="taste-option"
                        >
                            Lembut
                        </button>

                    </div>

                </div>



                {{-- JUMLAH --}}

                <div class="option-section">

                    <h4>
                        Jumlah
                    </h4>


                    <div class="quantity-control">

                        <button
                            type="button"
                            id="minusButton"
                        >
                            −
                        </button>


                        <span id="quantity">
                            1
                        </span>


                        <button
                            type="button"
                            id="plusButton"
                        >
                            +
                        </button>

                    </div>

                </div>



                {{-- CATATAN --}}

                <div class="option-section">

                    <h4>
                        Catatan
                        <span>
                            (opsional)
                        </span>
                    </h4>


                    <textarea
                        id="catatan"
                        placeholder="Contoh: less sugar, tanpa es, dll..."
                    ></textarea>

                </div>



                {{-- PESAN --}}

                <button
                    type="button"
                    class="detail-order-button"
                    id="detailOrderButton"
                    data-menu-id="{{ $menu->menu_id }}"
                    data-menu-name="{{ $menu->nama_menu }}"
                >

                    <span>
                        Pesan Sekarang
                    </span>

                    <span>
                        →
                    </span>

                </button>


            </div>


        </section>



        {{-- =================================================
             REKOMENDASI
        ================================================== --}}

        @if($rekomendasi->count() > 0)


            <section class="recommendation-section">


                <div class="recommendation-heading">

                    <div>

                        <span>
                            PILIHAN LAIN
                        </span>

                        <h3>
                            Mungkin Anda juga suka
                        </h3>

                    </div>


                </div>



                <div class="recommendation-grid">


                    @foreach($rekomendasi as $item)


                        <a
                            href="{{ route('menu.show', $item->menu_id) }}"
                            class="recommendation-card"
                        >


                            <div class="recommendation-photo">


                                @if($item->gambar)

                                    <img
                                        src="{{ asset('images/menu/' . $item->gambar) }}"
                                        alt="{{ $item->nama_menu }}"
                                    >

                                @else

                                    <div class="recommendation-placeholder">

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >

                                            <path d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Z"></path>

                                            <path d="M17 11h1.5a2.5 2.5 0 0 1 0 5H17"></path>

                                        </svg>

                                    </div>

                                @endif


                            </div>



                            <div class="recommendation-content">


                                <h4>

                                    {{ $item->nama_menu }}

                                </h4>


                                <span>

                                    Rp {{ number_format($item->harga, 0, ',', '.') }}

                                </span>


                                <small>

                                    Lihat Detail →

                                </small>


                            </div>


                        </a>


                    @endforeach


                </div>


            </section>


        @endif


    </main>


</div>



<script src="{{ asset('js/menu-detail.js') }}"></script>


</body>

</html>