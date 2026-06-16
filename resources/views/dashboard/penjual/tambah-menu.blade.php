@extends('layouts.dashboard-warung')

@section('page-title', 'Tambah Menu')
@section('page-subtitle', 'Tambahkan menu baru untuk warungmu')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Form Tambah Menu</h2>
                <p>Isi data menu yang ingin kamu tampilkan di WarungKu.</p>
            </div>

            <a href="{{ route('penjual.menu') }}" class="btn-back-menu">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('penjual.menu.store') }}" method="POST" enctype="multipart/form-data" class="menu-form">
            @csrf

            <div class="form-group">
                <label for="foto">Foto Menu</label>
                <input type="file" id="foto" name="foto" accept="image/*">
                @error('foto')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_menu">Nama Menu</label>
                <input type="text" id="nama_menu" name="nama_menu" value="{{ old('nama_menu') }}" placeholder="Contoh: Nasi Ayam Suwir">
                @error('nama_menu')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" value="{{ old('harga') }}" placeholder="Contoh: 12000">
                @error('harga')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori">
                    <option value="">Pilih kategori</option>
                    <option value="makanan" {{ old('kategori') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ old('kategori') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ old('kategori') == 'snack' ? 'selected' : '' }}>Snack</option>
                </select>
                @error('kategori')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="varian">Varian / Level</label>
                <input type="text" id="varian" name="varian" value="{{ old('varian') }}" placeholder="Contoh: Pedas level 1-5, original, sambal matah">
                @error('varian')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status Menu</label>
                <select id="status" name="status">
                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
                @error('status')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group full">
                <label for="deskripsi">Deskripsi Menu</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Tulis deskripsi singkat menu">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-action">
                <button type="submit" class="btn-save-menu">
                    <i class="bi bi-check-circle"></i>
                    <span>Simpan Menu</span>
                </button>
            </div>
        </form>
    </div>
@endsection