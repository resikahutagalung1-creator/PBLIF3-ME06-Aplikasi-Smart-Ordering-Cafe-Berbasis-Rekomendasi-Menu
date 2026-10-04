<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smart Cafe - Pembayaran</title>

    <link rel="stylesheet" href="{{ asset('css/pembayaran.css') }}">
</head>

<body>

<div class="payment-page">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <header class="payment-header">

        <div class="payment-logo">

            <!-- =================================================
                 LOGO CANGKIR
            ================================================== -->

            <div class="payment-logo-icon">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >

                    {{-- Badan cangkir --}}
                    <path
                        d="M4 9h13v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9Z"
                    ></path>

                    {{-- Pegangan cangkir --}}
                    <path
                        d="M17 11h1.5a2.5 2.5 0 0 1 0 5H17"
                    ></path>

                    {{-- Uap --}}
                    <path
                        d="M8 5c0 1 1 1 1 2"
                    ></path>

                    <path
                        d="M12 4c0 1 1 1 1 2"
                    ></path>

                </svg>

            </div>


            <!-- NAMA CAFE -->

            <div>

                <h1>
                    SMART CAFE
                </h1>

                <span>
                    Smart Ordering Café
                </span>

            </div>

        </div>


        <!-- =================================================
             TOMBOL KEMBALI
        ================================================== -->

        <a
            href="{{ route('pesanan.ringkasan') }}"
            class="back-button">

            <span class="back-arrow">
                ←
            </span>

            <span>
                Kembali
            </span>

        </a>

    </header>


    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <main class="payment-container">


        <!-- =================================================
             TITLE
        ================================================== -->

        <div class="payment-title">

            <span>
                PEMBAYARAN
            </span>

            <h2>
                Selesaikan Pembayaran
            </h2>

            <p>
                Pilih metode pembayaran yang kamu inginkan.
            </p>

        </div>


        <!-- =================================================
             INFORMASI PELANGGAN
        ================================================== -->

        <div class="customer-info-card">


            <div class="customer-info-item">

                <span>
                    Nama Pelanggan
                </span>

                <strong>
                    {{ $namaPelanggan }}
                </strong>

            </div>


            <div class="customer-info-item">

                <span>
                    Nomor Meja
                </span>

                <strong>
                    Meja {{ $nomorMeja }}
                </strong>

            </div>


            <div class="customer-info-item">

                <span>
                    Total Item
                </span>

                <strong>
                    {{ collect($keranjang)->sum('jumlah') }} item
                </strong>

            </div>

        </div>


        <!-- =================================================
             PAYMENT GRID
        ================================================== -->

        <div class="payment-grid">


            <!-- =================================================
                 METODE PEMBAYARAN
            ================================================== -->

            <section class="payment-method-card">


                <!-- HEADING -->

                <div class="section-heading">

                    <span class="section-number">
                        01
                    </span>

                    <div>

                        <h3>
                            Metode Pembayaran
                        </h3>

                        <p>
                            Pilih salah satu metode pembayaran.
                        </p>

                    </div>

                </div>


                <!-- =================================================
                     QRIS OPTION
                ================================================== -->

                <label
                    class="payment-option active"
                    id="qrisOption">

                    <input
                        type="radio"
                        name="payment_method"
                        value="qris"
                        checked>


                    <div class="payment-option-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            <rect
                                x="4"
                                y="4"
                                width="6"
                                height="6">
                            </rect>

                            <rect
                                x="14"
                                y="4"
                                width="6"
                                height="6">
                            </rect>

                            <rect
                                x="4"
                                y="14"
                                width="6"
                                height="6">
                            </rect>

                            <path d="M14 14h3">
                            </path>

                            <path d="M14 18h2">
                            </path>

                            <path d="M18 17h2">
                            </path>

                            <path d="M18 20h2">
                            </path>

                        </svg>

                    </div>


                    <div class="payment-option-text">

                        <strong>
                            QRIS
                        </strong>

                        <span>
                            Bayar menggunakan QRIS
                        </span>

                    </div>


                    <span class="radio-check">
                        ✓
                    </span>

                </label>


                <!-- =================================================
                     TUNAI OPTION
                ================================================== -->

                <label
                    class="payment-option"
                    id="cashOption">

                    <input
                        type="radio"
                        name="payment_method"
                        value="tunai">


                    <div class="payment-option-icon cash-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round">

                            <rect
                                x="3"
                                y="7"
                                width="18"
                                height="11"
                                rx="2">
                            </rect>

                            <circle
                                cx="12"
                                cy="12.5"
                                r="2.5">
                            </circle>

                            <path d="M6 10v5">
                            </path>

                            <path d="M18 10v5">
                            </path>

                        </svg>

                    </div>


                    <div class="payment-option-text">

                        <strong>
                            Tunai
                        </strong>

                        <span>
                            Bayar langsung kepada kasir
                        </span>

                    </div>


                    <span class="radio-check">
                        ✓
                    </span>

                </label>


                <!-- =================================================
                     DETAIL QRIS
                ================================================== -->

                <div
                    class="payment-detail qris-detail"
                    id="qrisDetail">


                    <div class="detail-header">

                        <h4>
                            Scan QRIS
                        </h4>

                        <p>
                            Gunakan aplikasi pembayaran yang mendukung QRIS.
                        </p>

                    </div>


                    <div class="qris-box">

                        <div class="qris-image">

                            @if(file_exists(public_path('images/qris.png')))

                                <img
                                    src="{{ asset('images/qris.png') }}"
                                    alt="QRIS Smart Cafe">

                            @else

                                <div class="qris-placeholder">

                                    <div class="qr-placeholder-icon">

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">

                                            <rect
                                                x="3"
                                                y="3"
                                                width="7"
                                                height="7">
                                            </rect>

                                            <rect
                                                x="14"
                                                y="3"
                                                width="7"
                                                height="7">
                                            </rect>

                                            <rect
                                                x="3"
                                                y="14"
                                                width="7"
                                                height="7">
                                            </rect>

                                            <path d="M14 14h3">
                                            </path>

                                            <path d="M14 18h2">
                                            </path>

                                            <path d="M18 17h3">
                                            </path>

                                            <path d="M18 20h3">
                                            </path>

                                        </svg>

                                    </div>


                                    <strong>
                                        QRIS Smart Cafe
                                    </strong>


                                    <span>
                                        QRIS belum tersedia.
                                        Silakan lakukan pembayaran melalui kasir.
                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>


                    <div class="qris-note">

                        <span class="note-check">
                            ✓
                        </span>

                        <p>
                            Pastikan jumlah pembayaran sesuai dengan total pesanan.
                        </p>

                    </div>

                </div>


                <!-- =================================================
                     DETAIL TUNAI
                ================================================== -->

                <div
                    class="payment-detail cash-detail"
                    id="cashDetail">


                    <div class="cash-information">


                        <div class="cash-icon-large">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linecap="round"
                                stroke-linejoin="round">

                                <rect
                                    x="3"
                                    y="7"
                                    width="18"
                                    height="11"
                                    rx="2">
                                </rect>

                                <circle
                                    cx="12"
                                    cy="12.5"
                                    r="2.5">
                                </circle>

                                <path d="M6 10v5">
                                </path>

                                <path d="M18 10v5">
                                </path>

                            </svg>

                        </div>


                        <div>

                            <h4>
                                Pembayaran Tunai
                            </h4>

                            <p>
                                Silakan lakukan pembayaran langsung kepada kasir.
                            </p>

                        </div>

                    </div>


                    <div class="cash-note">

                        <strong>
                            Informasi
                        </strong>

                        <p>
                            Tunjukkan detail pesanan kamu kepada kasir
                            saat melakukan pembayaran.
                        </p>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 RINGKASAN PEMBAYARAN
            ================================================== -->

            <section class="payment-summary-card">


                <div class="section-heading">

                    <span class="section-number">
                        02
                    </span>

                    <div>

                        <h3>
                            Ringkasan Pembayaran
                        </h3>

                        <p>
                            Periksa kembali pesanan kamu.
                        </p>

                    </div>

                </div>


                <!-- =================================================
                     DAFTAR MENU
                ================================================== -->

                <div class="summary-menu-list">

                    @foreach($keranjang as $item)

                        <div class="summary-menu-item">


                            <div class="summary-menu-image">

                                @if(!empty($item['gambar']))

                                    <img
                                        src="{{ asset('images/menu/' . $item['gambar']) }}"
                                        alt="{{ $item['nama'] }}">

                                @else

                                    <span class="menu-placeholder-icon">

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">

                                            <path d="M4.5 9h12.5v4.5a5 5 0 0 1-5 5h-2.5a5 5 0 0 1-5-5V9Z">
                                            </path>

                                            <path d="M17 10.5h1.5a2.5 2.5 0 0 1 0 5H17">
                                            </path>

                                        </svg>

                                    </span>

                                @endif

                            </div>


                            <div class="summary-menu-info">

                                <strong>
                                    {{ $item['nama'] }}
                                </strong>

                                <span>
                                    {{ $item['jumlah'] }}
                                    ×
                                    Rp{{ number_format($item['harga'], 0, ',', '.') }}
                                </span>

                            </div>


                            <strong class="summary-menu-price">

                                Rp{{ number_format(
                                    $item['harga'] * $item['jumlah'],
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                        </div>

                    @endforeach

                </div>


                <!-- GARIS -->

                <div class="summary-divider"></div>


                <!-- SUBTOTAL -->

                <div class="summary-row">

                    <span>
                        Subtotal
                    </span>

                    <strong>
                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                    </strong>

                </div>


                <!-- PAJAK -->

                <div class="summary-row">

                    <span>
                        Pajak (10%)
                    </span>

                    <strong>
                        Rp{{ number_format($pajak, 0, ',', '.') }}
                    </strong>

                </div>


                <!-- TOTAL -->

                <div class="summary-total">

                    <span>
                        Total Pembayaran
                    </span>

                    <strong>
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </strong>

                </div>


                <!-- =================================================
                     BUTTON BAYAR
                ================================================== -->

                <button
                    type="button"
                    class="pay-button"
                    id="payButton">

                    <span>
                        Bayar Sekarang
                    </span>

                    <strong>
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </strong>

                </button>


                <!-- CATATAN KEAMANAN -->

                <p class="secure-note">

                    <span>
                        🔒
                    </span>

                    Pembayaran aman dan tercatat di sistem Smart Cafe.

                </p>

            </section>

        </div>

    </main>


    <!-- =====================================================
         MODAL KONFIRMASI
    ====================================================== -->

    <div
        class="payment-modal-overlay"
        id="paymentModal">


        <div class="payment-modal">


            <div class="modal-icon">

                <span>
                    ✓
                </span>

            </div>


            <h3>
                Konfirmasi Pembayaran
            </h3>


            <p id="modalMessage">
                Apakah kamu yakin ingin melanjutkan pembayaran?
            </p>


            <div class="modal-total">

                <span>
                    Total
                </span>

                <strong>
                    Rp{{ number_format($total, 0, ',', '.') }}
                </strong>

            </div>


            <div class="modal-buttons">


                <button
                    type="button"
                    class="modal-cancel"
                    id="modalCancel">

                    Kembali

                </button>


                <button
                    type="button"
                    class="modal-confirm"
                    id="modalConfirm">

                    Ya, Bayar

                </button>

            </div>

        </div>

    </div>

</div>


<!-- JAVASCRIPT -->

<script src="{{ asset('js/pembayaran.js') }}"></script>

</body>

</html>