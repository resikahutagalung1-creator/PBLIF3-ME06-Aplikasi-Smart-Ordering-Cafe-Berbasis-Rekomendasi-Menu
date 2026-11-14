
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $menu->nama_menu }} - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/menu-detail.css') }}">
</head>

<body>

<div class="detail-page">

    {{-- HEADER --}}
    <header class="top-header">

        <a href="{{ route('menu.index') }}" class="logo-area">

            <div class="logo-circle">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M4 8h13v6a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V8Z"/>
                    <path d="M17 10h1.5a2.5 2.5 0 0 1 0 5H17"/>
                    <path d="M8 4c0 1 1 1 1 2"/>
                    <path d="M12 3c0 1 1 1 1 2"/>

                </svg>
            </div>

            <div class="logo-text">
                <h1>SMART CAFE</h1>
                <span>Smart Ordering Café</span>
            </div>

        </a>


        {{-- INFORMASI PELANGGAN --}}
        <div class="customer-area">

            <div class="customer-name">
                <span>Halo,</span>

                <strong>
                    {{ session('nama_pelanggan', 'Pelanggan') }}
                </strong>
            </div>


            <div class="table-info">
                Meja {{ session('nomor_meja', '-') }}
            </div>


            {{-- IKON KERANJANG --}}
            <button
                type="button"
                class="header-cart"
                id="cartButton"
                aria-label="Lihat keranjang">

                <svg
                    viewBox="0 0 24 24"
                    width="23"
                    height="23"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round">

                    <circle cx="9" cy="20" r="1"/>
                    <circle cx="18" cy="20" r="1"/>

                    <path d="M2 3h2l2.5 12.5a2 2 0 0 0 2 1.5h9.8a2 2 0 0 0 2-1.6L22 8H5"/>

                    <path d="M8 11h11"/>
                    <path d="M10 8v7"/>
                    <path d="M15 8v7"/>

                </svg>

                <span id="cartCount">
                    {{ collect(session('keranjang', []))->sum('jumlah') }}
                </span>

            </button>

        </div>

    </header>


    {{-- TOMBOL KEMBALI --}}
    <div class="back-container">

        <a href="{{ route('menu.index') }}" class="back-button">

            <svg
                viewBox="0 0 24 24"
                width="18"
                height="18"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">

                <path d="M19 12H5"/>
                <path d="m12 19-7-7 7-7"/>

            </svg>

            Kembali ke Menu

        </a>

    </div>


    {{-- DETAIL MENU --}}
    <main class="detail-container">

        <section class="detail-card">


            {{-- FOTO MENU --}}
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
                        style="display:none;">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            <path d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Z"/>
                            <path d="M17 11h1.5a2.5 2.5 0 0 1 0 5H17"/>
                            <path d="M7 5c0 1 1 1 1 2"/>
                            <path d="M11 4c0 1 1 1 1 2"/>

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
                            stroke-linejoin="round">

                            <path d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Z"/>
                            <path d="M17 11h1.5a2.5 2.5 0 0 1 0 5H17"/>
                            <path d="M7 5c0 1 1 1 1 2"/>
                            <path d="M11 4c0 1 1 1 1 2"/>

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


                {{-- NAMA MENU --}}
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


                {{-- PILIHAN RASA --}}
                <div class="option-section">

                    <h4>Rasa</h4>

                    <div class="taste-options">

                        <button
                            type="button"
                            class="taste-option active">

                            Manis

                        </button>

                        <button
                            type="button"
                            class="taste-option">

                            Lembut

                        </button>

                    </div>

                </div>


                {{-- JUMLAH PESANAN --}}
                <div class="option-section">

                    <h4>Jumlah</h4>

                    <div class="quantity-control">

                        <button
                            type="button"
                            id="minusButton"
                            aria-label="Kurangi jumlah">

                            −

                        </button>

                        <span id="quantity">1</span>

                        <button
                            type="button"
                            id="plusButton"
                            aria-label="Tambah jumlah">

                            +

                        </button>

                    </div>

                </div>


                {{-- CATATAN --}}
                <div class="option-section">

                    <h4>
                        Catatan
                        <span>(opsional)</span>
                    </h4>

                    <textarea
                        id="catatan"
                        placeholder="Contoh: less sugar, tanpa es, dll..."
                    ></textarea>

                </div>


                {{-- TOMBOL PESAN --}}
                <button
                    type="button"
                    class="detail-order-button"
                    id="detailOrderButton"
                    data-menu-id="{{ $menu->menu_id }}"
                    data-menu-name="{{ $menu->nama_menu }}">

                    <span>
                        Pesan Sekarang
                    </span>

                    <svg
                        viewBox="0 0 24 24"
                        width="19"
                        height="19"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>

                    </svg>

                </button>

            </div>

        </section>

    </main>

</div>


<script src="{{ asset('js/menu-detail.js') }}"></script>

</body>
</html>