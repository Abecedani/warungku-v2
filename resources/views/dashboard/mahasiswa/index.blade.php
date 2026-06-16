@extends('layouts.dashboard-mahasiswa')

@section('page-title', 'Dashboard Mahasiswa')
@section('page-subtitle', 'Pantau aktivitas pemesanan makananmu di WarungKu')

@section('content')
    <div class="content-card">
        <h2>Selamat datang, {{ Auth::user()->name }}</h2>
        <p>
            Melalui dashboard ini, mahasiswa dapat memesan makanan, melihat status pesanan,
            mengecek riwayat pesanan, dan mengelola profil akun.
        </p>
    </div>

    <div class="profile-detail-grid">
        <div class="profile-detail-item">
            <small>Pesanan Aktif</small>
            <strong>0 Pesanan</strong>
        </div>

        <div class="profile-detail-item">
            <small>Riwayat Pesanan</small>
            <strong>0 Pesanan</strong>
        </div>

        <div class="profile-detail-item">
            <small>Fakultas</small>
            <strong>{{ Auth::user()->fakultas ?? 'Belum diisi' }}</strong>
        </div>

        <div class="profile-detail-item">
            <small>Status Akun</small>
            <strong>Aktif</strong>
        </div>
    </div>
@endsection