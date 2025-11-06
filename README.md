 HEAD
# pneumasouche
Pneu Manage

# PNEUMA-SOUCHE - Système de Gestion Pneumatique

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 🎯 Vue d'ensemble

**PNEUMA-SOUCHE** est un système de gestion pneumatique complet développé avec Laravel 11 pour les entreprises **8P Transit**, **Quifeurou** et **Sesa SA**.

### ✨ Fonctionnalités principales

- 🏠 **Dashboard** avec statistiques avancées et graphiques
- 🛞 **Gestion des pneus** avec suivi d'usure automatique
- 🚗 **Gestion des véhicules** et associations
- 🔄 **Mutations** de pneus entre véhicules
- 🚛 **Mouvements** avec calcul automatique du kilométrage
- 🔧 **Maintenances** avec workflow complet et génération de PDF
- 👥 **Utilisateurs** avec système de rôles (Admin, Direction, Déclarateur, Mécanicien)
- 🔔 **Notifications** en temps réel
- 📄 **PDF officiels** avec tampon d'approbation

## 🚀 Installation rapide

### Prérequis
- PHP 8.2+
- Composer
- SQLite (ou MySQL/PostgreSQL)
- Node.js et NPM

### Installation
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

L'application sera accessible sur `http://127.0.0.1:8000`

## 📚 Documentation

- 📖 **[Documentation Technique](DOCUMENTATION.md)** - Architecture, API, base de données
- 👤 **[Guide Utilisateur](GUIDE_UTILISATEUR.md)** - Utilisation des fonctionnalités
- 🔧 **[Guide Administrateur](GUIDE_ADMINISTRATEUR.md)** - Administration et maintenance

## 🏗️ Architecture

### Technologies utilisées
- **Backend** : Laravel 11, PHP 8.2+
- **Frontend** : Blade, Bootstrap 5, Font Awesome
- **Base de données** : SQLite (développement), MySQL/PostgreSQL (production)
- **PDF** : DomPDF
- **Assets** : Vite, NPM

### Structure
```
app/
├── Http/Controllers/     # Contrôleurs MVC
├── Models/              # Modèles Eloquent
├── Services/            # Services métier
└── Console/Commands/    # Commandes Artisan

resources/
├── views/              # Vues Blade
├── css/               # Styles CSS
└── js/                # JavaScript

database/
├── migrations/         # Migrations
├── seeders/           # Seeders
└── database.sqlite    # Base SQLite
```

## 🔐 Système de rôles

| Rôle | Permissions |
|------|-------------|
| **Administrateur** | Accès complet, gestion utilisateurs |
| **Direction** | Validation maintenances, consultation |
| **Déclarateur** | Déclaration maintenances, consultation |
| **Mécanicien** | Finalisation maintenances, consultation |

## 🛠️ Commandes utiles

```bash
# Développement
php artisan serve
php artisan migrate:fresh --seed

# Maintenance
php artisan cache:clear
php artisan config:cache
php artisan storage:link

# Surveillance
php artisan migrate:status
tail -f storage/logs/laravel.log
```

## 📊 Fonctionnalités clés

### Dashboard
- Statistiques globales (pneus, véhicules, maintenances, etc.)
- Top 5 des pneus les plus usés
- Top 5 des véhicules les plus utilisés
- Activités récentes et graphiques mensuels

### Gestion des pneus
- CRUD complet avec suivi d'usure
- Calcul automatique basé sur les mouvements
- Association aux véhicules et fournisseurs
- Notifications des actions

### Workflow des maintenances
1. **Déclaration** par le déclarateur
2. **Validation** par le déclarateur (bon de maintenance)
3. **Approbation** par la direction (génération PDF)
4. **Finalisation** par le mécanicien

### Génération de PDF
- Design professionnel avec logos des entreprises
- Tampon officiel "APPROUVÉE" avec date
- Accès restreint aux déclarateurs
- Téléchargement et visualisation

## 🔒 Sécurité

- Authentification avec sessions sécurisées
- Protection CSRF sur tous les formulaires
- Système de rôles et permissions
- Validation stricte des données
- Logs d'audit pour toutes les actions

## 🚀 Déploiement

### Production
```bash
# Configuration
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

# Optimisations
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### Serveur web
- Apache/Nginx avec PHP-FPM
- SSL/HTTPS obligatoire
- Permissions correctes sur `storage/` et `bootstrap/cache/`

## 📞 Support

### Contact
- **Email** : support@pneumatique.com
- **Documentation** : Voir les fichiers de documentation
- **Issues** : Utiliser le système de tickets

### Contribution
1. Fork le projet
2. Créer une branche feature
3. Commiter les changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

**PNEUMA-SOUCHE** v1.0 - Système de Gestion Pneumatique  
Développé avec ❤️ en Laravel 11 pour 8P Transit, Quifeurou et Sesa SA
 8b523e3 (Initial commit)
