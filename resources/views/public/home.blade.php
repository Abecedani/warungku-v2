@extends('layouts.app')

@section('content')

<section class="hero-section">
    <div class="container">
        <span class="badge bg-light text-dark mb-4">Khusus Mahasiswa Unram</span>

        <h1 class="hero-title mb-4">
            Lapar di Kampus?<br>
            Temukan Warungmu di Sini!
        </h1>

        <p class="hero-description">
            Direktori warung makan dan kantin di lingkungan Universitas Mataram.
            Cari menu favorit, cek harga, dan pesan makanan dalam satu platform.
        </p>

        <form class="search-box">
            <input type="text" placeholder="Cari warung atau menu...">
            <button type="submit">Cari</button>
        </form>

        <div class="d-flex gap-3 mt-3">
            <span>Makanan</span>
            <span> | </span>
            <span>Minuman</span>
            <span> | </span>
            <span>Snack</span>
            <span> | </span>
            <span>Paket Hemat</span>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="stats-number">{{ $totalWarung }}+</div>
                <p class="mb-0">Warung Terdaftar</p>
            </div>

            <div class="col-md-4">
                <div class="stats-number">{{ $totalMenu }}+</div>
                <p class="mb-0">Menu Tersedia</p>
            </div>

            <div class="col-md-4">
                <div class="stats-number">{{ $totalUser }}+</div>
                <p class="mb-0">Mahasiswa Aktif</p>
            </div>
        </div>
    </div>
</section>

<section class="why-section">
    <div class="container">
        <div class="text-center mb-2">
            <h2 class="fw-bold">Kenapa Pakai WarungKu?</h2>
            <p class="text-muted">Platform yang mengerti kebutuhan mahasiswa</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h5 class="fw-bold">Cari dengan Mudah</h5>
                    <p class="text-muted">
                        Temukan warung dan menu favorit berdasarkan kategori dan kata kunci.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <h5 class="fw-bold">Info Warung</h5>
                    <p class="text-muted">
                        Lihat status buka/tutup, harga menu, dan estimasi waktu masak.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5 class="fw-bold">Terverifikasi</h5>
                    <p class="text-muted">
                        Warung yang terdaftar dapat diverifikasi oleh admin sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="popular-section">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="section-heading">Warung Populer</h2>
                <p class="section-subtitle">Pilihan favorit mahasiswa</p>
            </div>

            <a href="{{ route('warung.index') }}" class="see-all-link">
                Lihat Semua <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($warungs as $warung)
            <div class="col-md-4">
                <div class="warung-card">
                    <div class="warung-image">
                        <img src="{{ asset('images/' . $warung->foto) }}" alt="{{ $warung->nama }}">
                        <span class="status-badge">{{ ucfirst($warung->status) }}</span>
                    </div>

                    <div class="warung-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5>{{ $warung->nama }}</h5>
                            <span class="rating">
                                <i class="bi bi-star-fill"></i> {{ $warung->rating }}
                            </span>
                        </div>

                        <p>{{ $warung->deskripsi }}</p>

                        <div class="warung-meta">
                            <span><i class="bi bi-clock"></i> {{ $warung->estimasi_waktu }}</span>
                            <span><i class="bi bi-cup-hot"></i> {{ ucfirst($warung->kategori) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted">Belum ada warung tersedia.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container text-center">
        <h2>Punya Warung di Unram?</h2>
        <p>
            Daftarkan warungmu sekarang dan jangkau lebih banyak mahasiswa.
            Gratis, gampang, dan langsung online!
        </p>

        <div class="cta-buttons">
            <a href="{{ route('register') }}" class="btn-cta-light">Daftar sebagai Pemilik Warung</a>
            <a href="{{ route('register') }}" class="btn-cta-outline">Daftar sebagai Mahasiswa</a>
        </div>
    </div>
</section>

<footer class="footer-warungku">
    <div class="container text-center">
        <div class="footer-brand">
            <img src="{{ asset('images/WarungKu-Logo.png') }}" alt="Logo WarungKu">
            <span>WarungKu</span>
        </div>

        <p>© 2026 WarungKu · Platform direktori warung mahasiswa Universitas Mataram</p>
    </div>
</footer>

@endsection