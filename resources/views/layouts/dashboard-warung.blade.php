<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard WarungKu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-wrapper">
        <aside class="sidebar" id="sidebar">
            <div>
                <div class="sidebar-header">
                    <button class="sidebar-toggle" id="sidebarToggle" type="button">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="sidebar-brand">
                        <img src="{{ asset('images/WarungKu-Logo.png') }}" alt="WarungKu">
                        <span>WarungKu</span>
                    </div>
                </div>

                <div class="sidebar-user">
                    <div class="user-avatar">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="user-info">
                        <strong>Dashboard Warung</strong>
                        <small>Pemilik Warung</small>
                    </div>
                </div>

                <nav class="sidebar-menu">
                    <a href="{{ route('penjual.dashboard') }}" class="menu-item {{ request()->routeIs('penjual.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-door"></i>
                        <span>Home Warung</span>
                    </a>

                    <a href="{{ route('penjual.menu') }}" class="menu-item {{ request()->routeIs('penjual.menu') ? 'active' : '' }}">
                        <i class="bi bi-card-list"></i>
                        <span>Kelola Menu</span>
                    </a>

                    <a href="{{ route('penjual.pesanan') }}" class="menu-item {{ request()->routeIs('penjual.pesanan') ? 'active' : '' }}">
                        <i class="bi bi-receipt"></i>
                        <span>Pesanan Masuk</span>
                    </a>

                    <a href="{{ route('penjual.profil') }}" class="menu-item {{ request()->routeIs('penjual.profil') ? 'active' : '' }}">
                        <i class="bi bi-shop-window"></i>
                        <span>Profil Warung</span>
                    </a>
                </nav>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="sidebar-logout">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </aside>

        <main class="dashboard-content">
            <div class="dashboard-topbar">
                <div>
                    <h1>@yield('page-title')</h1>
                    <p>@yield('page-subtitle')</p>
                </div>

                <div class="topbar-profile">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ Auth::user()->name ?? 'Pemilik Warung' }}</span>
                </div>
            </div>

            <div class="dashboard-main">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>
</html>