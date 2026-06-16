@extends('layouts.dashboard-warung')

@section('page-title', 'Profil Warung')
@section('page-subtitle', 'Kelola informasi warungmu')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Profil Warung</h2>
                <p>Lengkapi informasi warung agar mahasiswa lebih mudah menemukan lokasi dan mengetahui status warung.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('penjual.profil.update') }}" method="POST" enctype="multipart/form-data" class="menu-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="foto">Foto Profil Warung</label>

                @if($warung && $warung->foto)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $warung->foto) }}"
                             alt="{{ $warung->nama }}"
                             style="width: 130px; height: 130px; object-fit: cover; border-radius: 18px;">
                    </div>
                @endif

                <input type="file" id="foto" name="foto" accept="image/*">

                @error('foto')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama">Nama Warung</label>
                <input type="text"
                       id="nama"
                       name="nama"
                       value="{{ old('nama', $warung->nama ?? '') }}"
                       placeholder="Contoh: Warung Bu Rahma">

                @error('nama')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status Warung</label>
                <select id="status" name="status">
                    <option value="buka" {{ old('status', $warung->status ?? 'buka') == 'buka' ? 'selected' : '' }}>
                        Buka
                    </option>
                    <option value="tutup" {{ old('status', $warung->status ?? '') == 'tutup' ? 'selected' : '' }}>
                        Tutup
                    </option>
                </select>

                @error('status')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori Utama</label>
                <select id="kategori" name="kategori">
                    <option value="makanan" {{ old('kategori', $warung->kategori ?? '') == 'makanan' ? 'selected' : '' }}>
                        Makanan
                    </option>
                    <option value="minuman" {{ old('kategori', $warung->kategori ?? '') == 'minuman' ? 'selected' : '' }}>
                        Minuman
                    </option>
                    <option value="snack" {{ old('kategori', $warung->kategori ?? '') == 'snack' ? 'selected' : '' }}>
                        Snack
                    </option>
                </select>

                @error('kategori')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="kontak">Kontak Warung</label>
                <input type="text"
                       id="kontak"
                       name="kontak"
                       value="{{ old('kontak', $warung->kontak ?? '') }}"
                       placeholder="Contoh: 081234567890">

                @error('kontak')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="area_kampus">Area Kampus / Fakultas Terdekat</label>
                <select id="area_kampus" name="area_kampus">
                    <option value="">Pilih area</option>

                    @php
                        $areas = [
                            'FEB - Fakultas Ekonomi dan Bisnis',
                            'FHISIP - Fakultas Hukum, Ilmu Sosial dan Ilmu Politik',
                            'FKIP - Fakultas Keguruan dan Ilmu Pendidikan',
                            'FT - Fakultas Teknik',
                            'Fakultas Pertanian',
                            'FKIK - Fakultas Kedokteran dan Ilmu Kesehatan',
                            'Fakultas Peternakan',
                            'FPDA - Fakultas Teknologi Pangan dan Agroindustri',
                            'FMIPA - Fakultas Matematika dan Ilmu Pengetahuan Alam',
                            'Food Court UNRAM',
                            'Area Rektorat',
                            'Area Perpustakaan',
                            'Area lain',
                        ];
                    @endphp

                    @foreach($areas as $area)
                        <option value="{{ $area }}" {{ old('area_kampus', $warung->area_kampus ?? '') == $area ? 'selected' : '' }}>
                            {{ $area }}
                        </option>
                    @endforeach
                </select>

                @error('area_kampus')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="estimasi_waktu">Estimasi Waktu Penyajian</label>
                <input type="text"
                       id="estimasi_waktu"
                       name="estimasi_waktu"
                       value="{{ old('estimasi_waktu', $warung->estimasi_waktu ?? '') }}"
                       placeholder="Contoh: 10-15 menit">

                @error('estimasi_waktu')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="jam_buka">Jam Buka</label>
                <input type="time"
                       id="jam_buka"
                       name="jam_buka"
                       value="{{ old('jam_buka', $warung->jam_buka ?? '') }}">

                @error('jam_buka')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="jam_tutup">Jam Tutup</label>
                <input type="time"
                       id="jam_tutup"
                       name="jam_tutup"
                       value="{{ old('jam_tutup', $warung->jam_tutup ?? '') }}">

                @error('jam_tutup')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group full">
                <label for="alamat">Alamat Detail</label>
                <textarea id="alamat"
                          name="alamat"
                          rows="3"
                          placeholder="Contoh: Dekat gerbang belakang Fakultas Teknik, samping parkiran motor">{{ old('alamat', $warung->alamat ?? '') }}</textarea>

                @error('alamat')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group full">
                <label for="deskripsi">Deskripsi Warung</label>
                <textarea id="deskripsi"
                          name="deskripsi"
                          rows="4"
                          placeholder="Contoh: Menjual nasi ayam, gorengan, dan minuman dingin dengan harga ramah mahasiswa.">{{ old('deskripsi', $warung->deskripsi ?? '') }}</textarea>

                @error('deskripsi')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-action">
                <button type="submit" class="btn-save-menu">
                    <i class="bi bi-check-circle"></i>
                    <span>Simpan Profil Warung</span>
                </button>
            </div>
        </form>
    </div>
@endsection