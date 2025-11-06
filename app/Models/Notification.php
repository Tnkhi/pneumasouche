<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'model_type',
        'model_id',
        'title',
        'message',
        'icon',
        'color',
        'user_id',
        'data',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateFormateeAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Accesseur pour le temps relatif
     */
    public function getTempsRelatifAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Accesseur pour la couleur Bootstrap
     */
    public function getCouleurBootstrapAttribute(): string
    {
        return match($this->color) {
            'success' => 'success',
            'warning' => 'warning',
            'danger' => 'danger',
            'info' => 'info',
            'primary' => 'primary',
            'secondary' => 'secondary',
            default => 'info'
        };
    }

    /**
     * Marquer comme lu
     */
    public function marquerCommeLu(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Marquer comme non lu
     */
    public function marquerCommeNonLu(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null
        ]);
    }

    /**
     * Scope pour les notifications non lues
     */
    public function scopeNonLues($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope pour les notifications lues
     */
    public function scopeLues($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope pour un utilisateur spécifique
     */
    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope pour un type de modèle spécifique
     */
    public function scopePourModele($query, $modelType, $modelId = null)
    {
        $query = $query->where('model_type', $modelType);
        
        if ($modelId) {
            $query->where('model_id', $modelId);
        }
        
        return $query;
    }
}
