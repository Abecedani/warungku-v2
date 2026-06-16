@extends('layouts.dashboard-warung')

@section('page-title', 'Home Warung')
@section('page-subtitle', 'Selamat datang di dashboard warungmu')

@section('content')

    {{-- Status Warung --}}
    <div class="content-card" style="margin-bottom: 24px;">
        <div class="profile-warung-header">
            <div class="profile-warung-photo">
                @if($warung && $warung->foto)
                    <img src="{{ asset('storage/' . $warung->foto) }}" alt="{{ $warung->nama }}">
                @else
                    <i class="bi bi-shop"></i>
                @endif
            </div>

            <div class="profile-warung-info" style="flex: 1;">
                <h2>{{ $warung->nama ?? 'Nama Warung Belum Diisi' }}</h2>
                <div class="profile-badges">
                    <span class="profile-status {{ ($warung->status ?? 'tutup') === 'buka' ? 'status-open' : 'status-close' }}">
                        <i class="bi bi-circle-fill" style="font-size: 8px;"></i>
                        {{ ucfirst($warung->status ?? 'Tutup') }}
                    </span>
                    @if(($warung->status_verifikasi ?? 'pending') === 'pending')
                        <span class="profile-category" style="background:#fef9c3;color:#854d0e;">
                            <i class="bi bi-clock"></i> Menunggu Verifikasi
                        </span>
                    @elseif(($warung->status_verifikasi ?? '') === 'disetujui')
                        <span class="profile-category" style="background:#dcfce7;color:#15803d;">
                            <i class="bi bi-patch-check-fill"></i> Terverifikasi
                        </span>
                    @elseif(($warung->status_verifikasi ?? '') === 'ditolak')
                        <span class="profile-category" style="background:#fee2e2;color:#b91c1c;">
                            <i class="bi bi-x-circle"></i> Ditolak
                        </span>
                    @endif
                </div>
            </div>

            @if($warung)
            <form method="POST" action="{{ route('penjual.toggle-status') }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-save-menu" style="background: {{ ($warung->status ?? 'tutup') === 'buka' ? '#dc2626' : '#16a34a' }};">
                    <i class="bi bi-{{ ($warung->status ?? 'tutup') === 'buka' ? 'pause-circle' : 'play-circle' }}"></i>
                    {{ ($warung->status ?? 'tutup') === 'buka' ? 'Tutup Warung' : 'Buka Warung' }}
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Statistik --}}
    <div class="summary-grid" style="margin-bottom: 24px;">
        <div class="summary-card">
            <div class="summary-icon">
                <i class="bi bi-card-list"></i>
            </div>
            <h3>{{ $totalMenu }}</h3>
            <p>Total Menu</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon" style="background:#dcfce7;color:#16a34a;">
                <i class="bi bi-check-circle"></i>
            </div>
            <h3>{{ $menuTersedia }}</h3>
            <p>Menu Tersedia</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon" style="background:#fef9c3;color:#ca8a04;">
                <i class="bi bi-receipt"></i>
            </div>
            <h3>{{ $pesananMasuk }}</h3>
            <p>Pesanan Masuk</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon" style="background:#ede9fe;color:#7c3aed;">
                <i class="bi bi-bag-check"></i>
            </div>
            <h3>{{ $pesananSelesai }}</h3>
            <p>Pesanan Selesai</p>
        </div>
    </div>

    {{-- Pesanan Terbaru --}}
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Pesanan Terbaru</h2>
                <p>{{ $pesananTerbaru->count() }} pesanan terakhir masuk</p>
            </div>
            <a href="{{ route('penjual.pesanan') }}" class="btn-add-menu">
                <i class="bi bi-receipt"></i> Lihat Semua
            </a>
        </div>

        <div class="order-list">
            @forelse($pesananTerbaru as $pesanan)
                <div class="order-item">
                    <div>
                        <h4>{{ $pesanan->nama_pembeli ?? 'Pembeli' }}</h4>
                        <p>{{ $pesanan->created_at ?? '-' }}</p>
                    </div>
                    <span class="order-status">{{ ucfirst($pesanan->status ?? '-') }}</span>
                </div>
            @empty
                <p style="color: var(--gray); text-align: center; padding: 24px 0;">
                    <i class="bi bi-inbox" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                    Belum ada pesanan masuk
                </p>
            @endforelse
        </div>
    </div>

@endsection