@extends('layouts.dashboard-admin')

@section('page-title', 'Edit User')
@section('page-subtitle', 'Perbarui data pengguna WarungKu')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Form Edit User</h2>
                <p>Admin dapat memperbarui data pengguna dan mereset password jika diperlukan.</p>
            </div>

            <a href="{{ route('admin.users') }}" class="btn-back-menu">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="menu-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Nama User</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                @error('name') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email User</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
                @error('email') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role">
                    <option value="pembeli" {{ old('role', $user->role) === 'pembeli' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="penjual" {{ old('role', $user->role) === 'penjual' ? 'selected' : '' }}>Penjual</option>
                </select>
                @error('role') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" value="{{ old('nim', $user->nim) }}">
                @error('nim') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="fakultas">Fakultas</label>
                <input type="text" id="fakultas" name="fakultas" value="{{ old('fakultas', $user->fakultas) }}">
                @error('fakultas') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <input type="text" id="prodi" name="prodi" value="{{ old('prodi', $user->prodi) }}">
                @error('prodi') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="angkatan">Angkatan</label>
                <input type="text" id="angkatan" name="angkatan" value="{{ old('angkatan', $user->angkatan) }}">
                @error('angkatan') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="kontak">Kontak</label>
                <input type="text" id="kontak" name="kontak" value="{{ old('kontak', $user->kontak) }}">
                @error('kontak') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group full">
                <label for="alamat">Alamat / Area</label>
                <textarea id="alamat" name="alamat" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password">
                @error('password') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
            </div>

            <div class="form-group full">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    Akun aktif
                </label>
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