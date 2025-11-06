# PNEUMA-SOUCHE - Guide d'Utilisation

## 📋 Table des matières
1. [Connexion](#connexion)
2. [Dashboard](#dashboard)
3. [Gestion des Pneus](#gestion-des-pneus)
4. [Gestion des Véhicules](#gestion-des-véhicules)
5. [Gestion des Fournisseurs](#gestion-des-fournisseurs)
6. [Mutations](#mutations)
7. [Mouvements](#mouvements)
8. [Maintenances](#maintenances)
9. [Utilisateurs](#utilisateurs)
10. [Notifications](#notifications)

## 🔐 Connexion

### Accès à l'application
1. Ouvrez votre navigateur
2. Accédez à `http://127.0.0.1:8000`
3. Saisissez vos identifiants :
   - **Email** : Votre adresse email
   - **Mot de passe** : Votre mot de passe
4. Cliquez sur "Se connecter"

### Rôles utilisateurs
- **Administrateur** : Accès complet à toutes les fonctionnalités
- **Déclarateur** : Peut déclarer des maintenances et consulter
- **Mécanicien** : Peut effectuer des maintenances et consulter
- **Direction** : Peut valider les maintenances et consulter

## 🏠 Dashboard

### Vue d'ensemble
Le dashboard affiche les statistiques principales de l'application :

#### Cartes de statistiques
- **Total Pneus** : Nombre total de pneus en stock
- **Total Fournisseurs** : Nombre de fournisseurs
- **Total Utilisateurs** : Nombre d'utilisateurs actifs
- **Total Maintenances** : Nombre total de maintenances
- **Total Véhicules** : Nombre de véhicules
- **Total Mutations** : Nombre de mutations effectuées
- **Total Mouvements** : Nombre de mouvements enregistrés
- **Notifications non lues** : Nombre de notifications non lues

#### Statistiques des maintenances
- **Déclarées** : Maintenances en attente de validation
- **En Attente** : Maintenances validées par le déclarateur
- **Validées** : Maintenances approuvées par la direction
- **Terminées** : Maintenances finalisées

#### Top 5
- **Pneus les plus usés** : Pneus avec le taux d'usure le plus élevé
- **Véhicules les plus utilisés** : Véhicules avec le plus de kilométrage

#### Activités récentes
- **Dernières maintenances** : 5 dernières maintenances
- **Dernières mutations** : 5 dernières mutations
- **Derniers mouvements** : 5 derniers mouvements

## 🛞 Gestion des Pneus

### Consulter les pneus
1. Cliquez sur "Pneus" dans le menu
2. La liste affiche tous les pneus avec :
   - Numéro de série
   - Marque et modèle
   - Dimension
   - Kilométrage
   - Taux d'usure
   - Véhicule associé
   - Statut

### Ajouter un pneu (Administrateur uniquement)
1. Cliquez sur "Ajouter un Pneu"
2. Remplissez le formulaire :
   - **Numéro de série** : Identifiant unique
   - **Marque** : Marque du pneu
   - **Modèle** : Modèle du pneu
   - **Dimension** : Taille du pneu (ex: 235/60R18)
   - **Kilométrage** : Kilométrage initial
   - **Taux d'usure** : Pourcentage d'usure
   - **Véhicule** : Véhicule associé
   - **Fournisseur** : Fournisseur du pneu
3. Cliquez sur "Créer"

### Modifier un pneu (Administrateur uniquement)
1. Cliquez sur l'icône "Modifier" (crayon)
2. Modifiez les informations nécessaires
3. Cliquez sur "Mettre à jour"

### Supprimer un pneu (Administrateur uniquement)
1. Cliquez sur l'icône "Supprimer" (croix)
2. Confirmez la suppression

### Consulter un pneu
1. Cliquez sur l'icône "Voir" (œil)
2. Consultez les détails complets du pneu

## 🚗 Gestion des Véhicules

### Consulter les véhicules
1. Cliquez sur "Véhicules" dans le menu
2. La liste affiche :
   - Immatriculation
   - Marque et modèle
   - Type de véhicule
   - Chauffeur
   - Nombre de pneus

### Ajouter un véhicule (Administrateur uniquement)
1. Cliquez sur "Ajouter un Véhicule"
2. Remplissez le formulaire :
   - **Immatriculation** : Numéro d'immatriculation
   - **Marque** : Marque du véhicule
   - **Modèle** : Modèle du véhicule
   - **Type** : Type de véhicule
   - **Chauffeur** : Nom du chauffeur
3. Cliquez sur "Créer"

### Modifier/Supprimer un véhicule
- Procédure similaire aux pneus
- **Note** : Un véhicule ne peut pas être supprimé s'il a des pneus associés

## 🏢 Gestion des Fournisseurs

### Consulter les fournisseurs
1. Cliquez sur "Fournisseurs" dans le menu
2. La liste affiche :
   - Nom du fournisseur
   - Contact
   - Téléphone
   - Email
   - Adresse
   - Nombre de pneus fournis

### Ajouter un fournisseur (Administrateur uniquement)
1. Cliquez sur "Ajouter un Fournisseur"
2. Remplissez le formulaire :
   - **Nom** : Nom de l'entreprise
   - **Contact** : Personne de contact
   - **Téléphone** : Numéro de téléphone
   - **Email** : Adresse email
   - **Adresse** : Adresse complète
3. Cliquez sur "Créer"

## 🔄 Mutations

### Consulter les mutations
1. Cliquez sur "Mutations" dans le menu
2. La liste affiche :
   - Pneu concerné
   - Véhicule source
   - Véhicule destination
   - Date de mutation
   - Utilisateur responsable

### Effectuer une mutation (Administrateur uniquement)
1. Cliquez sur "Effectuer une Mutation"
2. Sélectionnez :
   - **Pneu** : Pneu à muter
   - **Véhicule source** : Véhicule actuel
   - **Véhicule destination** : Nouveau véhicule
   - **Date** : Date de la mutation
3. Cliquez sur "Effectuer la Mutation"

## 🚛 Mouvements

### Consulter les mouvements
1. Cliquez sur "Mouvements" dans le menu
2. La liste affiche :
   - Véhicule
   - Date du mouvement
   - Distance parcourue
   - Destination
   - Utilisateur

### Enregistrer un mouvement (Administrateur uniquement)
1. Cliquez sur "Nouveau Mouvement"
2. Remplissez le formulaire :
   - **Véhicule** : Véhicule concerné
   - **Date** : Date du mouvement
   - **Distance** : Distance parcourue en km
   - **Destination** : Lieu de destination
   - **Observations** : Commentaires éventuels
3. Cliquez sur "Enregistrer"

**Note** : Le kilométrage des pneus du véhicule sera automatiquement mis à jour.

## 🔧 Maintenances

### Consulter les maintenances
1. Cliquez sur "Maintenances" dans le menu
2. La liste affiche :
   - Référence
   - Pneu concerné
   - Statut
   - Étape
   - Mécanicien
   - Date
   - Motif

### Déclarer une maintenance
1. Cliquez sur "Nouvelle Maintenance"
2. Remplissez le formulaire :
   - **Pneu** : Pneu à maintenir
   - **Motif** : Raison de la maintenance
   - **Description** : Description détaillée
3. Cliquez sur "Déclarer"

### Workflow des maintenances

#### 1. Déclaration
- **Qui** : Déclarateur
- **Action** : Déclare la maintenance
- **Statut** : "Déclarée"

#### 2. Validation Déclarateur
- **Qui** : Déclarateur
- **Action** : Ajoute le bon de maintenance
- **Statut** : "En Attente"

#### 3. Validation Direction
- **Qui** : Direction
- **Action** : Approuve ou rejette
- **Statut** : "Validée" ou "Rejetée"
- **PDF** : Génération automatique du PDF avec tampon

#### 4. Finalisation
- **Qui** : Mécanicien
- **Action** : Termine la maintenance
- **Statut** : "Terminée"

### Consulter/Télécharger le PDF
- **Voir PDF** : Ouvre le PDF dans le navigateur
- **Télécharger PDF** : Télécharge le fichier PDF
- **Accès** : Seuls les déclarateurs peuvent accéder au PDF

## 👥 Utilisateurs

### Consulter les utilisateurs (Administrateur uniquement)
1. Cliquez sur "Utilisateurs" dans le menu
2. La liste affiche :
   - Nom
   - Email
   - Rôle
   - Date de création

### Ajouter un utilisateur (Administrateur uniquement)
1. Cliquez sur "Créer un utilisateur"
2. Remplissez le formulaire :
   - **Nom** : Nom complet
   - **Email** : Adresse email
   - **Mot de passe** : Mot de passe
   - **Rôle** : Sélectionnez le rôle
3. Cliquez sur "Créer"

### Modifier/Supprimer un utilisateur
- Procédure similaire aux autres entités
- **Note** : Un administrateur ne peut pas se supprimer lui-même

## 🔔 Notifications

### Consulter les notifications
1. Cliquez sur "Notifications" dans le menu
2. La liste affiche :
   - Titre
   - Message
   - Date
   - Statut (lu/non lu)
   - Type

### Actions sur les notifications
- **Marquer comme lu** : Cliquez sur l'icône œil
- **Marquer toutes comme lues** : Bouton en haut de la liste
- **Supprimer les lues** : Supprime toutes les notifications lues
- **Voir détails** : Cliquez sur le titre

### Types de notifications
- **Pneu créé/modifié/supprimé**
- **Véhicule créé/modifié/supprimé**
- **Fournisseur créé/modifié/supprimé**
- **Mutation effectuée**
- **Mouvement enregistré**
- **Maintenance déclarée/validée/terminée**
- **Utilisateur créé/modifié/supprimé**

## 💡 Conseils d'utilisation

### Bonnes pratiques
1. **Saisie des données** : Vérifiez toujours les informations avant de valider
2. **Mutations** : Effectuez les mutations rapidement pour maintenir la cohérence
3. **Mouvements** : Enregistrez les mouvements régulièrement pour un suivi précis
4. **Maintenances** : Suivez le workflow complet pour une traçabilité optimale
5. **Notifications** : Consultez régulièrement vos notifications

### Raccourcis utiles
- **Dashboard** : Accès rapide aux statistiques
- **Recherche** : Utilisez les filtres pour trouver rapidement les éléments
- **Actions rapides** : Utilisez les boutons d'action dans les listes
- **PDF** : Sauvegardez les PDF de validation pour vos archives

### Support
En cas de problème :
1. Vérifiez vos permissions
2. Consultez les notifications
3. Contactez votre administrateur
4. Consultez la documentation technique

---

**PNEUMA-SOUCHE** - Guide d'Utilisation v1.0
