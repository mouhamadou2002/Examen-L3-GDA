<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'Kay Dieund') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background: #23272b; color: #fff; }
        .sidebar { min-height: 100vh; background: #1a1d20; }
        .sidebar .nav-link { color: #fff; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background: #007bff; color: #fff; }
        .sidebar .nav-link i { margin-right: 8px; }
        .content-admin { margin-left: 220px; padding: 2rem 1rem 1rem 1rem; }
        @media (max-width: 991px) {
            .sidebar { min-height: auto; }
            .content-admin { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <nav class="sidebar flex-shrink-0 p-3" style="width:220px;">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Admin Kay Dieund</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> Produits
                    @if(isset($ruptureCount) && $ruptureCount > 0)
                        <span class="badge bg-danger ms-1">{{ $ruptureCount }}</span>
                    @endif
                </a></li>
                <li><a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> Catégories</a></li>
                <li>
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="bi bi-bag"></i> Commandes
                        <span class="badge bg-warning ms-1">3</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Utilisateurs
                    </a>
                </li>
            </ul>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light w-100" type="submit">Déconnexion</button>
            </form>
        </nav>
        <div class="content-admin flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html> 