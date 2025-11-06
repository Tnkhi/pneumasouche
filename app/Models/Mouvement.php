<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Mouvement extends Model
{
    protected $fillable = [
        'vehicule_id',
        'date_mouvement',
        'distance_parcourue',
        'destination',
        'observations',
        'user_id'
    ];

    protected $casts = [
        'date_mouvement' => 'date',
    ];

    /**
     * Relation avec le véhicule
     */
    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    /**
     * Relation avec l'utilisateur qui a enregistré le mouvement
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accesseur pour la distance formatée
     */
    public function getDistanceFormateeAttribute(): string
    {
        return number_format($this->distance_parcourue, 0, ',', ' ') . ' km';
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateFormateeAttribute(): string
    {
        return $this->date_mouvement->format('d/m/Y');
    }

    /**
     * Méthode pour mettre à jour le kilométrage des pneus du véhicule
     */
    public function mettreAJourKilometragePneus(): void
    {
        $vehicule = $this->vehicule;
        
        if ($vehicule) {
            // Récupérer tous les pneus montés sur ce véhicule
            $pneus = Pneu::where('vehicule_id', $vehicule->id)->get();
            
            foreach ($pneus as $pneu) {
                // Ajouter la distance parcourue au kilométrage du pneu
                $nouveauKilometrage = $pneu->kilometrage + $this->distance_parcourue;
                
                // Mettre à jour le kilométrage
                $pneu->update(['kilometrage' => $nouveauKilometrage]);
                
                // Le taux d'usure sera recalculé automatiquement via l'accesseur
            }
        }
    }

    /**
     * Boot method pour déclencher automatiquement la mise à jour
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($mouvement) {
            $mouvement->mettreAJourKilometragePneus();
        });
    }
}
