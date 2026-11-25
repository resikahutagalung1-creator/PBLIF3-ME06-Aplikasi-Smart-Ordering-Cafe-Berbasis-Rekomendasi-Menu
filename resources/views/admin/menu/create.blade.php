
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        body {
            background: #f8f5f1;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 750px;
            margin: 35px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.08);
        }

        h2 {
            color: #70452b;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #777;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #3b2418;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd2c9;
            border-radius: 7px;
            box-sizing: border-box;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-simpan {
            background: #70452b;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 7px;
            cursor: pointer;
        }

        .btn-kembali {
            display: inline-block;
            margin-left: 10px;
            color: #70452b;
            text-decoration: none;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        @media(max-width: 600px) {
            .form-container {
                margin: 15px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="form-container">

    <h2>Tambah Menu</h2>
    <p class="subtitle">Masukkan informasi makanan atau minuman baru.</p>

    @if($errors->any())
        <div style="background:#f8d7da; color:#842029; padding:12px; border-radius:7px; margin-bottom:20px;">
            <strong>Periksa kembali data berikut:</strong>
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.menu.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text"
                   name="nama_menu"
                   value="{{ old('nama_menu') }}"
                   placeholder="Contoh: Cappuccino"
                   required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>

                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->kategori_id }}"
                        {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                      placeholder="Masukkan deskripsi menu">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number"
                   name="harga"
                   value="{{ old('harga') }}"
                   min="0"
                   placeholder="Contoh: 25000"
                   required>
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number"
                   name="stok"
                   value="{{ old('stok', 0) }}"
                   min="0"
                   required>
        </div>

        <div class="form-group">
            <label>Gambar Menu</label>
            <input type="file"
                   name="gambar"
                   accept=".jpg,.jpeg,.png,.webp">
            <small>Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</small>
        </div>

        <div class="form-group">
            <label>Status Menu</label>
            <select name="status" required>
                <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>
                    Tersedia
                </option>
                <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>
                    Habis
                </option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
        </div>

        <button type="submit" class="btn-simpan">
            Simpan Menu
        </button>

        <a href="{{ route('admin.menu') }}" class="btn-kembali">
            Kembali
        </a>

    </form>

</div>

</body>
</html>