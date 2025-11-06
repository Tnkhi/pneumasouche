<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fournisseur extends Model
{
    protected $fillable = [
        'nom',
        'contact',
        'telephone',
        'email',
        'adresse',
        'nombre_pneus_fournis',
        'notes'
    ];

    /**
     * Relation avec les pneus
     */
    public function pneus(): HasMany
    {
        return $this->hasMany(Pneu::class);
    }

    /**
     * Calcul automatique du nombre de pneus fournis
     */
    public function calculerNombrePneusFournis(): int
    {
        return $this->pneus()->count();
    }

    /**
     * Calcul automatique des notes basées sur les statistiques
     */
    public function calculerNotes(): string
    {
        $nombrePneus = $this->calculerNombrePneusFournis();
        
        if ($nombrePneus == 0) {
            return "Aucun pneu fourni";
        }

        // Calculer la valeur totale des pneus fournis
        $valeurTotale = $this->pneus()->sum('prix_achat');
        
        // Calculer le taux d'usure moyen des pneus
        $pneus = $this->pneus()->get();
        $tauxUsureMoyen = $pneus->avg(function($pneu) {
            return $pneu->calculerTauxUsure();
        });

        // Calculer la durée de vie moyenne
        $dureeVieMoyenne = $pneus->avg('duree_vie');

        $notes = [];
        
        // Note sur le nombre de pneus
        if ($nombrePneus >= 10) {
            $notes[] = "Fournisseur principal (" . $nombrePneus . " pneus)";
        } elseif ($nombrePneus >= 5) {
            $notes[] = "Fournisseur régulier (" . $nombrePneus . " pneus)";
        } else {
            $notes[] = "Fournisseur occasionnel (" . $nombrePneus . " pneus)";
        }

        // Note sur la valeur totale
        $notes[] = "Valeur totale: " . number_format($valeurTotale, 0) . " FCFA";

        // Note sur la qualité (basée sur le taux d'usure moyen)
        if ($tauxUsureMoyen < 30) {
            $notes[] = "Excellente qualité (usure moyenne: " . number_format($tauxUsureMoyen, 1) . "%)";
        } elseif ($tauxUsureMoyen < 60) {
            $notes[] = "Bonne qualité (usure moyenne: " . number_format($tauxUsureMoyen, 1) . "%)";
        } else {
            $notes[] = "Qualité à surveiller (usure moyenne: " . number_format($tauxUsureMoyen, 1) . "%)";
        }

        // Note sur la durée de vie
        if ($dureeVieMoyenne >= 80000) {
            $notes[] = "Durée de vie excellente (" . number_format($dureeVieMoyenne, 0) . " km)";
        } elseif ($dureeVieMoyenne >= 60000) {
            $notes[] = "Durée de vie correcte (" . number_format($dureeVieMoyenne, 0) . " km)";
        } else {
            $notes[] = "Durée de vie à améliorer (" . number_format($dureeVieMoyenne, 0) . " km)";
        }

        return implode(" | ", $notes);
    }

    /**
     * Accesseur pour le nombre de pneus fournis calculé
     */
    public function getNombrePneusFournisAttribute($value): int
    {
        return $this->calculerNombrePneusFournis();
    }

    /**
     * Accesseur pour les notes calculées
     */
    public function getNotesAttribute($value): string
    {
        return $this->calculerNotes();
    }

    /**
     * Accesseur pour la valeur totale des pneus fournis
     */
    public function getValeurTotaleAttribute(): float
    {
        return $this->pneus()->sum('prix_achat');
    }

    /**
     * Accesseur pour le taux d'usure moyen
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
     * Boot method pour calculer automatiquement les valeurs
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($fournisseur) {
            $fournisseur->nombre_pneus_fournis = $fournisseur->calculerNombrePneusFournis();
            $fournisseur->notes = $fournisseur->calculerNotes();
        });
    }
}
