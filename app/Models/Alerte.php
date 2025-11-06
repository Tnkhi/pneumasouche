<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Alerte extends Model
{
    protected $fillable = [
        'titre',
        'message',
        'type',
        'priorite',
        'statut',
        'categorie',
        'donnees_contexte',
        'user_id',
        'pneu_id',
        'vehicule_id',
        'maintenance_id',
        'date_resolution',
        'commentaire_resolution',
    ];

    protected $casts = [
        'donnees_contexte' => 'array',
        'date_resolution' => 'datetime',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pneu(): BelongsTo
    {
        return $this->belongsTo(Pneu::class);
    }

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    // Scopes
    public function scopeActives($query)
    {
        return $query->where('statut', 'active');
    }

    public function scopeParPriorite($query, $priorite)
    {
        return $query->where('priorite', $priorite);
    }

    public function scopeParCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    public function scopeCritiques($query)
    {
        return $query->where('priorite', 'critique')->where('statut', 'active');
    }

    public function scopeRecentes($query, $jours = 7)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($jours));
    }

    // Méthodes utilitaires
    public function marquerCommeResolue($commentaire = null): void
    {
        $this->update([
            'statut' => 'resolue',
            'date_resolution' => now(),
            'commentaire_resolution' => $commentaire,
        ]);
    }

    public function ignorer(): void
    {
        $this->update(['statut' => 'ignoree']);
    }

    public function reactiver(): void
    {
        $this->update([
            'statut' => 'active',
            'date_resolution' => null,
            'commentaire_resolution' => null,
        ]);
    }

    // Accesseurs
    public function getCouleurTypeAttribute(): string
    {
        return match($this->type) {
            'danger' => 'red',
            'warning' => 'orange',
            'success' => 'green',
            'info' => 'blue',
            default => 'gray',
        };
    }

    public function getCouleurPrioriteAttribute(): string
    {
        return match($this->priorite) {
            'critique' => 'red',
            'haute' => 'orange',
            'moyenne' => 'yellow',
            'faible' => 'green',
            default => 'gray',
        };
    }

    public function getEstUrgenteAttribute(): bool
    {
        return in_array($this->priorite, ['critique', 'haute']) && $this->statut === 'active';
    }
}
