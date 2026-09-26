<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Cafe - Pelanggan</title>

    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">
</head>

<body>

    <main class="customer-page">

        <div class="customer-card">

            <div class="customer-icon">
                ☕
            </div>

            <h1>Selamat Datang</h1>

            <p class="customer-subtitle">
                Silakan isi data Anda sebelum mulai memesan.
            </p>

            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('pelanggan.mulai') }}" method="POST" id="customerForm">

                @csrf

                <!-- NAMA -->
                <div class="form-group">

                    <label for="nama">
                        Nama Anda
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        placeholder="Masukkan nama Anda"
                        value="{{ old('nama') }}"
                        maxlength="100"
                        autocomplete="name"
                        required
                    >

                    @error('nama')
                        <small class="error-message">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                <!-- NOMOR MEJA -->
                <div class="form-group">

                    <label for="nomor_meja">
                        Nomor Meja
                    </label>

                    <select
                        id="nomor_meja"
                        name="nomor_meja"
                        required
                    >
                        <option value="">Pilih Nomor Meja</option>

                        <option value="A01" {{ old('nomor_meja') == 'A01' ? 'selected' : '' }}>A01</option>
                        <option value="A02" {{ old('nomor_meja') == 'A02' ? 'selected' : '' }}>A02</option>
                        <option value="A03" {{ old('nomor_meja') == 'A03' ? 'selected' : '' }}>A03</option>
                        <option value="A04" {{ old('nomor_meja') == 'A04' ? 'selected' : '' }}>A04</option>
                        <option value="A05" {{ old('nomor_meja') == 'A05' ? 'selected' : '' }}>A05</option>
                        <option value="A06" {{ old('nomor_meja') == 'A06' ? 'selected' : '' }}>A06</option>
                        <option value="A07" {{ old('nomor_meja') == 'A07' ? 'selected' : '' }}>A07</option>
                        <option value="A08" {{ old('nomor_meja') == 'A08' ? 'selected' : '' }}>A08</option>
                        <option value="A09" {{ old('nomor_meja') == 'A09' ? 'selected' : '' }}>A09</option>
                        <option value="A10" {{ old('nomor_meja') == 'A10' ? 'selected' : '' }}>A10</option>

                        <option value="A11" {{ old('nomor_meja') == 'A11' ? 'selected' : '' }}>A11</option>
                        <option value="A12" {{ old('nomor_meja') == 'A12' ? 'selected' : '' }}>A12</option>
                        <option value="A13" {{ old('nomor_meja') == 'A13' ? 'selected' : '' }}>A13</option>
                        <option value="A14" {{ old('nomor_meja') == 'A14' ? 'selected' : '' }}>A14</option>
                        <option value="A15" {{ old('nomor_meja') == 'A15' ? 'selected' : '' }}>A15</option>
                        <option value="A16" {{ old('nomor_meja') == 'A16' ? 'selected' : '' }}>A16</option>
                        <option value="A17" {{ old('nomor_meja') == 'A17' ? 'selected' : '' }}>A17</option>
                        <option value="A18" {{ old('nomor_meja') == 'A18' ? 'selected' : '' }}>A18</option>
                        <option value="A19" {{ old('nomor_meja') == 'A19' ? 'selected' : '' }}>A19</option>
                        <option value="A20" {{ old('nomor_meja') == 'A20' ? 'selected' : '' }}>A20</option>

                        <option value="A21" {{ old('nomor_meja') == 'A21' ? 'selected' : '' }}>A21</option>
                        <option value="A22" {{ old('nomor_meja') == 'A22' ? 'selected' : '' }}>A22</option>
                        <option value="A23" {{ old('nomor_meja') == 'A23' ? 'selected' : '' }}>A23</option>
                        <option value="A24" {{ old('nomor_meja') == 'A24' ? 'selected' : '' }}>A24</option>
                        <option value="A25" {{ old('nomor_meja') == 'A25' ? 'selected' : '' }}>A25</option>

                    </select>

                    @error('nomor_meja')
                        <small class="error-message">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                <!-- TOMBOL -->
                <button
                    type="submit"
                    class="order-button"
                    id="orderButton"
                >
                    <span>Mulai Memesan</span>
                    <span class="button-arrow">→</span>
                </button>

            </form>

            <div class="customer-footer">
                Smart Ordering Café
            </div>

        </div>

    </main>

    <script src="{{ asset('js/pelanggan.js') }}"></script>

</body>
</html>