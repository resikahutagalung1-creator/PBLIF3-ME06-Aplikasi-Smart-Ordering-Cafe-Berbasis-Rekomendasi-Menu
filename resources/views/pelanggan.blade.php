
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Cafe - Pelanggan</title>

    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <main class="customer-page">

        <!-- HEADER -->
        <header class="customer-header">
            <a href="{{ route('welcome') }}" class="brand">
                <span class="brand-name">SMART CAFE</span>
                <span class="brand-tagline">Good Food Good Mood</span>
            </a>

            <a href="{{ route('welcome') }}" class="home-link">
                <i class="fa-solid fa-house"></i>
                <span>Beranda</span>
            </a>
        </header>


        <!-- HERO -->
        <section class="welcome-section">

            <div class="welcome-content">

                <h1>
                    Selamat Datang<br>
                    di Smart Cafe!
                </h1>

                <p>
                    Nikmati pengalaman memesan makanan dan minuman
                    favorit Anda dengan mudah dan nyaman.
                </p>

                <div class="welcome-line"></div>
            </div>

            <div class="welcome-photo">
                <div class="photo-overlay"></div>
                <div class="photo-caption">
                    <span>SMART CAFE</span>
                    <p>Good Food Good Mood</p>
                </div>
            </div>

        </section>


        <!-- FORM PELANGGAN -->
        <section class="customer-form-section">

            <div class="customer-card">

                <div class="form-icon">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="form-content">

                    <div class="form-heading">
                        <h2>Mulai Pengalaman Anda</h2>
                        <p>
                            Isi nama dan pilih meja untuk memulai pemesanan.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="success-message">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form
                        action="{{ route('pelanggan.mulai') }}"
                        method="POST"
                        id="customerForm"
                    >
                        @csrf

                        <!-- NAMA PELANGGAN -->
                        <div class="form-group">

                            <label for="nama">
                                Nama Anda
                            </label>

                            <div class="input-wrapper">
                                <i class="fa-solid fa-user input-icon"></i>

                                <input
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    placeholder="Contoh: Budi Santoso"
                                    value="{{ old('nama') }}"
                                    maxlength="100"
                                    autocomplete="name"
                                    required
                                >
                            </div>

                            @error('nama')
                                <small class="error-message">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        <!-- NOMOR MEJA -->
                        <div class="form-group">

                            <label for="nomor_meja">
                                Pilih Meja
                            </label>

                            <p class="field-description">
                                Silakan pilih nomor meja Anda.
                            </p>

                            <div class="input-wrapper select-wrapper">
                                <i class="fa-solid fa-chair input-icon"></i>

                                <select
                                    id="nomor_meja"
                                    name="nomor_meja"
                                    required
                                >
                                    <option value="">
                                        Pilih Nomor Meja
                                    </option>

                                    @foreach(range(1, 25) as $nomor)
                                        @php
                                            $meja = 'A' . str_pad($nomor, 2, '0', STR_PAD_LEFT);
                                        @endphp

                                        <option
                                            value="{{ $meja }}"
                                            {{ old('nomor_meja') == $meja ? 'selected' : '' }}
                                        >
                                            Meja {{ $meja }}
                                        </option>
                                    @endforeach

                                </select>

                                <i class="fa-solid fa-chevron-down select-arrow"></i>
                            </div>

                            @error('nomor_meja')
                                <small class="error-message">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        <!-- TOMBOL MULAI MEMESAN -->
                        <button
                            type="submit"
                            class="order-button"
                            id="orderButton"
                        >
                            <span>Mulai Memesan</span>
                            <i class="fa-solid fa-arrow-right button-arrow"></i>
                        </button>

                    </form>

                </div>

            </div>

        </section>


        <!-- FOOTER -->
        <footer class="customer-footer">
            <span></span>
            <p>Terima kasih telah berkunjung di Smart Cafe</p>
            <span></span>
        </footer>

    </main>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('js/pelanggan.js') }}"></script>

</body>
</html>