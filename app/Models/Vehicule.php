<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicule extends Model
{
    protected $fillable = [
        'immatriculation',
        'marque',
        'modele',
        'annee',
        'type_vehicule',
        'description',
        'nombre_pneus',
        'chauffeur',
        'position_actuelle'
    ];

    /**
     * Relation avec les pneus
     */
    public function pneus(): HasMany
    {
        return $this->hasMany(Pneu::class);
    }

    /**
     * Relation avec les mutations (en tant que véhicule source)
     */
    public function mutationsSource(): HasMany
    {
        return $this->hasMany(Mutation::class, 'vehicule_source_id');
    }

    /**
     * Relation avec les mutations (en tant que véhicule destination)
     */
    public function mutationsDestination(): HasMany
    {
        return $this->hasMany(Mutation::class, 'vehicule_destination_id');
    }

    /**
     * Relation avec les mouvements
     */
    public function mouvements(): HasMany
    {
        return $this->hasMany(Mouvement::class);
    }

    /**
     * Calcul automatique du nombre de pneus
     */
    public function calculerNombrePneus(): int
    {
        return $this->pneus()->count();
    }

    /**
     * Accesseur pour le nombre de pneus calculé
     */
    public function getNombrePneusAttribute($value): int
    {
        return $this->calculerNombrePneus();
    }

    /**
     * Accesseur pour la valeur totale des pneus
     */
    public function getValeurTotalePneusAttribute(): float
    {
        return $this->pneus()->sum('prix_achat');
    }

    /**
     * Accesseur pour le taux d'usure moyen des pneus
     */
    public function getTauxUsureMoyenAttribute(): float
    {
        $pneus = $this->pneus()->get();
        if ($pneus->isEmpty()) {
            return 0;
        }
        
        return $pneus->avg(function($pneu) {
            return $pneu->calculerTauxUsure();
        });
    }

    /**
     * Accesseur pour l'âge du véhicule
     */
    public function getAgeAttribute(): int
    {
        if (!$this->annee) {
            return 0;
        }
        
        return date('Y') - $this->annee;
    }

    /**
     * Accesseur pour le statut du véhicule basé sur l'usure des pneus
     */
    public function getStatutAttribute(): string
    {
        $tauxUsureMoyen = $this->taux_usure_moyen;
        
        if ($tauxUsureMoyen < 30) {
            return 'Excellent';
        } elseif ($tauxUsureMoyen < 60) {
            return 'Bon';
        } elseif ($tauxUsureMoyen < 80) {
            return 'À surveiller';
        } else {
            return 'Critique';
        }
    }

    /**
     * Accesseur pour la couleur du statut
     */
    public function getCouleurStatutAttribute(): string
    {
        $statut = $this->statut;
        
        switch ($statut) {
            case 'Excellent':
                return 'success';
            case 'Bon':
                return 'info';
            case 'À surveiller':
                return 'warning';
            case 'Critique':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    /**
     * Boot method pour calculer automatiquement les valeurs
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($vehicule) {
            $vehicule->nombre_pneus = $vehicule->calculerNombrePneus();
        });
    }
}
