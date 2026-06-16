@extends('layouts.dashboard-warung')

@section('page-title', 'Kelola Menu')
@section('page-subtitle', 'Atur menu yang tersedia di warungmu')

@section('content')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <h2>Daftar Menu</h2>
                <p>Menu yang kamu tambahkan akan tampil di sini.</p>
            </div>

            <a href="{{ route('penjual.menu.tambah') }}" class="btn-add-menu">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Menu</span>
            </a>
        </div>

        @if($menus->count() > 0)
            <div class="menu-list">
                @foreach($menus as $menu)
                    <div class="menu-row">
                        <div class="menu-photo">
                            @if($menu->foto)
                                <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama }}">
                            @else
                                <i class="bi bi-image"></i>
                            @endif
                        </div>

                        <div class="menu-info">
                            <h4>{{ $menu->nama }}</h4>
                            <p>{{ $menu->deskripsi ?? 'Belum ada deskripsi menu.' }}</p>

                            @if($menu->varian)
                                <p class="menu-varian">{{ $menu->varian }}</p>
                            @endif

                            <span>Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>

                            <div class="menu-status">
                                @if($menu->tersedia)
                                    <small class="status-available">Tersedia</small>
                                @else
                                    <small class="status-empty">Habis</small>
                                @endif
                            </div>
                        </div>

                        <div class="menu-action">
                            <a href="{{ route('penjual.menu.edit', $menu->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('penjual.menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-card-list"></i>
                </div>
                <h4>Belum ada menu</h4>
                <p>Tambahkan menu pertama seperti nasi ayam suwir, nasi telur balado, minuman, atau menu lain yang dijual di warungmu.</p>
            </div>
        @endif
    </div>
@endsection