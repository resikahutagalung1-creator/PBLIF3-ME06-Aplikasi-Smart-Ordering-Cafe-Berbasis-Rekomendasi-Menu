
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Status Pesanan - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/rincian.css') }}">
</head>

<body>

<div class="page-container">

    <!-- HEADER -->
    <header class="header">
        <div class="brand">
            <h1>SMART CAFE</h1>
            <p>Good Food, Good Mood</p>
        </div>
    </header>

    <!-- STATUS UTAMA -->
    <section class="success-card">

        <div class="success-icon">✓</div>

        <h2>Status Pesanan Anda</h2>

        <p id="orderStatusMessage">
            @if ($pesanan->status == 'Menunggu')
                Pesanan sedang menunggu konfirmasi kasir.
            @elseif ($pesanan->status == 'Diproses')
                Pesanan telah diterima dan sedang disiapkan.
            @elseif ($pesanan->status == 'Hampir Siap')
                Pesanan hampir selesai disiapkan.
            @elseif ($pesanan->status == 'Siap Disajikan')
                Pesanan siap disajikan kepada Anda.
            @elseif ($pesanan->status == 'Selesai')
                Pesanan telah selesai. Silakan menikmati pesanan Anda.
            @elseif ($pesanan->status == 'Dibatalkan')
                Pesanan Anda telah dibatalkan.
            @endif
        </p>

    </section>

    <!-- PERJALANAN PESANAN -->
    <section
        class="card order-progress-design"
        id="orderTracking"
        data-pesanan-id="{{ $pesanan->pesanan_id }}"
        data-status="{{ $pesanan->status }}"
    >

        <h3>Perjalanan Pesanan</h3>

        <p class="progress-description">
            Pantau perkembangan pesanan Anda secara langsung.
        </p>

        <!-- TIMELINE 5 TAHAP -->
        <div class="order-timeline" id="customerTimeline">

            <div class="timeline-item" data-step="1">
                <div class="timeline-circle">1</div>
                <strong>Pesanan<br>Diterima</strong>
            </div>

            <div class="timeline-item" data-step="2">
                <div class="timeline-circle">2</div>
                <strong>Sedang<br>Dimasak</strong>
            </div>

            <div class="timeline-item" data-step="3">
                <div class="timeline-circle">3</div>
                <strong>Hampir<br>Siap</strong>
            </div>

            <div class="timeline-item" data-step="4">
                <div class="timeline-circle">4</div>
                <strong>Siap<br>Disajikan</strong>
            </div>

            <div class="timeline-item" data-step="5">
                <div class="timeline-circle">5</div>
                <strong>Selesai</strong>
            </div>

        </div>

        <!-- ILUSTRASI MANUSIA MEMASAK -->
        <div class="order-animation" id="cookingScene">

            <img
                src="{{ asset('images/order-progress.gif') }}"
                alt="Ilustrasi manusia sedang melayani pesanan Smart Cafe"
            >

        </div>

        <div class="order-animation-caption" id="cookingCaption">
            Koki sedang menyiapkan pesanan Anda.
        </div>

        <!-- PESANAN DIBATALKAN -->
        <div
            id="cancelledMessage"
            class="cancelled-message"
            hidden
        >
            Pesanan Anda telah dibatalkan.
        </div>

        <!-- PESANAN SELESAI -->
        <div
            id="finishedMessage"
            class="finished-message"
            hidden
        >
            ✓ Pesanan telah selesai. Selamat menikmati!
        </div>

        <!-- INFORMASI PESANAN -->
        <div class="section-heading">

            <h3>Informasi Pesanan</h3>

            <span class="order-status" id="orderStatus">
                {{ $pesanan->status }}
            </span>

        </div>

        <div class="info-list">

            <div class="info-row">
                <span>Nomor Pesanan</span>
                <strong>{{ $pesanan->nomor_pesanan }}</strong>
            </div>

            <div class="info-row">
                <span>Nama Pelanggan</span>
                <strong>
                    {{ $pesanan->pelanggan->nama ?? '-' }}
                </strong>
            </div>

            <div class="info-row">
                <span>Nomor Meja</span>
                <strong>
                    {{ $pesanan->pelanggan->nomor_meja ?? '-' }}
                </strong>
            </div>

            <div class="info-row">
                <span>Tanggal Pesanan</span>

                <strong>
                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d/m/Y H:i') }}
                </strong>
            </div>

        </div>

    </section>

    <!-- RINGKASAN PESANAN -->
    <section class="card">

        <h3>Menu yang Dipesan</h3>

        <div class="menu-list">

            @foreach ($pesanan->detailPesanan as $detail)

                <div class="menu-item">

                    <div class="menu-information">

                        <h4>
                            {{ $detail->menu->nama_menu ?? 'Menu tidak tersedia' }}
                        </h4>

                        <p>
                            {{ $detail->jumlah }} ×
                            Rp {{ number_format($detail->harga, 0, ',', '.') }}
                        </p>

                    </div>

                    <strong class="menu-subtotal">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </strong>

                </div>

            @endforeach

        </div>

        <div class="payment-row total-row">

            <span>Total Pembayaran</span>

            <strong>
                Rp {{ number_format($pesanan->total, 0, ',', '.') }}
            </strong>

        </div>

    </section>

    <!-- INFORMASI PEMBAYARAN -->
    <section class="card">

        <h3>Informasi Pembayaran</h3>

        <div class="info-list">

            <div class="info-row">

                <span>Metode Pembayaran</span>

                <strong>
                    {{ $pesanan->pembayaran->metode ?? '-' }}
                </strong>

            </div>

            <div class="info-row">

                <span>Status Pembayaran</span>

                <strong class="payment-status">
                    {{ $pesanan->pembayaran->status ?? 'Menunggu' }}
                </strong>

            </div>

        </div>

    </section>

    <!-- KEMBALI KE MENU -->
    <a href="{{ route('menu.index') }}" class="back-button">
        Kembali ke Menu
    </a>

    <!-- FOOTER -->
    <footer class="footer">

        <p>Terima kasih telah berkunjung ke Smart Cafe.</p>

        <span>Good Food, Good Mood</span>

    </footer>

</div>

<script src="{{ asset('js/rincian.js') }}"></script>

</body>
</html>