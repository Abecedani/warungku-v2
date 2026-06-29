@extends('layouts.main')

@section('title', 'Akun Saya - WarungKu')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/penjual-dashboard.css') }}">

    <div class="container-fluid px-4 py-4" style="background:#fafafa;min-height:100vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">👤 Akun Saya</h3>
                <span class="text-muted">Kelola informasi akun Anda</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- FOTO --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Foto Profil</h5>
                <div class="d-flex align-items-center gap-4">
                    <div style="width:110px;height:110px;border-radius:50%;overflow:hidden;border:3px solid #eee;background:#fff3ec;display:flex;align-items:center;justify-content:center;font-size:45px;font-weight:bold;color:#e65c00;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{ strtoupper(substr($user->name,0,1)) }}
                        @endif
                    </div>
                    <form method="POST" action="{{ route('warungs.akun.avatar') }}" enctype="multipart/form-data">
                        @csrf
                        <label class="fw-semibold mb-2">Upload Foto</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*" onchange="this.form.submit()">
                        <small class="text-muted">JPG / PNG • Maksimal 2MB</small>
                    </form>
                </div>
            </div>
        </div>

        {{-- INFORMASI --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Informasi Akun</h5>
                <form method="POST" action="{{ route('warungs.akun.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$user->name) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold mb-2">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="fw-semibold mb-2">Nomor HP</label>
                            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number',$user->phone_number) }}">
                        </div>
                    </div>
                    <hr class="my-4">
                    <h5 class="fw-bold mb-3">🔒 Ganti Password</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold mb-2">Password Lama</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold mb-2">Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button class="btn btn-orange px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection