@extends('layouts.dashboard-admin')

@section('page-title', 'Kelola Warung')
@section('page-subtitle', 'Lihat, cari, edit, dan kelola seluruh data warung')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Daftar Warung</h2>
                <p>Admin dapat memantau, mencari, dan memperbarui data warung yang terdaftar di WarungKu.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- [PERUBAHAN] Form pencarian warung --}}
        <form action="{{ route('admin.warungs') }}" method="GET" class="menu-form" style="margin-bottom: 20px;">
            <div class="form-group full">
                <label for="search">Cari Warung</label>
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ $search ?? '' }}"
                       placeholder="Cari nama warung, pemilik, area, alamat, status buka/tutup, atau status verifikasi">
            </div>

            <div class="form-action">
                <a href="{{ route('admin.warungs') }}" class="btn-back-menu">
                    Reset
                </a>

                <button type="submit" class="btn-save-menu">
                    <i class="bi bi-search"></i>
                    <span>Cari</span>
                </button>
            </div>
        </form>

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

                            <p>
                                Pemilik:
                                {{ $warung->user->name ?? 'Tidak diketahui' }}
                            </p>

                            <p>
                                Email Pemilik:
                                {{ $warung->user->email ?? 'Tidak diketahui' }}
                            </p>

                            <p>
                                Area:
                                {{ $warung->area_kampus ?? 'Belum diisi' }}
                            </p>

                            <p>
                                Alamat:
                                {{ $warung->alamat ?? 'Belum diisi' }}
                            </p>

                            <p>
                                Status Buka/Tutup:
                                {{ ucfirst($warung->status ?? 'Belum diisi') }}
                            </p>

                            <p>
                                Kategori:
                                {{ ucfirst($warung->kategori ?? 'Belum diisi') }}
                            </p>

                            @if(($warung->status_verifikasi ?? 'pending') === 'disetujui')
                                <span>Verifikasi: Disetujui</span>
                            @elseif(($warung->status_verifikasi ?? 'pending') === 'ditolak')
                                <span style="color: #dc2626;">Verifikasi: Ditolak</span>
                            @else
                                <span style="color: #f59e0b;">Verifikasi: Pending</span>
                            @endif

                            @if($warung->catatan_verifikasi)
                                <p>
                                    Catatan Admin:
                                    {{ $warung->catatan_verifikasi }}
                                </p>
                            @endif
                        </div>

                        <div class="menu-action">
                            {{-- [PERUBAHAN] Tombol edit warung --}}
                            <a href="{{ route('admin.warungs.edit', $warung->id) }}" class="btn-edit">
                                Edit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <h4>Data warung tidak ditemukan</h4>
                <p>Belum ada warung yang sesuai dengan kata kunci pencarian.</p>
            </div>
        @endif
    </div>
@endsection