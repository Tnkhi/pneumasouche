<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mutation extends Model
{
    protected $fillable = [
        'pneu_id',
        'vehicule_source_id',
        'vehicule_destination_id',
        'date_mutation',
        'motif',
        'kilometrage_au_moment_mutation',
        'operateur',
        'observations'
    ];

    protected $casts = [
        'date_mutation' => 'date'
    ];

    /**
     * Relation avec le pneu
     */
    public function pneu(): BelongsTo
    {
        return $this->belongsTo(Pneu::class);
    }

    /**
     * Relation avec le véhicule source (d'où vient le pneu)
     */
    public function vehiculeSource(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_source_id');
    }

    /**
     * Relation avec le véhicule destination (où va le pneu)
     */
    public function vehiculeDestination(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_destination_id');
    }

    /**
     * Accesseur pour le type de mutation
     */
    public function getTypeMutationAttribute(): string
    {
        if ($this->vehicule_source_id === null) {
            return 'Montage initial';
        }
        
        return 'Mutation';
    }

    /**
     * Accesseur pour la description de la mutation
     */
    public function getDescriptionAttribute(): string
    {
        if ($this->vehicule_source_id === null) {
            return "Montage initial sur {$this->vehiculeDestination->immatriculation}";
        }
        
        return "Mutation de {$this->vehiculeSource->immatriculation} vers {$this->vehiculeDestination->immatriculation}";
    }

    /**
     * Accesseur pour l'âge de la mutation en jours
     */
    public function getAgeMutationAttribute(): int
    {
        return $this->date_mutation->diffInDays(now());
    }
}
