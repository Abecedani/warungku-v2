@extends('layouts.dashboard-warung')

@section('page-title', 'Profil Warung')
@section('page-subtitle', 'Lihat informasi warung dan pengaturan akun')

@section('content')
    <div class="content-card">

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-warung-header">
            <div class="profile-warung-photo">
                @if($warung && $warung->foto)
                    <img src="{{ asset('storage/' . $warung->foto) }}" alt="{{ $warung->nama }}">
                @else
                    <i class="bi bi-shop"></i>
                @endif
            </div>

            <div class="profile-warung-info">
                <h2>{{ $warung->nama ?? 'Nama Warung Belum Diisi' }}</h2>

                <div class="profile-badges">
                    <span class="profile-status {{ ($warung->status ?? 'tutup') === 'buka' ? 'status-open' : 'status-close' }}">
                        {{ ucfirst($warung->status ?? 'tutup') }}
                    </span>

                    <span class="profile-category">
                        {{ ucfirst($warung->kategori ?? 'Kategori belum diisi') }}
                    </span>

                    {{-- [PERUBAHAN] Badge status verifikasi --}}
                    <span class="profile-category">
                        @if(($warung->status_verifikasi ?? 'pending') === 'disetujui')
                            Terverifikasi
                        @elseif(($warung->status_verifikasi ?? 'pending') === 'ditolak')
                            Verifikasi Ditolak
                        @else
                            Menunggu Verifikasi
                        @endif
                    </span>
                </div>

                <p>
                    {{ $warung->deskripsi ?? 'Deskripsi warung belum ditambahkan.' }}
                </p>
            </div>
        </div>

        <div class="profile-detail-grid">
            <div class="profile-detail-item">
                <small>Status Verifikasi</small>
                <strong>
                    @if(($warung->status_verifikasi ?? 'pending') === 'disetujui')
                        Disetujui
                    @elseif(($warung->status_verifikasi ?? 'pending') === 'ditolak')
                        Ditolak
                    @else
                        Menunggu verifikasi admin
                    @endif
                </strong>
            </div>

            {{-- [PERUBAHAN] Catatan admin jika warung ditolak --}}
            @if($warung && $warung->status_verifikasi === 'ditolak' && $warung->catatan_verifikasi)
                <div class="profile-detail-item">
                    <small>Catatan Admin</small>
                    <strong>{{ $warung->catatan_verifikasi }}</strong>
                </div>
            @endif

            <div class="profile-detail-item">
                <small>Area Kampus</small>
                <strong>{{ $warung->area_kampus ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Alamat Detail</small>
                <strong>{{ $warung->alamat ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Kontak</small>
                <strong>{{ $warung->kontak ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Jam Operasional</small>
                <strong>
                    @if($warung && $warung->jam_buka && $warung->jam_tutup)
                        {{ substr($warung->jam_buka, 0, 5) }} - {{ substr($warung->jam_tutup, 0, 5) }}
                    @else
                        Belum diisi
                    @endif
                </strong>
            </div>

            <div class="profile-detail-item">
                <small>Estimasi Penyajian</small>
                <strong>{{ $warung->estimasi_waktu ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Area Kampus</small>
                <strong>{{ $warung->area_kampus ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Alamat Detail</small>
                <strong>{{ $warung->alamat ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Kontak</small>
                <strong>{{ $warung->kontak ?? 'Belum diisi' }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Jam Operasional</small>
                <strong>
                    @if($warung && $warung->jam_buka && $warung->jam_tutup)
                        {{ substr($warung->jam_buka, 0, 5) }} - {{ substr($warung->jam_tutup, 0, 5) }}
                    @else
                        Belum diisi
                    @endif
                </strong>
            </div>

            <div class="profile-detail-item">
                <small>Estimasi Penyajian</small>
                <strong>{{ $warung->estimasi_waktu ?? 'Belum diisi' }}</strong>
            </div>
        </div>
    </div>

    <div class="content-card profile-menu-card">
        <h3>Pengaturan Warung</h3>

        <div class="profile-menu-list">
            <a href="{{ route('penjual.profil.edit') }}" class="profile-menu-item">
                <div>
                    <i class="bi bi-pencil-square"></i>
                    <span>Edit Profil Warung</span>
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
                    <i class="bi bi-info-circle"></i>
                    <span>Tentang WarungKu</span>
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