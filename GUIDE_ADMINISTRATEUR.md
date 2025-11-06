# PNEUMA-SOUCHE - Guide Administrateur

## 📋 Table des matières
1. [Rôles et Permissions](#rôles-et-permissions)
2. [Gestion des Utilisateurs](#gestion-des-utilisateurs)
3. [Configuration du Système](#configuration-du-système)
4. [Maintenance et Surveillance](#maintenance-et-surveillance)
5. [Sauvegarde et Restauration](#sauvegarde-et-restauration)
6. [Sécurité](#sécurité)
7. [Dépannage](#dépannage)

## 👥 Rôles et Permissions

### Hiérarchie des rôles

#### 1. Administrateur
**Permissions complètes** :
- ✅ Créer, modifier, supprimer tous les éléments
- ✅ Gérer les utilisateurs
- ✅ Accéder à toutes les fonctionnalités
- ✅ Voir toutes les statistiques
- ✅ Gérer les notifications

#### 2. Direction
**Permissions de validation** :
- ✅ Consulter tous les éléments
- ✅ Valider/rejeter les maintenances
- ✅ Voir les statistiques
- ✅ Accéder aux PDF de validation
- ❌ Modifier/supprimer les données

#### 3. Déclarateur
**Permissions de déclaration** :
- ✅ Consulter tous les éléments
- ✅ Déclarer des maintenances
- ✅ Valider ses propres déclarations
- ✅ Télécharger les PDF de validation
- ❌ Modifier les données existantes

#### 4. Mécanicien
**Permissions de maintenance** :
- ✅ Consulter les maintenances
- ✅ Finaliser les maintenances validées
- ✅ Consulter les pneus et véhicules
- ❌ Déclarer ou valider des maintenances

### Matrice des permissions

| Action | Admin | Direction | Déclarateur | Mécanicien |
|--------|-------|-----------|-------------|------------|
| Créer Pneu | ✅ | ❌ | ❌ | ❌ |
| Modifier Pneu | ✅ | ❌ | ❌ | ❌ |
| Supprimer Pneu | ✅ | ❌ | ❌ | ❌ |
| Créer Véhicule | ✅ | ❌ | ❌ | ❌ |
| Créer Fournisseur | ✅ | ❌ | ❌ | ❌ |
| Effectuer Mutation | ✅ | ❌ | ❌ | ❌ |
| Enregistrer Mouvement | ✅ | ❌ | ❌ | ❌ |
| Déclarer Maintenance | ✅ | ❌ | ✅ | ❌ |
| Valider Maintenance | ✅ | ✅ | ✅ | ❌ |
| Finaliser Maintenance | ✅ | ❌ | ❌ | ✅ |
| Gérer Utilisateurs | ✅ | ❌ | ❌ | ❌ |
| Voir Statistiques | ✅ | ✅ | ✅ | ✅ |

## 👤 Gestion des Utilisateurs

### Créer un utilisateur
1. Accédez à "Utilisateurs" dans le menu
2. Cliquez sur "Créer un utilisateur"
3. Remplissez le formulaire :
   - **Nom** : Nom complet de l'utilisateur
   - **Email** : Adresse email unique
   - **Mot de passe** : Mot de passe sécurisé (minimum 8 caractères)
   - **Rôle** : Sélectionnez le rôle approprié
4. Cliquez sur "Créer"

### Modifier un utilisateur
1. Cliquez sur l'icône "Modifier" (crayon)
2. Modifiez les informations nécessaires
3. **Important** : Ne modifiez le rôle qu'en cas de nécessité
4. Cliquez sur "Mettre à jour"

### Supprimer un utilisateur
1. Cliquez sur l'icône "Supprimer" (croix)
2. **Attention** : Cette action est irréversible
3. Confirmez la suppression

### Bonnes pratiques
- **Mots de passe** : Encouragez l'utilisation de mots de passe forts
- **Rôles** : Attribuez le rôle le plus restrictif possible
- **Audit** : Surveillez les actions des utilisateurs via les notifications
- **Désactivation** : Supprimez les comptes inactifs

## ⚙️ Configuration du Système

### Paramètres de l'application

#### Configuration de base
```env
APP_NAME=PNEUMA-SOUCHE
APP_URL=http://127.0.0.1:8000
APP_ENV=local
APP_DEBUG=true
```

#### Base de données
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

#### Stockage des fichiers
```env
FILESYSTEM_DISK=local
```

### Configuration des logos
1. Placez les fichiers PNG dans le dossier `public/`
2. Noms requis :
   - `8Ptransit.png`
   - `Quifeurou.png`
   - `Sesa SA.png`
3. Redémarrez l'application si nécessaire

### Configuration des notifications
- **Types** : Automatiquement configurés
- **Couleurs** : Personnalisables dans `NotificationService`
- **Icônes** : Utilisation de Font Awesome

## 🔧 Maintenance et Surveillance

### Commandes de maintenance

#### Vider les caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### Optimiser l'application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

#### Vérifier l'état de la base de données
```bash
php artisan migrate:status
php artisan db:show
```

### Surveillance des logs

#### Localisation des logs
- **Fichier principal** : `storage/logs/laravel.log`
- **Logs d'erreur** : Vérifiez les erreurs 500
- **Logs de sécurité** : Surveillez les tentatives de connexion

#### Commandes de surveillance
```bash
# Suivre les logs en temps réel
tail -f storage/logs/laravel.log

# Vider les logs
php artisan log:clear

# Vérifier les erreurs récentes
grep "ERROR" storage/logs/laravel.log | tail -20
```

### Surveillance des performances

#### Métriques à surveiller
- **Temps de réponse** : < 2 secondes pour les pages
- **Utilisation mémoire** : < 128MB par requête
- **Taille base de données** : Surveiller la croissance
- **Espace disque** : Surveiller le stockage des PDF

#### Outils de surveillance
- **Logs Laravel** : Erreurs et performances
- **Base de données** : Requêtes lentes
- **Serveur web** : Logs d'accès et erreurs

## 💾 Sauvegarde et Restauration

### Sauvegarde de la base de données

#### Sauvegarde SQLite
```bash
# Copie simple
cp database/database.sqlite backups/db_backup_$(date +%Y%m%d_%H%M%S).sqlite

# Sauvegarde compressée
tar -czf backups/db_backup_$(date +%Y%m%d_%H%M%S).tar.gz database/database.sqlite
```

#### Sauvegarde MySQL/PostgreSQL
```bash
# MySQL
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# PostgreSQL
pg_dump -U username database_name > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Sauvegarde des fichiers

#### Fichiers de stockage
```bash
# Sauvegarder les PDF et fichiers
tar -czf backups/storage_backup_$(date +%Y%m%d_%H%M%S).tar.gz storage/
```

#### Configuration
```bash
# Sauvegarder la configuration
cp .env backups/env_backup_$(date +%Y%m%d_%H%M%S)
```

### Planification des sauvegardes

#### Script de sauvegarde automatique
```bash
#!/bin/bash
# backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/path/to/backups"

# Créer le dossier de sauvegarde
mkdir -p $BACKUP_DIR

# Sauvegarder la base de données
cp database/database.sqlite $BACKUP_DIR/db_backup_$DATE.sqlite

# Sauvegarder les fichiers
tar -czf $BACKUP_DIR/storage_backup_$DATE.tar.gz storage/

# Nettoyer les anciennes sauvegardes (garder 30 jours)
find $BACKUP_DIR -name "*.sqlite" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete

echo "Sauvegarde terminée : $DATE"
```

#### Crontab pour automatisation
```bash
# Exécuter tous les jours à 2h du matin
0 2 * * * /path/to/backup.sh
```

### Restauration

#### Restauration de la base de données
```bash
# Arrêter l'application
# Restaurer la base de données
cp backups/db_backup_YYYYMMDD_HHMMSS.sqlite database/database.sqlite
# Redémarrer l'application
```

#### Restauration des fichiers
```bash
# Restaurer les fichiers de stockage
tar -xzf backups/storage_backup_YYYYMMDD_HHMMSS.tar.gz
```

## 🔒 Sécurité

### Authentification et autorisation

#### Bonnes pratiques
- **Mots de passe** : Minimum 8 caractères, complexité requise
- **Sessions** : Expiration automatique après inactivité
- **CSRF** : Protection activée sur tous les formulaires
- **Rôles** : Principe du moindre privilège

#### Surveillance de sécurité
- **Tentatives de connexion** : Surveiller les échecs répétés
- **Actions sensibles** : Logger les modifications importantes
- **Accès non autorisés** : Surveiller les tentatives d'accès

### Protection des données

#### Chiffrement
- **Mots de passe** : Hachage bcrypt
- **Sessions** : Chiffrement des données de session
- **Fichiers sensibles** : Protection des PDF

#### Validation des données
- **Entrées utilisateur** : Validation stricte
- **Upload de fichiers** : Vérification des types
- **Injection SQL** : Protection par Eloquent ORM

### Audit et conformité

#### Journalisation
- **Actions utilisateurs** : Toutes les actions sont loggées
- **Modifications** : Historique des changements
- **Accès** : Logs de connexion et déconnexion

#### Conformité RGPD
- **Données personnelles** : Minimisation des données collectées
- **Droit à l'effacement** : Possibilité de suppression
- **Portabilité** : Export des données utilisateur

## 🚨 Dépannage

### Problèmes courants

#### Erreur 500 - Erreur serveur
1. **Vérifier les logs** : `storage/logs/laravel.log`
2. **Vérifier les permissions** : `storage/` et `bootstrap/cache/`
3. **Vider les caches** : `php artisan cache:clear`
4. **Vérifier la configuration** : `.env` et `config/`

#### Erreur 404 - Page non trouvée
1. **Vérifier les routes** : `php artisan route:list`
2. **Vérifier les permissions** : Accès utilisateur
3. **Vérifier l'URL** : Format correct

#### Problème de base de données
1. **Vérifier la connexion** : `php artisan migrate:status`
2. **Vérifier les migrations** : `php artisan migrate`
3. **Vérifier les permissions** : Fichier de base de données

#### Problème de stockage
1. **Vérifier le lien symbolique** : `php artisan storage:link`
2. **Vérifier les permissions** : Dossier `storage/`
3. **Vérifier l'espace disque** : Espace disponible

### Commandes de diagnostic

#### Vérification de l'état
```bash
# État général
php artisan about

# Vérification des routes
php artisan route:list

# Vérification des migrations
php artisan migrate:status

# Vérification du cache
php artisan cache:table
```

#### Réparation
```bash
# Réparer les caches
php artisan optimize:clear
php artisan optimize

# Réparer les permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Réparer la base de données
php artisan migrate:fresh --seed
```

### Support et assistance

#### Informations à collecter
- **Version PHP** : `php -v`
- **Version Laravel** : `php artisan --version`
- **Logs d'erreur** : `storage/logs/laravel.log`
- **Configuration** : `.env` (sans les mots de passe)
- **Description du problème** : Étapes pour reproduire

#### Escalade
1. **Niveau 1** : Vérification des logs et configuration
2. **Niveau 2** : Redémarrage et réparation
3. **Niveau 3** : Restauration depuis sauvegarde
4. **Niveau 4** : Support technique externe

---

**PNEUMA-SOUCHE** - Guide Administrateur v1.0
