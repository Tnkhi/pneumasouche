<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{
    /**
     * Créer une notification
     */
    public static function creer(
        string $type,
        string $modelType,
        ?int $modelId,
        string $title,
        string $message,
        int $userId,
        string $icon = 'fas fa-info-circle',
        string $color = 'info',
        array $data = []
    ): Notification {
        return Notification::create([
            'type' => $type,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'color' => $color,
            'user_id' => $userId,
            'data' => $data
        ]);
    }

    /**
     * Notification pour création d'un pneu
     */
    public static function pneuCree(Model $pneu, int $userId): Notification
    {
        return self::creer(
            'create',
            'Pneu',
            $pneu->id,
            'Nouveau Pneu Ajouté',
            "Le pneu {$pneu->numero_serie} ({$pneu->marque}) a été ajouté au système.",
            $userId,
            'fas fa-tire',
            'success',
            [
                'numero_serie' => $pneu->numero_serie,
                'marque' => $pneu->marque,
                'vehicule_id' => $pneu->vehicule_id
            ]
        );
    }

    /**
     * Notification pour modification d'un pneu
     */
    public static function pneuModifie(Model $pneu, int $userId): Notification
    {
        return self::creer(
            'update',
            'Pneu',
            $pneu->id,
            'Pneu Modifié',
            "Le pneu {$pneu->numero_serie} ({$pneu->marque}) a été modifié.",
            $userId,
            'fas fa-edit',
            'warning',
            [
                'numero_serie' => $pneu->numero_serie,
                'marque' => $pneu->marque
            ]
        );
    }

    /**
     * Notification pour suppression d'un pneu
     */
    public static function pneuSupprime(string $numeroSerie, string $marque, int $userId): Notification
    {
        return self::creer(
            'delete',
            'Pneu',
            null,
            'Pneu Supprimé',
            "Le pneu {$numeroSerie} ({$marque}) a été supprimé du système.",
            $userId,
            'fas fa-trash',
            'danger',
            [
                'numero_serie' => $numeroSerie,
                'marque' => $marque
            ]
        );
    }

    /**
     * Notification pour création d'un véhicule
     */
    public static function vehiculeCree(Model $vehicule, int $userId): Notification
    {
        return self::creer(
            'create',
            'Vehicule',
            $vehicule->id,
            'Nouveau Véhicule Ajouté',
            "Le véhicule {$vehicule->immatriculation} ({$vehicule->marque}) a été ajouté au système.",
            $userId,
            'fas fa-car',
            'success',
            [
                'immatriculation' => $vehicule->immatriculation,
                'marque' => $vehicule->marque
            ]
        );
    }

    /**
     * Notification pour modification d'un véhicule
     */
    public static function vehiculeModifie(Model $vehicule, int $userId): Notification
    {
        return self::creer(
            'update',
            'Vehicule',
            $vehicule->id,
            'Véhicule Modifié',
            "Le véhicule {$vehicule->immatriculation} ({$vehicule->marque}) a été modifié.",
            $userId,
            'fas fa-edit',
            'warning',
            [
                'immatriculation' => $vehicule->immatriculation,
                'marque' => $vehicule->marque
            ]
        );
    }

    /**
     * Notification pour suppression d'un véhicule
     */
    public static function vehiculeSupprime(string $immatriculation, string $marque, int $userId): Notification
    {
        return self::creer(
            'delete',
            'Vehicule',
            null,
            'Véhicule Supprimé',
            "Le véhicule {$immatriculation} ({$marque}) a été supprimé du système.",
            $userId,
            'fas fa-trash',
            'danger',
            [
                'immatriculation' => $immatriculation,
                'marque' => $marque
            ]
        );
    }

    /**
     * Notification pour création d'un fournisseur
     */
    public static function fournisseurCree(Model $fournisseur, int $userId): Notification
    {
        return self::creer(
            'create',
            'Fournisseur',
            $fournisseur->id,
            'Nouveau Fournisseur Ajouté',
            "Le fournisseur {$fournisseur->nom} a été ajouté au système.",
            $userId,
            'fas fa-truck',
            'success',
            [
                'nom' => $fournisseur->nom,
                'telephone' => $fournisseur->telephone
            ]
        );
    }

    /**
     * Notification pour modification d'un fournisseur
     */
    public static function fournisseurModifie(Model $fournisseur, int $userId): Notification
    {
        return self::creer(
            'update',
            'Fournisseur',
            $fournisseur->id,
            'Fournisseur Modifié',
            "Le fournisseur {$fournisseur->nom} a été modifié.",
            $userId,
            'fas fa-edit',
            'warning',
            [
                'nom' => $fournisseur->nom
            ]
        );
    }

    /**
     * Notification pour suppression d'un fournisseur
     */
    public static function fournisseurSupprime(string $nom, int $userId): Notification
    {
        return self::creer(
            'delete',
            'Fournisseur',
            null,
            'Fournisseur Supprimé',
            "Le fournisseur {$nom} a été supprimé du système.",
            $userId,
            'fas fa-trash',
            'danger',
            [
                'nom' => $nom
            ]
        );
    }

    /**
     * Notification pour une mutation de pneu
     */
    public static function mutationEffectuee(Model $mutation, int $userId): Notification
    {
        return self::creer(
            'mutation',
            'Mutation',
            $mutation->id,
            'Mutation de Pneu Effectuée',
            "Le pneu {$mutation->pneu->numero_serie} a été muté du véhicule {$mutation->vehiculeSource->immatriculation} vers {$mutation->vehiculeDestination->immatriculation}.",
            $userId,
            'fas fa-exchange-alt',
            'info',
            [
                'pneu_id' => $mutation->pneu_id,
                'vehicule_source_id' => $mutation->vehicule_source_id,
                'vehicule_destination_id' => $mutation->vehicule_destination_id
            ]
        );
    }

    /**
     * Notification pour un mouvement de véhicule
     */
    public static function mouvementEnregistre(Model $mouvement, int $userId): Notification
    {
        return self::creer(
            'mouvement',
            'Mouvement',
            $mouvement->id,
            'Mouvement Enregistré',
            "Un mouvement de {$mouvement->distance_parcourue} km a été enregistré pour le véhicule {$mouvement->vehicule->immatriculation}.",
            $userId,
            'fas fa-route',
            'primary',
            [
                'vehicule_id' => $mouvement->vehicule_id,
                'distance_parcourue' => $mouvement->distance_parcourue,
                'destination' => $mouvement->destination
            ]
        );
    }

    /**
     * Notification pour une maintenance déclarée
     */
    public static function maintenanceDeclaree(Model $maintenance, int $userId): Notification
    {
        $message = "Maintenance curative déclarée pour le véhicule {$maintenance->vehicule->immatriculation} - {$maintenance->sous_type_curative_name}";
        
        return self::creer(
            'maintenance_declaree',
            'Maintenance',
            $maintenance->id,
            'Maintenance Curative Déclarée',
            $message,
            $userId,
            'fas fa-wrench',
            'warning',
            [
                'maintenance_id' => $maintenance->id,
                'vehicule_id' => $maintenance->vehicule_id,
                'type_maintenance' => $maintenance->type_maintenance,
                'sous_type_curative' => $maintenance->sous_type_curative
            ]
        );
    }

    /**
     * Notification pour une maintenance validée par le déclarateur
     */
    public static function maintenanceValideeDeclarateur(Model $maintenance, int $userId): Notification
    {
        $message = "Maintenance curative validée par le déclarateur pour le véhicule {$maintenance->vehicule->immatriculation}";
        
        return self::creer(
            'maintenance_validee_declarateur',
            'Maintenance',
            $maintenance->id,
            'Maintenance Validée par le Déclarateur',
            $message,
            $userId,
            'fas fa-user-check',
            'success',
            [
                'maintenance_id' => $maintenance->id,
                'vehicule_id' => $maintenance->vehicule_id,
                'montant_total' => $maintenance->montant_total_pieces
            ]
        );
    }

    /**
     * Notification pour une maintenance validée par la direction
     */
    public static function maintenanceValideeDirection(Model $maintenance, int $userId): Notification
    {
        $message = "Maintenance curative approuvée par la direction pour le véhicule {$maintenance->vehicule->immatriculation}";
        
        return self::creer(
            'maintenance_validee_direction',
            'Maintenance',
            $maintenance->id,
            'Maintenance Approuvée par la Direction',
            $message,
            $userId,
            'fas fa-gavel',
            'success',
            [
                'maintenance_id' => $maintenance->id,
                'vehicule_id' => $maintenance->vehicule_id,
                'montant_total' => $maintenance->montant_total_pieces
            ]
        );
    }

    /**
     * Notification pour une maintenance rejetée par la direction
     */
    public static function maintenanceRejeteeDirection(Model $maintenance, int $userId, string $motif): Notification
    {
        $message = "Maintenance curative rejetée par la direction pour le véhicule {$maintenance->vehicule->immatriculation}";
        
        return self::creer(
            'maintenance_rejetee_direction',
            'Maintenance',
            $maintenance->id,
            'Maintenance Rejetée par la Direction',
            $message,
            $userId,
            'fas fa-times',
            'danger',
            [
                'maintenance_id' => $maintenance->id,
                'vehicule_id' => $maintenance->vehicule_id,
                'motif_rejet' => $motif
            ]
        );
    }

    /**
     * Notification pour une maintenance terminée
     */
    public static function maintenanceTerminee(Model $maintenance, int $userId): Notification
    {
        $message = "Maintenance curative terminée pour le véhicule {$maintenance->vehicule->immatriculation}";
        
        return self::creer(
            'maintenance_terminee',
            'Maintenance',
            $maintenance->id,
            'Maintenance Terminée',
            $message,
            $userId,
            'fas fa-check-circle',
            'info',
            [
                'maintenance_id' => $maintenance->id,
                'vehicule_id' => $maintenance->vehicule_id,
                'montant_total' => $maintenance->montant_total_pieces
            ]
        );
    }



    /**
     * Notification pour création d'un utilisateur
     */
    public static function utilisateurCree(Model $user, int $userId): Notification
    {
        return self::creer(
            'create',
            'User',
            $user->id,
            'Nouvel Utilisateur Créé',
            "L'utilisateur {$user->name} ({$user->role}) a été créé.",
            $userId,
            'fas fa-user-plus',
            'success',
            [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        );
    }

    /**
     * Notification pour modification d'un utilisateur
     */
    public static function utilisateurModifie(Model $user, int $userId): Notification
    {
        return self::creer(
            'update',
            'User',
            $user->id,
            'Utilisateur Modifié',
            "L'utilisateur {$user->name} a été modifié.",
            $userId,
            'fas fa-user-edit',
            'warning',
            [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        );
    }

    /**
     * Notification pour suppression d'un utilisateur
     */
    public static function utilisateurSupprime(string $name, string $email, int $userId): Notification
    {
        return self::creer(
            'delete',
            'User',
            null,
            'Utilisateur Supprimé',
            "L'utilisateur {$name} ({$email}) a été supprimé du système.",
            $userId,
            'fas fa-user-times',
            'danger',
            [
                'name' => $name,
                'email' => $email
            ]
        );
    }
}
