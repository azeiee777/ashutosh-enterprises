<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Ashutosh Admin</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%23F59E0B'/%3E%3Ctext x='50%25' y='55%25' dominant-baseline='middle' text-anchor='middle' fill='%230F172A' font-family='Arial' font-weight='bold' font-size='18'%3EA%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        {{-- Mobile Overlay --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        {{-- Sidebar --}}
        <aside class="admin-sidebar" id="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <div class="brand-icon">AE</div>
                <div class="brand-text" style="display: flex; flex-direction: column; line-height: 1;">
                    <span>Ashutosh</span>
                    <small style="font-size: 0.55em; font-weight: 500; opacity: 0.7; letter-spacing: 1px; text-transform: uppercase;">Enterprises</small>
                </div>
            </a>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> <span class="nav-text">Dashboard</span>
                </a>

                <div class="sidebar-section-title">Management</div>
                <a href="{{ route('admin.clients.index') }}" class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                    <i class="bi bi-buildings"></i> <span class="nav-text">Clients</span>
                </a>
                <a href="{{ route('admin.sites.index') }}" class="nav-link {{ request()->routeIs('admin.sites.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt"></i> <span class="nav-text">Sites</span>
                </a>

                <div class="sidebar-section-title">Operations</div>
                <a href="{{ route('admin.labour-supply.index') }}" class="nav-link {{ request()->routeIs('admin.labour-supply.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> <span class="nav-text">Labour Supply</span>
                </a>
                <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> <span class="nav-text">Payments</span>
                </a>
                <a href="{{ route('admin.expenses.index') }}" class="nav-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> <span class="nav-text">Expenses</span>
                </a>

                <div class="sidebar-section-title">Analytics</div>
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i> <span class="nav-text">Reports</span>
                </a>

                <div class="sidebar-section-title">Settings</div>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> <span class="nav-text">Users</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> <span class="nav-text">Settings</span>
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="admin-main">
            {{-- Header --}}
            <header class="admin-header">
                <div class="header-left">
                    <button id="sidebarToggle" title="Toggle sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-none d-md-block">
                        <small class="text-muted">@yield('breadcrumb', 'Dashboard')</small>
                    </div>
                </div>

                <div class="header-search d-none d-lg-block">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="globalSearch" placeholder="Search clients, sites, payments..." autocomplete="off">
                    <div id="searchResults" class="search-results"></div>
                </div>

                <div class="header-right">
                    <button class="header-btn" id="themeToggle" title="Toggle theme">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                    <button class="header-btn" title="Notifications">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge"></span>
                    </button>
                    <div class="dropdown">
                        <div class="user-menu" data-bs-toggle="dropdown">
                            <div class="user-avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
                            <span class="user-name d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <i class="bi bi-chevron-down" style="font-size: 0.7rem;"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.users.edit', auth()->user()->id) }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Toast Notifications --}}
    <div class="toast-container">
        @if(session('success'))
            <div class="toast" role="alert" data-bs-autohide="true" data-bs-delay="4000">
                <div class="toast-header bg-success text-white">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong class="me-auto">Success</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="toast" role="alert" data-bs-autohide="true" data-bs-delay="5000">
                <div class="toast-header bg-danger text-white">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">{{ session('error') }}</div>
            </div>
        @endif
    </div>

    @stack('scripts')
</body>
</html>
