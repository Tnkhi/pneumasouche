<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PNEUMA-SOUCHE')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .badge {
            font-size: 0.75em;
        }
        .progress {
            height: 1rem;
        }
        .header-logos {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 0;
            border-bottom: 3px solid #5a67d8;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: box-shadow 0.3s ease;
        }
        .header-logo-img {
            height: 50px;
            width: auto;
            max-width: 130px;
            object-fit: contain;
            margin: 0 20px;
            transition: transform 0.3s ease;
            filter: brightness(1.1) contrast(1.1);
        }
        .header-logo-img:hover {
            transform: scale(1.08);
            filter: brightness(1.2) contrast(1.2);
        }
        .app-title {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 1px;
            margin: 0 30px;
            text-transform: uppercase;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }
        .app-title::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -10px;
            right: -10px;
            bottom: -5px;
            background: linear-gradient(45deg, rgba(255,215,0,0.2), rgba(255,237,78,0.2));
            border-radius: 10px;
            z-index: -1;
        }
        .app-subtitle {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            color: #e2e8f0;
            text-align: center;
            margin-top: 5px;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }
        .tire-icon {
            font-size: 2.5rem;
            color: #ffd700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin: 0 25px;
            transition: transform 0.3s ease;
        }
        .tire-icon:hover {
            transform: rotate(15deg) scale(1.1);
        }
        .navbar {
            position: sticky;
            top: 77px; /* Hauteur de la section logos */
            z-index: 1020;
            transition: box-shadow 0.3s ease;
        }
        body {
            padding-top: 0; /* Pas de padding-top car on utilise sticky */
        }
    </style>
</head>
<body>
    <!-- Section des logos -->
    <div class="header-logos">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logos de gauche -->
                <div class="d-flex align-items-center">
                    <img src="{{ asset('8Ptransit.png') }}" alt="8P Transit" class="header-logo-img">
                    <img src="{{ asset('Quifeurou.png') }}" alt="Quifeurou" class="header-logo-img">
                    <img src="{{ asset('Sesa SA.png') }}" alt="Sesa SA" class="header-logo-img">
                </div>
                
                <!-- Titre central -->
                <div class="text-center">
                    <div class="app-title">PNEUMA-SOUCHE</div>
                    <div class="app-subtitle">Système de Gestion Pneumatique</div>
                </div>
                
                <!-- Logos de droite -->
                <div class="d-flex align-items-center">
                    <img src="{{ asset('8Ptransit.png') }}" alt="8P Transit" class="header-logo-img">
                    <img src="{{ asset('Quifeurou.png') }}" alt="Quifeurou" class="header-logo-img">
                    <img src="{{ asset('Sesa SA.png') }}" alt="Sesa SA" class="header-logo-img">
                    <i class="fas fa-tire tire-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
                    <a class="navbar-brand {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt text-warning"></i> Dashboard
                    </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pneus.*') ? 'active' : '' }}" href="{{ route('pneus.index') }}">
                            <i class="fas fa-tire"></i> Pneus
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vehicules.*') ? 'active' : '' }}" href="{{ route('vehicules.index') }}">
                            <i class="fas fa-car"></i> Véhicules
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fournisseurs.*') ? 'active' : '' }}" href="{{ route('fournisseurs.index') }}">
                            <i class="fas fa-truck"></i> Fournisseurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mutations.*') ? 'active' : '' }}" href="{{ route('mutations.index') }}">
                            <i class="fas fa-exchange-alt"></i> Mutations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mouvements.*') ? 'active' : '' }}" href="{{ route('mouvements.index') }}">
                            <i class="fas fa-route"></i> Mouvements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('maintenances.*') ? 'active' : '' }}" href="{{ route('maintenances.index') }}">
                            <i class="fas fa-wrench"></i> Maintenances
                        </a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('alertes.*') ? 'active' : '' }}" href="{{ route('alertes.index') }}">
                        <i class="fas fa-exclamation-triangle"></i> Alertes
                    </a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                            <i class="fas fa-bell"></i> Notifications
                            @php
                                $notificationsNonLues = \App\Models\Notification::nonLues()->count();
                            @endphp
                            @if($notificationsNonLues > 0)
                                <span class="badge bg-danger ms-1">{{ $notificationsNonLues }}</span>
                            @endif
                        </a>
                    </li>
                    @if(auth()->user() && auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <i class="fas fa-users"></i> Utilisateurs
                            </a>
                        </li>
                    @endif
                </ul>
                
                <!-- Menu utilisateur -->
                @auth
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                                <span class="badge bg-{{ auth()->user()->role_color }} ms-1">{{ auth()->user()->role_name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Connexion
                            </a>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
