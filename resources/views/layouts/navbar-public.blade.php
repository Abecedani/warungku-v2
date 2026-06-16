<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top" data-bs-theme="light">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('images/WarungKu-Logo.png') }}" alt="Logo" class="navbar-logo">
            <span>Warung<span class="text-orange">Ku</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('warung.index') }}">Cari Warung</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ Auth::user()->role === 'penjual' ? route('penjual.dashboard') : (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('mahasiswa.dashboard')) }}" class="btn-orange">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-orange">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>