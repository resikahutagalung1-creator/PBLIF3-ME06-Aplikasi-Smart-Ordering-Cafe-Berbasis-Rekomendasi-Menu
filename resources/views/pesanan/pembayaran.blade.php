<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        Smart Cafe - Pembayaran
    </title>

    <link
        rel="stylesheet"
        href="{{ asset('css/pembayaran.css') }}"
    >

</head>


<body>

<div class="payment-page">


    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <header class="payment-header">

        <div class="payment-logo">

            <div class="payment-logo-icon">
                ☕
            </div>

            <div>

                <h1>
                    SMART CAFE
                </h1>

                <span>
                    Smart Ordering Café
                </span>

            </div>

        </div>


        <a
            href="{{ route('pesanan.ringkasan') }}"
            class="back-button"
        >

            ←

            <span>
                Kembali
            </span>

        </a>

    </header>



    {{-- =====================================================
        MAIN
    ====================================================== --}}

    <main class="payment-container">


        {{-- =================================================
            TITLE
        ================================================== --}}

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



        {{-- =================================================
            CUSTOMER INFO
        ================================================== --}}

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



        {{-- =================================================
            PAYMENT GRID
        ================================================== --}}

        <div class="payment-grid">


            {{-- =============================================
                METODE PEMBAYARAN
            ============================================== --}}

            <section class="payment-method-card">


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



                {{-- =========================================
                    QRIS
                ========================================== --}}

                <label
                    class="payment-option active"
                    id="qrisOption"
                >

                    <input
                        type="radio"
                        name="payment_method"
                        value="qris"
                        checked
                    >


                    <div class="payment-option-icon">
                        QR
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



                {{-- =========================================
                    TUNAI
                ========================================== --}}

                <label
                    class="payment-option"
                    id="cashOption"
                >

                    <input
                        type="radio"
                        name="payment_method"
                        value="tunai"
                    >


                    <div class="payment-option-icon cash-icon">
                        Rp
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



                {{-- =========================================
                    QRIS DETAIL
                ========================================== --}}

                <div
                    class="payment-detail qris-detail"
                    id="qrisDetail"
                >

                    <div class="detail-header">

                        <div>

                            <h4>
                                Scan QRIS
                            </h4>

                            <p>
                                Gunakan aplikasi pembayaran
                                yang mendukung QRIS.
                            </p>

                        </div>

                    </div>



                    <div class="qris-box">

                        <div class="qris-image">

                            {{-- =================================================
                                JIKA QRIS SUDAH ADA
                            ================================================== --}}

                            @if(file_exists(public_path('images/qris.png')))

                                <img
                                    src="{{ asset('images/qris.png') }}"
                                    alt="QRIS Smart Cafe"
                                >

                            {{-- =================================================
                                JIKA QRIS BELUM ADA
                            ================================================== --}}

                            @else

                                <div class="qris-placeholder">

                                    <div class="qr-placeholder-icon">
                                        QR
                                    </div>

                                    <strong>
                                        QRIS Smart Cafe
                                    </strong>

                                    <span>
                                        QRIS belum tersedia.
                                        Silakan lakukan pembayaran
                                        melalui kasir.
                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>



                    <div class="qris-note">

                        <span>
                            ✓
                        </span>

                        <p>
                            Pastikan jumlah pembayaran
                            sesuai dengan total pesanan.
                        </p>

                    </div>

                </div>



                {{-- =========================================
                    TUNAI DETAIL
                ========================================== --}}

                <div
                    class="payment-detail cash-detail"
                    id="cashDetail"
                >

                    <div class="cash-information">

                        <div class="cash-icon-large">
                            Rp
                        </div>

                        <div>

                            <h4>
                                Pembayaran Tunai
                            </h4>

                            <p>
                                Silakan lakukan pembayaran
                                langsung kepada kasir.
                            </p>

                        </div>

                    </div>


                    <div class="cash-note">

                        <strong>
                            Informasi
                        </strong>

                        <p>
                            Tunjukkan detail pesanan kamu
                            kepada kasir saat melakukan
                            pembayaran.
                        </p>

                    </div>

                </div>


            </section>



            {{-- =============================================
                RINGKASAN
            ============================================== --}}

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



                {{-- =========================================
                    LIST MENU
                ========================================== --}}

                <div class="summary-menu-list">

                    @foreach($keranjang as $item)

                        <div class="summary-menu-item">


                            <div class="summary-menu-image">

                                @if(!empty($item['gambar']))

                                    <img
                                        src="{{ asset('images/menu/' . $item['gambar']) }}"
                                        alt="{{ $item['nama'] }}"
                                    >

                                @else

                                    <span>
                                        ☕
                                    </span>

                                @endif

                            </div>


                            <div class="summary-menu-info">

                                <strong>
                                    {{ $item['nama'] }}
                                </strong>

                                <span>
                                    {{ $item['jumlah'] }} ×
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



                {{-- =========================================
                    TOTAL
                ========================================== --}}

                <div class="summary-divider"></div>


                <div class="summary-row">

                    <span>
                        Subtotal
                    </span>

                    <strong>
                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Pajak (10%)
                    </span>

                    <strong>
                        Rp{{ number_format($pajak, 0, ',', '.') }}
                    </strong>

                </div>


                <div class="summary-total">

                    <span>
                        Total Pembayaran
                    </span>

                    <strong>
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </strong>

                </div>



                {{-- =========================================
                    BUTTON
                ========================================== --}}

                <button
                    type="button"
                    class="pay-button"
                    id="payButton"
                >

                    <span>
                        Bayar Sekarang
                    </span>

                    <strong>
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </strong>

                </button>


                <p class="secure-note">

                    🔒 Pembayaran aman dan tercatat
                    di sistem Smart Cafe.

                </p>

            </section>

        </div>

    </main>



    {{-- =====================================================
        MODAL KONFIRMASI
    ====================================================== --}}

    <div
        class="payment-modal-overlay"
        id="paymentModal"
    >

        <div class="payment-modal">


            <div class="modal-icon">
                ✓
            </div>


            <h3>
                Konfirmasi Pembayaran
            </h3>


            <p id="modalMessage">
                Apakah kamu yakin ingin melanjutkan
                pembayaran?
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
                    id="modalCancel"
                >
                    Kembali
                </button>


                <button
                    type="button"
                    class="modal-confirm"
                    id="modalConfirm"
                >
                    Ya, Bayar
                </button>

            </div>

        </div>

    </div>


</div>


<script src="{{ asset('js/pembayaran.js') }}"></script>

</body>

</html>