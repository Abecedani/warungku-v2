@extends('layouts.dashboard-warung')

@section('page-title', 'Edit Menu')
@section('page-subtitle', 'Perbarui data menu warungmu')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Form Edit Menu</h2>
                <p>Ubah data menu yang sudah kamu tambahkan.</p>
            </div>

            <a href="{{ route('penjual.menu') }}" class="btn-back-menu">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('penjual.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="menu-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="foto">Foto Menu</label>

                @if($menu->foto)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 16px;">
                    </div>
                @endif

                <input type="file" id="foto" name="foto" accept="image/*">
                @error('foto')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_menu">Nama Menu</label>
                <input type="text" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama) }}">
                @error('nama_menu')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" value="{{ old('harga', $menu->harga) }}">
                @error('harga')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori">
                    <option value="makanan" {{ old('kategori', $menu->kategori) == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ old('kategori', $menu->kategori) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ old('kategori', $menu->kategori) == 'snack' ? 'selected' : '' }}>Snack</option>
                </select>
                @error('kategori')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="varian">Varian / Level</label>
                <input type="text" id="varian" name="varian" value="{{ old('varian', $menu->varian) }}">
                @error('varian')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status Menu</label>
                <select id="status" name="status">
                    <option value="tersedia" {{ old('status', $menu->tersedia ? 'tersedia' : 'habis') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ old('status', $menu->tersedia ? 'tersedia' : 'habis') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
                @error('status')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group full">
                <label for="deskripsi">Deskripsi Menu</label>
                <textarea id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                @error('deskripsi')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-action">
                <button type="submit" class="btn-save-menu">
                    <i class="bi bi-check-circle"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
@endsection