@extends('layouts.dashboard-mahasiswa')

@section('page-title', 'Profil Mahasiswa')
@section('page-subtitle', 'Lihat informasi akun dan pengaturan mahasiswa')

@section('content')
    <div class="content-card">

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-warung-header">
            <div class="profile-warung-photo">
                @if($mahasiswa->foto)
                    <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="{{ $mahasiswa->name }}">
                @else
                    <i class="bi bi-person"></i>
                @endif
            </div>

            <div class="profile-warung-info">
                <h2>{{ $mahasiswa->name }}</h2>

                <div class="profile-badges">
                    <span class="profile-category">
                        {{ $mahasiswa->role === 'mahasiswa' ? 'Mahasiswa' : ucfirst($mahasiswa->role ?? 'Mahasiswa') }}
                    </span>

                    <span class="profile-status status-open">
                        Akun Aktif
                    </span>
                </div>

                <p>
                    {{ $mahasiswa->email }}
                </p>
            </div>
        </div>

        <div class="profile-detail-grid">
            <div class="profile-detail-item">
                <small>NIM</small>
                <strong>{{ $mahasiswa->nim ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Fakultas</small>
                <strong>{{ $mahasiswa->fakultas ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Program Studi</small>
                <strong>{{ $mahasiswa->prodi ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Angkatan</small>
                <strong>{{ $mahasiswa->angkatan ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Kontak</small>
                <strong>{{ $mahasiswa->kontak ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Alamat / Area Tinggal</small>
                <strong>{{ $mahasiswa->alamat ?? 'Belum diisi' }}</strong>
            </div>
        </div>
    </div>

    <div class="content-card profile-menu-card">
        <h3>Pengaturan Mahasiswa</h3>

        <div class="profile-menu-list">
            <a href="{{ route('mahasiswa.profil.edit') }}" class="profile-menu-item">
                <div>
                    <i class="bi bi-pencil-square"></i>
                    <span>Edit Profil Mahasiswa</span>
                </div>
                <i class="bi bi-chevron-right"></i>
            </a>

            <a href="{{ route('profile.edit') }}" class="profile-menu-item">
                <div>
                    <i class="bi bi-shield-lock"></i>
                    <span>Keamanan Akun dan Kata Sandi</span>
                </div>
                <i class="bi bi-chevron-right"></i>
            </a>

            <a href="#" class="profile-menu-item">
                <div>
                    <i class="bi bi-question-circle"></i>
                    <span>Panduan Penggunaan</span>
                </div>
                <i class="bi bi-chevron-right"></i>
            </a>

            <a href="#" class="profile-menu-item">
                <div>
                    <i class="bi bi-info-circle"></i>
                    <span>Tentang WarungKu</span>
                </div>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
@endsection