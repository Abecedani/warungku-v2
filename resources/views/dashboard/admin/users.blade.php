@extends('layouts.dashboard-admin')

@section('page-title', 'Kelola User')
@section('page-subtitle', 'Lihat, cari, edit, dan kelola akun mahasiswa serta penjual')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Daftar User</h2>
                <p>Admin dapat mencari, mengedit, mengaktifkan, atau menonaktifkan akun pengguna.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- [PERUBAHAN] Form pencarian user dipindahkan ke dalam content-card agar tampilan lebih rapi --}}
        <form action="{{ route('admin.users') }}" method="GET" class="menu-form" style="margin-bottom: 20px;">
            <div class="form-group full">
                <label for="search">Cari User</label>
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ $search ?? '' }}"
                       placeholder="Cari nama, email, role, NIM, fakultas, atau prodi">
            </div>

            <div class="form-action">
                <a href="{{ route('admin.users') }}" class="btn-back-menu">
                    Reset
                </a>

                <button type="submit" class="btn-save-menu">
                    <i class="bi bi-search"></i>
                    <span>Cari</span>
                </button>
            </div>
        </form>

        @if($users->count() > 0)
            <div class="menu-list">
                @foreach($users as $user)
                    <div class="menu-row">
                        <div class="menu-photo">
                            @if($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}">
                            @else
                                <i class="bi bi-person"></i>
                            @endif
                        </div>

                        <div class="menu-info">
                            <h4>{{ $user->name }}</h4>

                            <p>{{ $user->email }}</p>

                            <p>
                                Role:
                                {{ $user->role === 'pembeli' ? 'Mahasiswa' : ucfirst($user->role) }}
                            </p>

                            @if($user->role === 'pembeli')
                                <p>
                                    NIM:
                                    {{ $user->nim ?? 'Belum diisi' }}
                                </p>

                                <p>
                                    Fakultas:
                                    {{ $user->fakultas ?? 'Belum diisi' }}
                                </p>
                            @endif

                            @if($user->is_active)
                                <span>Aktif</span>
                            @else
                                <span style="color: #dc2626;">Nonaktif</span>
                            @endif
                        </div>

                        <div class="menu-action">
                            {{-- [PERUBAHAN] Tombol edit user --}}
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">
                                Edit
                            </a>

                            {{-- [PERUBAHAN] Tombol aktif/nonaktif user --}}
                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="{{ $user->is_active ? 'btn-delete' : 'btn-edit' }}"
                                        onclick="return confirm('Yakin ingin mengubah status akun ini?')">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h4>Data user tidak ditemukan</h4>
                <p>Belum ada user yang sesuai dengan kata kunci pencarian.</p>
            </div>
        @endif
    </div>
@endsection