# Configuration - PNEUMA-SOUCHE

## 📋 Variables d'environnement

### Configuration de base
```env
APP_NAME=PNEUMA-SOUCHE
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
```

### Base de données

#### SQLite (Développement)
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

#### MySQL (Production)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pneumatique
DB_USERNAME=root
DB_PASSWORD=your-password
```

#### PostgreSQL (Production)
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=pneumatique
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

### Logs
```env
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
```

### Cache et Sessions
```env
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### Stockage
```env
FILESYSTEM_DISK=local
```

### Email (Optionnel)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@pneumatique.com"
MAIL_FROM_NAME="PNEUMA-SOUCHE"
```

## 🖼️ Configuration des logos

### Fichiers requis
Placez ces fichiers dans le dossier `public/` :
- `8Ptransit.png`
- `Quifeurou.png`
- `Sesa SA.png`

### Formats supportés
- **PNG** (recommandé)
- **JPG/JPEG**
- **SVG**

### Tailles recommandées
- **Largeur** : 200-300px
- **Hauteur** : 100-150px
- **Résolution** : 72-150 DPI

## 🔧 Configuration DomPDF

### Fichier `config/dompdf.php`
```php
return [
    'default' => [
        'isRemoteEnabled' => true,
        'isHtml5ParserEnabled' => true,
        'isFontSubsettingEnabled' => true,
        'defaultMediaType' => 'screen',
        'defaultPaperSize' => 'a4',
        'defaultPaperOrientation' => 'portrait',
        'defaultFont' => 'DejaVu Sans',
        'dpi' => 96,
        'enableFontSubsetting' => true,
        'fontHeightRatio' => 1.1,
        'isPhpEnabled' => false,
        'isRemoteEnabled' => true,
        'isJavascriptEnabled' => false,
        'isHtml5ParserEnabled' => true,
        'isFontSubsettingEnabled' => true,
    ],
];
```

## 🔔 Configuration des notifications

### Types de notifications
```php
// Dans NotificationService.php
const NOTIFICATION_TYPES = [
    'pneu_created' => ['icon' => 'fas fa-tire', 'color' => 'success'],
    'pneu_updated' => ['icon' => 'fas fa-edit', 'color' => 'info'],
    'pneu_deleted' => ['icon' => 'fas fa-trash', 'color' => 'danger'],
    'vehicule_created' => ['icon' => 'fas fa-car', 'color' => 'success'],
    'maintenance_declared' => ['icon' => 'fas fa-wrench', 'color' => 'warning'],
    'maintenance_validated' => ['icon' => 'fas fa-check', 'color' => 'success'],
    // ... autres types
];
```

## 🎨 Configuration de l'interface

### Couleurs personnalisées
```css
/* Dans resources/css/app.css */
:root {
    --primary-color: #3498db;
    --secondary-color: #2c3e50;
    --success-color: #27ae60;
    --warning-color: #f39c12;
    --danger-color: #e74c3c;
    --info-color: #17a2b8;
}
```

### Personnalisation des logos
```css
/* Dans resources/views/layouts/app.blade.php */
.header-logo-img {
    height: 60px;
    margin: 0 15px;
    filter: brightness(1.1);
    transition: transform 0.3s ease;
}

.header-logo-img:hover {
    transform: scale(1.05);
}
```

## 🔒 Configuration de sécurité

### Middleware
```php
// Dans app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
```

### Rôles et permissions
```php
// Dans app/Models/User.php
const ROLES = [
    'admin' => 'Administrateur',
    'direction' => 'Direction',
    'declarateur' => 'Déclarateur',
    'mecanicien' => 'Mécanicien',
];
```

## 📊 Configuration des statistiques

### Dashboard
```php
// Dans DashboardController.php
private function getStatsMensuelles()
{
    $mois = [];
    $maintenances = [];
    $mutations = [];
    $mouvements = [];

    for ($i = 5; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $mois[] = $date->format('M Y');
        $maintenances[] = Maintenance::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();
        // ... autres statistiques
    }

    return [
        'labels' => $mois,
        'maintenances' => $maintenances,
        'mutations' => $mutations,
        'mouvements' => $mouvements,
    ];
}
```

## 🚀 Configuration de production

### Optimisations
```bash
# Cache de configuration
php artisan config:cache

# Cache des routes
php artisan route:cache

# Cache des vues
php artisan view:cache

# Optimisation autoloader
composer install --optimize-autoloader --no-dev
```

### Variables d'environnement production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

# Base de données production
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=pneumatique_prod
DB_USERNAME=username
DB_PASSWORD=secure-password

# Logs production
LOG_LEVEL=error

# Cache production
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

## 🔧 Configuration des commandes

### Commandes personnalisées
```php
// Dans app/Console/Commands/
class UpdatePneusUsure extends Command
{
    protected $signature = 'pneus:update-usure';
    protected $description = 'Mettre à jour le taux d\'usure des pneus';

    public function handle()
    {
        // Logique de mise à jour
    }
}
```

### Planification des tâches
```php
// Dans app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('pneus:update-usure')
        ->daily()
        ->at('02:00');
}
```

## 📁 Structure des fichiers

### Organisation recommandée
```
public/
├── 8Ptransit.png
├── Quifeurou.png
├── Sesa SA.png
└── favicon.ico

storage/
├── app/
│   └── public/
│       └── maintenances/  # PDF générés
├── logs/
│   └── laravel.log
└── framework/
    ├── cache/
    ├── sessions/
    └── views/

database/
├── database.sqlite
├── migrations/
└── seeders/
```

## 🔍 Configuration du débogage

### Logs de développement
```env
LOG_LEVEL=debug
LOG_CHANNEL=stack
```

### Outils de débogage
```php
// Dans les contrôleurs
\Log::info('Action effectuée', ['user_id' => auth()->id()]);
\Log::error('Erreur détectée', ['error' => $exception->getMessage()]);
```

---

**PNEUMA-SOUCHE** - Configuration v1.0
