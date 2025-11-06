<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PNEUMA-SOUCHE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .login-body {
            padding: 2rem;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .test-users {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }
        .test-user-btn {
            margin: 0.25rem;
            font-size: 0.8rem;
        }
        .logo-img {
            height: 50px;
            width: auto;
            max-width: 100px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.1);
            padding: 5px;
            border-radius: 5px;
            margin: 0 5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .logo-carousel {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            width: 100%;
            height: 80px;
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            margin: 10px 0;
        }
        
        .logo-slide {
            display: flex;
            animation: slideLogos 20s linear infinite;
            white-space: nowrap;
        }
        
        .logo-slide:hover {
            animation-play-state: paused;
        }
        
        @keyframes slideLogos {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        
        .logo-item {
            flex-shrink: 0;
            margin: 0 15px;
            animation: logoFloat 4s ease-in-out infinite;
            transition: all 0.3s ease;
        }
        
        .logo-item:hover {
            transform: scale(1.2) rotate(5deg);
            z-index: 10;
        }
        
        .logo-item:nth-child(1) { animation-delay: 0s; }
        .logo-item:nth-child(2) { animation-delay: 0.7s; }
        .logo-item:nth-child(3) { animation-delay: 1.4s; }
        .logo-item:nth-child(4) { animation-delay: 2.1s; }
        .logo-item:nth-child(5) { animation-delay: 2.8s; }
        .logo-item:nth-child(6) { animation-delay: 3.5s; }
        .logo-item:nth-child(7) { animation-delay: 4.2s; }
        .logo-item:nth-child(8) { animation-delay: 4.9s; }
        .logo-item:nth-child(9) { animation-delay: 5.6s; }
        
        @keyframes logoFloat {
            0%, 100% {
                opacity: 0.6;
                transform: translateY(0px) scale(1);
                filter: brightness(0.8);
            }
            25% {
                opacity: 0.8;
                transform: translateY(-5px) scale(1.05);
                filter: brightness(1);
            }
            50% {
                opacity: 1;
                transform: translateY(-8px) scale(1.1);
                filter: brightness(1.2);
            }
            75% {
                opacity: 0.8;
                transform: translateY(-5px) scale(1.05);
                filter: brightness(1);
            }
        }
        
        /* Effet de brillance sur les logos */
        
        .logo-img::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shine 3s ease-in-out infinite;
        }
        
        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
            50% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
            100% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
        }
        .app-title-login {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 1px;
            text-transform: uppercase;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 10px 0;
        }
        .app-subtitle-login {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            color: #e2e8f0;
            margin-bottom: 0;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }
        .tire-icon-login {
            font-size: 2rem;
            color: #ffd700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <!-- Logos des entreprises avec animation -->
            <div class="logo-carousel mb-3">
                <div class="logo-slide">
                    <div class="logo-item">
                        <img src="{{ asset('8Ptransit.png') }}" alt="8P Transit" class="logo-img">
                    </div>
                    <div class="logo-item">
                        <img src="{{ asset('Quifeurou.png') }}" alt="Quifeurou" class="logo-img">
                    </div>
                    <div class="logo-item">
                        <img src="{{ asset('Sesa SA.png') }}" alt="Sesa SA" class="logo-img">
                    </div>
                    <div class="logo-item">
                        <img src="{{ asset('8Ptransit.png') }}" alt="8P Transit" class="logo-img">
                    </div>
                    <div class="logo-item">
                        <img src="{{ asset('Quifeurou.png') }}" alt="Quifeurou" class="logo-img">
                    </div>
                    <div class="logo-item">
                        <img src="{{ asset('Sesa SA.png') }}" alt="Sesa SA" class="logo-img">
                    </div>
                    <!-- Duplication pour l'effet de boucle infinie -->
                    <div class="logo-item">
                        <img src="{{ asset('8Ptransit.png') }}" alt="8P Transit" class="logo-img">
                    </div>
                    <div class="logo-item">
                        <img src="{{ asset('Quifeurou.png') }}" alt="Quifeurou" class="logo-img">
                    </div>
                    <div class="logo-item">
                        <img src="{{ asset('Sesa SA.png') }}" alt="Sesa SA" class="logo-img">
                    </div>
                </div>
            </div>
            
            <!-- Titre de l'application -->
            <div class="text-center">
                <div class="app-title-login">PNEUMA-SOUCHE</div>
                <div class="app-subtitle-login">Système de Gestion Pneumatique</div>
                <div class="mt-2">
                    <i class="fas fa-tire tire-icon-login"></i>
                </div>
            </div>
        </div>
        
        <div class="login-body">
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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Adresse Email
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           placeholder="votre@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Mot de passe
                    </label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           required
                           placeholder="Votre mot de passe">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>

            <!-- Utilisateurs de test -->
            <div class="test-users">
                <h6 class="text-muted mb-2">
                    <i class="fas fa-users"></i> Utilisateurs de test
                </h6>
                <div class="d-flex flex-wrap">
                    <button type="button" class="btn btn-outline-primary btn-sm test-user-btn" 
                            onclick="fillCredentials('admin@pneumatique.com', 'password')">
                        <i class="fas fa-crown"></i> Admin
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm test-user-btn" 
                            onclick="fillCredentials('direction@pneumatique.com', 'password')">
                        <i class="fas fa-user-tie"></i> Direction
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm test-user-btn" 
                            onclick="fillCredentials('declarateur@pneumatique.com', 'password')">
                        <i class="fas fa-clipboard-check"></i> Déclarateur
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm test-user-btn" 
                            onclick="fillCredentials('mecanicien@pneumatique.com', 'password')">
                        <i class="fas fa-wrench"></i> Mécanicien
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>