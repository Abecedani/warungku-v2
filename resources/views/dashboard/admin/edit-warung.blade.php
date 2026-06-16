@extends('layouts.dashboard-admin')

@section('page-title', 'Edit Warung')
@section('page-subtitle', 'Perbarui data dan status verifikasi warung')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Form Edit Warung</h2>
                <p>Admin dapat memperbarui data warung dan status verifikasinya.</p>
            </div>

            <a href="{{ route('admin.warungs') }}" class="btn-back-menu">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('admin.warungs.update', $warung->id) }}" method="POST" class="menu-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="nama">Nama Warung</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $warung->nama) }}">
                @error('nama') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Pemilik Warung</label>
                <input type="text" value="{{ $warung->user->name ?? 'Tidak diketahui' }}" disabled>
            </div>

            <div class="form-group">
                <label for="status">Status Buka/Tutup</label>
                <select id="status" name="status">
                    <option value="buka" {{ old('status', $warung->status) === 'buka' ? 'selected' : '' }}>Buka</option>
                    <option value="tutup" {{ old('status', $warung->status) === 'tutup' ? 'selected' : '' }}>Tutup</option>
                </select>
                @error('status') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori">
                    <option value="makanan" {{ old('kategori', $warung->kategori) === 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ old('kategori', $warung->kategori) === 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ old('kategori', $warung->kategori) === 'snack' ? 'selected' : '' }}>Snack</option>
                </select>
                @error('kategori') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="status_verifikasi">Status Verifikasi</label>
                <select id="status_verifikasi" name="status_verifikasi">
                    <option value="pending" {{ old('status_verifikasi', $warung->status_verifikasi) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ old('status_verifikasi', $warung->status_verifikasi) === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ old('status_verifikasi', $warung->status_verifikasi) === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status_verifikasi') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="kontak">Kontak</label>
                <input type="text" id="kontak" name="kontak" value="{{ old('kontak', $warung->kontak) }}">
                @error('kontak') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="area_kampus">Area Kampus</label>
                <input type="text" id="area_kampus" name="area_kampus" value="{{ old('area_kampus', $warung->area_kampus) }}">
                @error('area_kampus') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="estimasi_waktu">Estimasi Waktu</label>
                <input type="text" id="estimasi_waktu" name="estimasi_waktu" value="{{ old('estimasi_waktu', $warung->estimasi_waktu) }}">
                @error('estimasi_waktu') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="jam_buka">Jam Buka</label>
                <input type="time" id="jam_buka" name="jam_buka" value="{{ old('jam_buka', $warung->jam_buka) }}">
                @error('jam_buka') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="jam_tutup">Jam Tutup</label>
                <input type="time" id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup', $warung->jam_tutup) }}">
                @error('jam_tutup') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group full">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3">{{ old('alamat', $warung->alamat) }}</textarea>
                @error('alamat') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group full">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $warung->deskripsi) }}</textarea>
                @error('deskripsi') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group full">
                <label for="catatan_verifikasi">Catatan Verifikasi</label>
                <textarea id="catatan_verifikasi" name="catatan_verifikasi" rows="3" placeholder="Isi jika warung ditolak atau perlu catatan admin">{{ old('catatan_verifikasi', $warung->catatan_verifikasi) }}</textarea>
                @error('catatan_verifikasi') <small class="form-error">{{ $message }}</small> @enderror
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