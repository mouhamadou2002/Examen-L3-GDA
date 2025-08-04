<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Kay Dieund') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 py-2">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="{{ route('shop.index') }}">
            <i class="bi bi-cart3" style="font-size: 2rem;"></i>
            <span class="ms-2">Kay Dieund</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto align-items-center gap-2">
            <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}">Boutique</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Catégories
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategories">
                @foreach($allCategories as $cat)
                  <li><a class="dropdown-item" href="{{ route('shop.index', ['category' => $cat->id]) }}">{{ $cat->name }}</a></li>
                @endforeach
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('shop.cart') }}"><i class="bi bi-bag"></i> Mon panier</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('shop.myOrders') }}"><i class="bi bi-receipt"></i> Mes commandes</a></li>
            <li class="nav-item position-relative">
              <a class="nav-link position-relative" href="{{ route('shop.myOrders') }}">
                <i class="bi bi-bell"></i>
            @auth
                  @php $notifCount = auth()->user()->unreadNotifications->count(); @endphp
                  @if($notifCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $notifCount }}</span>
              @endif
            @endauth
              </a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto align-items-center gap-2">
            @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownProfile">
                  <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mon compte</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                      @csrf
                      <button class="dropdown-item text-danger" type="submit">Déconnexion</button>
                    </form>
                  </li>
                </ul>
              </li>
            @else
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
            @endauth
          </ul>
          <form class="d-flex ms-3" action="{{ route('shop.index') }}" method="get" role="search" style="min-width:220px;">
            <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Rechercher..." value="{{ request('search') }}" aria-label="Rechercher">
            <button class="btn btn-outline-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </div>
    </nav>
    <div class="container mb-4">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
