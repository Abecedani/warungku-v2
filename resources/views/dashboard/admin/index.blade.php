@extends('layouts.dashboard-admin')

@section('page-title', 'Home Admin')
@section('page-subtitle', 'Ringkasan data utama sistem WarungKu')

@section('content')
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon">
                <i class="bi bi-mortarboard"></i>
            </div>
            <h3>{{ $totalMahasiswa }}</h3>
            <p>Total Mahasiswa</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon">
                <i class="bi bi-person-badge"></i>
            </div>
            <h3>{{ $totalPenjual }}</h3>
            <p>Total Penjual</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon">
                <i class="bi bi-shop"></i>
            </div>
            <h3>{{ $totalWarung }}</h3>
            <p>Total Warung</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <h3>{{ $warungPending }}</h3>
            <p>Menunggu Verifikasi</p>
        </div>
    </div>

    <div class="content-card">
        <h2>Ringkasan Admin</h2>
        <p>
            Admin bertugas memantau data sistem, memverifikasi warung baru,
            mengelola akun pengguna, serta memastikan data warung yang tampil
            di WarungKu sudah sesuai.
        </p>
    </div>
@endsection