<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('page-title', 'Dashboard Mahasiswa') - WarungKu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- [PERUBAHAN] Font yang dipakai dashboard.css --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- [PERUBAHAN] Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- [PERUBAHAN] Panggil CSS dashboard yang sudah ada --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <div>
                <div class="sidebar-header">
                    <button class="sidebar-toggle" type="button">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="sidebar-brand">
                        <i class="bi bi-bag-heart-fill" style="color: var(--orange); font-size: 28px;"></i>
                        <span>WarungKu</span>
                    </div>
                </div>

                <div class="sidebar-user">
                    <div class="user-avatar">
                        <i class="bi bi-person"></i>
                    </div>

                    <div class="user-info">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small>Mahasiswa</small>
                    </div>
                </div>

                <nav class="sidebar-menu">
                    <a href="{{ route('mahasiswa.dashboard') }}"
                       class="menu-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('mahasiswa.pendaftaran') }}"
                       class="menu-item {{ request()->routeIs('mahasiswa.pendaftaran') ? 'active' : '' }}">
                        <i class="bi bi-person-vcard"></i>
                        <span>Pendaftaran Mahasiswa</span>
                    </a>

                    <a href="{{ route('mahasiswa.pesan') }}"
                       class="menu-item {{ request()->routeIs('mahasiswa.pesan*') ? 'active' : '' }}">
                        <i class="bi bi-basket"></i>
                        <span>Pesan Makanan</span>
                    </a>

                    <a href="{{ route('mahasiswa.pesanan') }}"
                       class="menu-item {{ request()->routeIs('mahasiswa.pesanan*') ? 'active' : '' }}">
                        <i class="bi bi-receipt"></i>
                        <span>Pesanan Saya</span>
                    </a>

                    <a href="{{ route('mahasiswa.riwayat') }}"
                       class="menu-item {{ request()->routeIs('mahasiswa.riwayat') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                        <span>Riwayat Pesanan</span>
                    </a>

                    <a href="{{ route('mahasiswa.profil') }}"
                       class="menu-item {{ request()->routeIs('mahasiswa.profil*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i>
                        <span>Profil Mahasiswa</span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="logout-button">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="dashboard-content">
            <header class="dashboard-topbar">
                <div>
                    <h1>@yield('page-title', 'Dashboard Mahasiswa')</h1>
                    <p>@yield('page-subtitle', 'Kelola aktivitas pemesanan makananmu')</p>
                </div>

                <div class="topbar-profile">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </header>

            <main class="dashboard-main">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // [PERUBAHAN] Toggle sidebar mengikuti class CSS yang sudah ada
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
            });
        }
    </script>
</body>
</html>