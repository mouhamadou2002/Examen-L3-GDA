<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Kay Dieund')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('shop.index') }}">Kay Dieund</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}">Boutique</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop.cart') }}">Mon panier</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop.myOrders') }}">Mes commandes</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Mon compte</a></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link p-0" type="submit">Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mb-5">
        @yield('content')
    </main>
    <footer class="text-center py-3 text-muted bg-white border-top">
        &copy; {{ date('Y') }} Kay Dieund. Tous droits réservés.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 