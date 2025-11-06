# PNEUMA-SOUCHE - Documentation Technique

## 📋 Table des matières
1. [Vue d'ensemble](#vue-densemble)
2. [Installation](#installation)
3. [Architecture](#architecture)
4. [Modules](#modules)
5. [Base de données](#base-de-données)
6. [API et Routes](#api-et-routes)
7. [Sécurité](#sécurité)
8. [Déploiement](#déploiement)

## 🎯 Vue d'ensemble

**PNEUMA-SOUCHE** est un système de gestion pneumatique complet développé avec Laravel 11 pour les entreprises 8P Transit, Quifeurou et Sesa SA.

### Fonctionnalités principales
- 🏠 **Dashboard** avec statistiques avancées
- 🛞 **Gestion des pneus** avec suivi d'usure
- 🚗 **Gestion des véhicules** et associations
- 🔄 **Mutations** entre véhicules
- 🚛 **Mouvements** et calcul de kilométrage
- 🔧 **Maintenances** avec workflow complet
- 👥 **Utilisateurs** avec système de rôles
- 🔔 **Notifications** en temps réel
- 📄 **Génération de PDF** avec tampon officiel

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- SQLite/MySQL/PostgreSQL
- Node.js et NPM

### Étapes
```bash
# 1. Cloner et installer
git clone [repo-url]
cd Pneumatique
composer install
npm install

# 2. Configuration
cp .env.example .env
php artisan key:generate

# 3. Base de données
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# 4. Assets et stockage
php artisan storage:link
npm run build

# 5. Démarrer
php artisan serve
```

## 🏗️ Architecture

### Structure MVC
```
app/
├── Http/Controllers/     # Contrôleurs
├── Models/              # Modèles Eloquent
├── Services/            # Services métier
└── Console/Commands/    # Commandes Artisan

resources/
├── views/              # Vues Blade
├── css/               # Styles
└── js/                # JavaScript

database/
├── migrations/         # Migrations
├── seeders/           # Seeders
└── database.sqlite    # Base SQLite
```

### Design Patterns
- **Repository Pattern** : Accès aux données
- **Service Layer** : Logique métier
- **Observer Pattern** : Notifications
- **Factory Pattern** : Création d'objets

## 📦 Modules

### 1. Dashboard
**Contrôleur** : `DashboardController`
**Fonctionnalités** :
- Statistiques globales (pneus, véhicules, maintenances, etc.)
- Top 5 des pneus les plus usés
- Top 5 des véhicules les plus utilisés
- Activités récentes
- Graphiques mensuels

### 2. Pneus
**Contrôleur** : `PneuController`
**Modèle** : `Pneu`
**Relations** :
- `belongsTo(Vehicule::class)`
- `belongsTo(Fournisseur::class)`

**Fonctionnalités** :
- CRUD complet
- Suivi kilométrage et usure
- Calcul automatique basé sur mouvements
- Notifications des actions

### 3. Véhicules
**Contrôleur** : `VehiculeController`
**Modèle** : `Vehicule`
**Relations** :
- `hasMany(Pneu::class)`
- `hasMany(Mouvement::class)`

### 4. Fournisseurs
**Contrôleur** : `FournisseurController`
**Modèle** : `Fournisseur`
**Relations** :
- `hasMany(Pneu::class)`

### 5. Mutations
**Contrôleur** : `MutationController`
**Modèle** : `Mutation`
**Fonctionnalités** :
- Transfert de pneus entre véhicules
- Mise à jour automatique des associations
- Notifications des mutations

### 6. Mouvements
**Contrôleur** : `MouvementController`
**Modèle** : `Mouvement`
**Fonctionnalités** :
- Enregistrement des déplacements
- Calcul automatique du kilométrage des pneus
- Mise à jour en temps réel de l'usure

### 7. Maintenances
**Contrôleur** : `MaintenanceController`
**Modèle** : `Maintenance`
**Workflow** :
1. Déclaration
2. Validation déclarateur
3. Validation direction
4. Finalisation

**Fonctionnalités** :
- Génération automatique de PDF
- Tampon officiel avec "APPROUVÉE"
- Suivi des étapes
- Accès restreint par rôle

### 8. Utilisateurs
**Contrôleur** : `UserController`
**Modèle** : `User`
**Rôles** :
- `admin` : Accès complet
- `declarateur` : Déclaration et consultation
- `mecanicien` : Maintenance et consultation
- `direction` : Validation et consultation

### 9. Notifications
**Contrôleur** : `NotificationController`
**Service** : `NotificationService`
**Fonctionnalités** :
- Notifications en temps réel
- Marquage lu/non lu
- Suppression des notifications lues
- Badge de compteur

## 🗄️ Base de données

### Tables principales

#### `users`
```sql
id, name, email, password, role, created_at, updated_at
```

#### `fournisseurs`
```sql
id, nom, contact, telephone, email, adresse, statistics, created_at, updated_at
```

#### `vehicules`
```sql
id, immatriculation, marque, modele, type, chauffeur, created_at, updated_at
```

#### `pneus`
```sql
id, numero_serie, marque, modele, dimension, kilometrage, taux_usure, 
vehicule_id, fournisseur_id, created_at, updated_at
```

#### `mutations`
```sql
id, pneu_id, vehicule_source_id, vehicule_destination_id, 
date_mutation, user_id, created_at, updated_at
```

#### `mouvements`
```sql
id, vehicule_id, date_mouvement, distance_parcourue, 
destination, observations, user_id, created_at, updated_at
```

#### `maintenances`
```sql
id, pneu_id, mecanicien_id, declarateur_id, direction_id, 
numero_reference, motif, description, statut, pdf_path, created_at, updated_at
```

#### `notifications`
```sql
id, type, model_type, model_id, title, message, icon, color, 
user_id, data, is_read, read_at, created_at, updated_at
```

## 🛣️ API et Routes

### Routes principales
```php
// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Ressources CRUD
Route::resource('pneus', PneuController::class);
Route::resource('vehicules', VehiculeController::class);
Route::resource('fournisseurs', FournisseurController::class);
Route::resource('mutations', MutationController::class);
Route::resource('mouvements', MouvementController::class);
Route::resource('maintenances', MaintenanceController::class);
Route::resource('users', UserController::class);

// Notifications
Route::resource('notifications', NotificationController::class)
    ->only(['index', 'show', 'destroy']);
Route::post('notifications/{notification}/marquer-comme-lu', 
    [NotificationController::class, 'marquerCommeLu']);
Route::post('notifications/marquer-toutes-comme-lues', 
    [NotificationController::class, 'marquerToutesCommeLues']);
Route::get('notifications/supprimer-lues', 
    [NotificationController::class, 'supprimerLues']);

// PDF
Route::get('maintenances/{maintenance}/download-pdf', 
    [MaintenanceController::class, 'downloadPdf']);
Route::get('maintenances/{maintenance}/view-pdf', 
    [MaintenanceController::class, 'viewPdf']);
```

## 🔒 Sécurité

### Authentification
- Système de connexion avec email/mot de passe
- Sessions sécurisées avec tokens CSRF
- Protection des routes avec middleware

### Autorisation
- Système de rôles : admin, declarateur, mecanicien, direction
- Middleware d'administration pour actions sensibles
- Contrôle d'accès au niveau des contrôleurs

### Protection des données
- Validation des entrées utilisateur
- Échappement des sorties HTML
- Protection CSRF sur tous les formulaires
- Sanitisation des données

## 🚀 Déploiement

### Configuration production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=pneumatique_prod
```

### Optimisations
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### Permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🔧 Maintenance

### Commandes utiles
```bash
# Caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Base de données
php artisan migrate:status
php artisan db:seed --class=SpecificSeeder

# Stockage
php artisan storage:link
php artisan queue:work
```

### Surveillance
- Logs : `storage/logs/laravel.log`
- Performance : Surveiller les temps de réponse
- Base de données : Optimiser les requêtes lentes

---

**PNEUMA-SOUCHE** v1.0 - Système de Gestion Pneumatique
Développé avec Laravel 11
