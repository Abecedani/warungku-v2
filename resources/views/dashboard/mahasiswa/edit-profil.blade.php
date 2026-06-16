@extends('layouts.dashboard-mahasiswa')

@section('page-title', 'Edit Profil Mahasiswa')
@section('page-subtitle', 'Perbarui data profil mahasiswa')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Form Edit Profil Mahasiswa</h2>
                <p>Lengkapi data mahasiswa agar akun lebih mudah dikenali.</p>
            </div>

            <a href="{{ route('mahasiswa.profil') }}" class="btn-back-menu">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data" class="menu-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="foto">Foto Profil</label>

                @if($mahasiswa->foto)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $mahasiswa->foto) }}"
                             alt="{{ $mahasiswa->name }}"
                             style="width: 120px; height: 120px; object-fit: cover; border-radius: 18px;">
                    </div>
                @endif

                <input type="file" id="foto" name="foto" accept="image/*">

                @error('foto')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Nama Mahasiswa</label>
                <input type="text" id="name" name="name" value="{{ old('name', $mahasiswa->name) }}">

                @error('name')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" placeholder="Contoh: F1D024000">

                @error('nim')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="fakultas">Fakultas</label>
                <select id="fakultas" name="fakultas">
                    <option value="">Pilih fakultas</option>

                    @php
                        $fakultasList = [
                            'FEB - Fakultas Ekonomi dan Bisnis',
                            'FHISIP - Fakultas Hukum, Ilmu Sosial dan Ilmu Politik',
                            'FKIP - Fakultas Keguruan dan Ilmu Pendidikan',
                            'FT - Fakultas Teknik',
                            'Fakultas Pertanian',
                            'FKIK - Fakultas Kedokteran dan Ilmu Kesehatan',
                            'Fakultas Peternakan',
                            'FPDA - Fakultas Teknologi Pangan dan Agroindustri',
                            'FMIPA - Fakultas Matematika dan Ilmu Pengetahuan Alam',
                        ];
                    @endphp

                    @foreach($fakultasList as $fakultas)
                        <option value="{{ $fakultas }}" {{ old('fakultas', $mahasiswa->fakultas) == $fakultas ? 'selected' : '' }}>
                            {{ $fakultas }}
                        </option>
                    @endforeach
                </select>

                @error('fakultas')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <input type="text" id="prodi" name="prodi" value="{{ old('prodi', $mahasiswa->prodi) }}" placeholder="Contoh: Informatika">

                @error('prodi')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="angkatan">Angkatan</label>
                <input type="text" id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" placeholder="Contoh: 2024">

                @error('angkatan')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="kontak">Nomor WhatsApp</label>
                <input type="text" id="kontak" name="kontak" value="{{ old('kontak', $mahasiswa->kontak) }}" placeholder="Contoh: 081234567890">

                @error('kontak')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group full">
                <label for="alamat">Alamat / Area Tinggal</label>
                <textarea id="alamat" name="alamat" rows="4" placeholder="Contoh: Kos sekitar Gomong, Pagesangan, atau area kampus">{{ old('alamat', $mahasiswa->alamat) }}</textarea>

                @error('alamat')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-action">
                <button type="submit" class="btn-save-menu">
                    <i class="bi bi-check-circle"></i>
                    <span>Simpan Profil</span>
                </button>
            </div>
        </form>
    </div>
@endsection