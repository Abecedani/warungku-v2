@extends('layouts.dashboard-admin')

@section('page-title', 'Profil Admin')
@section('page-subtitle', 'Informasi akun dan pengaturan admin')

@section('content')
    <div class="content-card">
        <div class="profile-warung-header">
            <div class="profile-warung-photo">
                <i class="bi bi-person-gear"></i>
            </div>

            <div class="profile-warung-info">
                <h2>{{ Auth::user()->name }}</h2>

                <div class="profile-badges">
                    <span class="profile-category">Admin</span>
                    <span class="profile-status status-open">Akun Aktif</span>
                </div>

                <p>{{ Auth::user()->email }}</p>
            </div>
        </div>

        <div class="profile-detail-grid">
            <div class="profile-detail-item">
                <small>Nama Admin</small>
                <strong>{{ Auth::user()->name }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Email</small>
                <strong>{{ Auth::user()->email }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Role</small>
                <strong>{{ ucfirst(Auth::user()->role) }}</strong>
            </div>

            <div class="profile-detail-item">
                <small>Status Akun</small>
                <strong>Aktif</strong>
            </div>
        </div>
    </div>

    <div class="content-card profile-menu-card">
        <h3>Pengaturan Admin</h3>

        <div class="profile-menu-list">
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