@extends('layouts.main')

@section('title', 'Profil Warung - WarungKu')

@section('content')
<link rel="stylesheet" href="{{ asset('css/penjual-dashboard.css') }}">

<div class="container-fluid p-4" style="background:#fafafa; min-height:100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">🏪 Profil Warung</h3>
            <p class="text-muted mb-0">Kelola informasi warung Anda.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">{{ session('error') }}</div>
    @endif

    @if($warung)
        @if(!$warung->is_verified)
        <div class="alert border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" style="background:#fff3cd;color:#856404;">
            <i class="bi bi-hourglass-split fs-4 me-3"></i>
            <div>
                <strong>Menunggu Verifikasi</strong><br>
                Warungmu sedang diperiksa oleh admin.
            </div>
        </div>
        @else
        <div class="alert border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" style="background:#d4edda;color:#155724;">
            <i class="bi bi-patch-check-fill fs-4 me-3"></i>
            <div>
                <strong>Warung Terverifikasi</strong><br>
                Warungmu sudah tampil di halaman utama.
            </div>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Informasi Warung</h5>
                <form method="POST" action="{{ route('warungs.profil.update') }}">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Warung</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $warung->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Lokasi Detail</label>
                            <input type="text" name="location_detail" class="form-control @error('location_detail') is-invalid @enderror" value="{{ old('location_detail', $warung->location_detail) }}" placeholder="Contoh: Stand dekat foodcourt" required>
                            @error('location_detail')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Ceritakan warungmu...">{{ old('description', $warung->description) }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-orange px-4 rounded-3">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-danger shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold text-danger mb-1">Hapus Warung</h5>
                        <p class="text-muted mb-0">Semua menu dan data warung akan ikut terhapus secara permanen.</p>
                    </div>
                    <button class="btn btn-outline-danger rounded-3" data-bs-toggle="modal" data-bs-target="#modalHapusWarung">
                        <i class="bi bi-trash me-1"></i> Hapus Warung
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <div class="display-3 mb-3">🏪</div>
                <h4 class="fw-bold mb-2">Belum Ada Warung</h4>
                <p class="text-muted mb-4">Daftarkan warungmu agar bisa mulai berjualan.</p>
                <a href="{{ route('warungs.create') }}" class="btn btn-orange px-4 rounded-3">
                    <i class="bi bi-shop me-1"></i> Buat Warung
                </a>
            </div>
        </div>
    @endif
</div>

@if(isset($warung) && $warung)
<div class="modal fade" id="modalHapusWarung" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus Warung
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('warungs.profil.destroy') }}">
                @csrf @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-warning mb-4">Tindakan ini tidak dapat dibatalkan.</div>
                    <p class="mb-2">Ketik nama warung untuk melanjutkan.</p>
                    <input type="text" name="confirm_name" class="form-control" placeholder="{{ $warung->name }}" required>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash me-1"></i> Hapus Warung</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection