@extends('layouts.dashboard-admin')

@section('page-title', 'Verifikasi Warung')
@section('page-subtitle', 'Setujui atau tolak warung yang baru didaftarkan')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Daftar Warung Baru</h2>
                <p>Warung dengan status pending perlu diperiksa oleh admin.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($warungs->count() > 0)
            <div class="menu-list">
                @foreach($warungs as $warung)
                    <div class="menu-row">
                        <div class="menu-photo">
                            @if($warung->foto)
                                <img src="{{ asset('storage/' . $warung->foto) }}" alt="{{ $warung->nama }}">
                            @else
                                <i class="bi bi-shop"></i>
                            @endif
                        </div>

                        <div class="menu-info">
                            <h4>{{ $warung->nama ?? 'Nama warung belum diisi' }}</h4>
                            <p>Pemilik: {{ $warung->user->name ?? 'Tidak diketahui' }}</p>
                            <p>Area: {{ $warung->area_kampus ?? 'Belum diisi' }}</p>
                            <p>Alamat: {{ $warung->alamat ?? 'Belum diisi' }}</p>
                            <span>Status: {{ ucfirst($warung->status_verifikasi) }}</span>
                        </div>

                        <div class="menu-action" style="flex-direction: column;">
                            <form action="{{ route('admin.verifikasi-warung.update', $warung->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="status_verifikasi" value="disetujui">

                                <button type="submit" class="btn-edit">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('admin.verifikasi-warung.update', $warung->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="status_verifikasi" value="ditolak">
                                <input type="hidden" name="catatan_verifikasi" value="Data warung belum lengkap atau belum memenuhi kriteria.">

                                <button type="submit" class="btn-delete">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <h4>Tidak ada warung pending</h4>
                <p>Semua pendaftaran warung sudah diverifikasi.</p>
            </div>
        @endif
    </div>
@endsection