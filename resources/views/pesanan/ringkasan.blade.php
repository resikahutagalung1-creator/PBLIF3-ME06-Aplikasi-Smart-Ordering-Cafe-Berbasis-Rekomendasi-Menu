<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smart Cafe - Ringkasan Pesanan</title>

    <link rel="stylesheet" href="{{ asset('css/ringkasan.css') }}">

    {{-- Ukuran ikon pembayaran dibuat lebih kecil --}}
    <style>
        .payment-preview .preview-icon {
            width: 105px;
            height: 105px;
            margin: 0 auto 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-preview .preview-icon svg {
            width: 50px;
            height: 50px;
        }

        @media (max-width: 450px) {
            .payment-preview .preview-icon {
                width: 80px;
                height: 80px;
                margin-bottom: 16px;
            }

            .payment-preview .preview-icon svg {
                width: 40px;
                height: 40px;
            }
        }
    </style>

</head>


<body>


<div class="summary-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

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


            <div class="cart-icon">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="9" cy="20" r="1"></circle>
                    <circle cx="19" cy="20" r="1"></circle>
                    <path d="M3 4h2l2.5 11h10L20 7H6"></path>
                </svg>

                <span>
                    {{ collect($keranjang)->sum('jumlah') }}
                </span>

            </div>

        </div>

    </header>



    {{-- =====================================================
         CONTENT
    ====================================================== --}}

    <main class="summary-container">


        {{-- =================================================
             PAGE HEADING
        ================================================== --}}

        <div class="page-heading">

            <span>
                SMART CAFE
            </span>

            <h2>
                Ringkasan Pesanan
            </h2>

            <p>
                Periksa kembali pesanan kamu sebelum melanjutkan ke pembayaran.
            </p>

        </div>



        {{-- =================================================
             CONTENT GRID
        ================================================== --}}

        <div class="summary-grid">


            {{-- =================================================
                 PESANAN
            ================================================== --}}

            <section class="order-card">


                <div class="card-header">

                    <div>

                        <span class="small-title">
                            PESANAN
                        </span>

                        <h3>
                            Pesanan Anda
                        </h3>

                    </div>


                    @if(count($keranjang) > 0)

                        <button
                            type="button"
                            class="delete-all"
                            id="deleteAll"
                        >
                            Hapus Semua
                        </button>

                    @endif

                </div>



                {{-- =================================================
                     ITEM PESANAN
                ================================================== --}}

                <div
                    class="order-items"
                    id="orderItems"
                >

                    @if(count($keranjang) > 0)

                        @foreach($keranjang as $index => $item)

                            <div
                                class="order-item"
                                data-index="{{ $index }}"
                            >


                                {{-- ===============================
                                     GAMBAR MENU
                                ================================ --}}

                                <div class="item-image">

                                    @if(!empty($item['gambar']))

                                        <img
                                            src="{{ asset('images/menu/' . $item['gambar']) }}"
                                            alt="{{ $item['nama'] }}"
                                        >

                                    @else

                                        <div class="image-placeholder">

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

                                </div>



                                {{-- ===============================
                                     INFORMASI MENU
                                ================================ --}}

                                <div class="item-info">

                                    <h4>
                                        {{ $item['nama'] }}
                                    </h4>

                                    <span class="item-price">
                                        Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                    </span>


                                    {{-- ===========================
                                         JUMLAH
                                    ============================ --}}

                                    <div class="quantity-area">

                                        <button
                                            type="button"
                                            class="quantity-button minus"
                                            data-index="{{ $index }}"
                                        >
                                            −
                                        </button>

                                        <span class="quantity">
                                            {{ $item['jumlah'] }}
                                        </span>

                                        <button
                                            type="button"
                                            class="quantity-button plus"
                                            data-index="{{ $index }}"
                                        >
                                            +
                                        </button>

                                    </div>

                                </div>



                                {{-- ===============================
                                     TOTAL ITEM
                                ================================ --}}

                                <div class="item-total">

                                    Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}

                                </div>

                            </div>

                        @endforeach


                    @else


                        {{-- =================================================
                             KERANJANG KOSONG
                        ================================================== --}}

                        <div class="empty-order">

                            <div class="empty-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >

                                    <circle cx="9" cy="20" r="1"></circle>

                                    <circle cx="19" cy="20" r="1"></circle>

                                    <path d="M3 4h2l2.5 11h10L20 7H6"></path>

                                </svg>

                            </div>


                            <h3>
                                Pesanan masih kosong
                            </h3>

                            <p>
                                Silakan pilih menu terlebih dahulu.
                            </p>


                            <a
                                href="{{ route('menu.index') }}"
                                class="back-menu"
                            >
                                Kembali ke Menu
                            </a>

                        </div>

                    @endif

                </div>



                {{-- =================================================
                     TOTAL PESANAN
                ================================================== --}}

                @if(count($keranjang) > 0)

                    <div class="order-summary">


                        <div class="summary-row">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </strong>

                        </div>


                        <div class="summary-row">

                            <span>
                                Pajak (10%)
                            </span>

                            <strong>
                                Rp {{ number_format($pajak, 0, ',', '.') }}
                            </strong>

                        </div>


                        <div class="summary-divider"></div>


                        <div class="summary-total">

                            <span>
                                Total
                            </span>

                            <strong>
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </strong>

                        </div>

                    </div>

                @endif

            </section>



            {{-- =================================================
                 PANEL PEMBAYARAN
            ================================================== --}}

            @if(count($keranjang) > 0)

                <section class="payment-card">


                    {{-- ===============================
                         HEADER PEMBAYARAN
                    ================================ --}}

                    <div class="payment-header">

                        <span>
                            PESANAN
                        </span>

                        <h3>
                            Siap untuk Membayar?
                        </h3>

                    </div>



                    {{-- ===============================
                         PAYMENT PREVIEW
                    ================================ --}}

                    <div class="payment-preview">


                        {{-- Ikon kartu pembayaran --}}
                        <div class="preview-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2"
                                ></rect>

                                <path d="M3 10h18"></path>

                                <path d="M7 15h3"></path>

                            </svg>

                        </div>


                        <div class="preview-text">

                            <strong>
                                Lanjut ke Pembayaran
                            </strong>

                            <span>
                                Pilih metode pembayaran pada halaman berikutnya.
                            </span>

                        </div>

                    </div>



                    {{-- =================================================
                         TOTAL PEMBAYARAN
                    ================================================== --}}

                    <div class="payment-total">

                        <div>

                            <span>
                                Total Pembayaran
                            </span>

                            <strong>
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </strong>

                        </div>

                    </div>



                    {{-- =================================================
                         BUTTON PEMBAYARAN
                    ================================================== --}}

                    <a
                        href="{{ route('pesanan.pembayaran') }}"
                        class="pay-button"
                    >

                        <span>
                            Lanjut ke Pembayaran
                        </span>

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >

                            <path d="M5 12h14"></path>

                            <path d="M13 6l6 6-6 6"></path>

                        </svg>

                    </a>



                    {{-- =================================================
                         KEMBALI KE MENU
                    ================================================== --}}

                    <a
                        href="{{ route('menu.index') }}"
                        class="continue-shopping"
                    >
                        ← Kembali ke Menu
                    </a>


                </section>

            @endif


        </div>

    </main>

</div>



<script src="{{ asset('js/ringkasan.js') }}"></script>


</body>

</html>