<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('page-title', 'Dashboard Admin') - WarungKu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- [PERUBAHAN] Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- [PERUBAHAN] Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- [PERUBAHAN] Pakai CSS dashboard yang sudah ada --}}
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
                        <i class="bi bi-shield-check" style="color: var(--orange); font-size: 28px;"></i>
                        <span>WarungKu</span>
                    </div>
                </div>

                <div class="sidebar-user">
                    <div class="user-avatar">
                        <i class="bi bi-person-gear"></i>
                    </div>

                    <div class="user-info">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small>Admin</small>
                    </div>
                </div>

                <nav class="sidebar-menu">
                    <a href="{{ route('admin.dashboard') }}"
                       class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Home Admin</span>
                    </a>

                    <a href="{{ route('admin.verifikasi-warung') }}"
                       class="menu-item {{ request()->routeIs('admin.verifikasi-warung*') ? 'active' : '' }}">
                        <i class="bi bi-patch-check"></i>
                        <span>Verifikasi Warung</span>
                    </a>

                    <a href="{{ route('admin.users') }}"
                       class="menu-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Kelola User</span>
                    </a>

                    <a href="{{ route('admin.warungs') }}"
                       class="menu-item {{ request()->routeIs('admin.warungs*') ? 'active' : '' }}">
                        <i class="bi bi-shop"></i>
                        <span>Kelola Warung</span>
                    </a>
                    <a href="{{ route('admin.profil') }}"
                        class="menu-item {{ request()->routeIs('admin.profil*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i>
                        <span>Profil Admin</span>
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
                    <h1>@yield('page-title', 'Dashboard Admin')</h1>
                    <p>@yield('page-subtitle', 'Kelola data sistem WarungKu')</p>
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