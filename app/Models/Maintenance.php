<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maintenance extends Model
{
    protected $fillable = [
        'type_maintenance',
        'sous_type_curative',
        'vehicule_id',
        'prerequis',
        'requis',
        'resultat_attendu',
        'explication_cause',
        'statut',
        'etape',
        'mecanicien_id',
        'declarateur_id',
        'direction_id',
        'numero_reference',
        'bon_necessaire',
        'prix_maintenance',
        'date_validation_declarateur',
        'date_validation_direction',
        'commentaire_direction',
        'date_finalisation',
        'rapport_finalisation',
        'historique_actions',
        'pdf_path'
    ];

    protected $casts = [
        'date_validation_declarateur' => 'datetime',
        'date_validation_direction' => 'datetime',
        'date_finalisation' => 'datetime',
        'prix_maintenance' => 'decimal:2',
        'historique_actions' => 'array'
    ];

    // Relations
    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function mecanicien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mecanicien_id');
    }

    public function declarateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'declarateur_id');
    }

    public function direction(): BelongsTo
    {
        return $this->belongsTo(User::class, 'direction_id');
    }

    public function piecesDetachees(): HasMany
    {
        return $this->hasMany(PieceDetachee::class);
    }

    // Accesseurs
    public function getStatutNameAttribute(): string
    {
        return match($this->statut) {
            'declaree' => 'Déclarée',
            'en_attente_validation' => 'En attente de validation',
            'validee' => 'Validée',
            'terminee' => 'Terminée',
            'rejetee' => 'Rejetée',
            default => 'Inconnue'
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'declaree' => 'warning',
            'en_attente_validation' => 'info',
            'validee' => 'success',
            'terminee' => 'primary',
            'rejetee' => 'danger',
            default => 'secondary'
        };
    }

    public function getEtapeNameAttribute(): string
    {
        return match($this->etape) {
            'declarateur' => 'Déclarateur',
            'direction' => 'Direction',
            'terminee' => 'Terminée',
            default => 'Inconnue'
        };
    }

    public function getTypeMaintenanceNameAttribute(): string
    {
        return match($this->type_maintenance) {
            'preventive' => 'Maintenance Préventive',
            'curative' => 'Maintenance Curative',
            default => 'Non défini'
        };
    }

    public function getSousTypeCurativeNameAttribute(): string
    {
        return match($this->sous_type_curative) {
            'intervention_moteur' => 'Intervention corrective dans le moteur',
            'intervention_boite_vitesse' => 'Intervention corrective dans la boite de vitesse',
            'intervention_volant_embrayage' => 'Intervention corrective dans le volant moteur et embrayage',
            'intervention_suspension_freinage' => 'Intervention corrective dans le système de suspension et freinage',
            'intervention_pont_transmission' => 'Intervention corrective dans le pont et système de transmission',
            'intervention_refroidissement' => 'Intervention corrective dans le système de refroidissement',
            'intervention_tableau_bord' => 'Intervention corrective dans le tableau de bord',
            'intervention_carrosserie' => 'Intervention corrective sur la carrosserie générale',
            default => 'Non défini'
        };
    }

    public function getSousTypeCurativeIconAttribute(): string
    {
        return match($this->sous_type_curative) {
            'intervention_moteur' => 'fas fa-cog',
            'intervention_boite_vitesse' => 'fas fa-cogs',
            'intervention_volant_embrayage' => 'fas fa-steering-wheel',
            'intervention_suspension_freinage' => 'fas fa-car-crash',
            'intervention_pont_transmission' => 'fas fa-link',
            'intervention_refroidissement' => 'fas fa-thermometer-half',
            'intervention_tableau_bord' => 'fas fa-tachometer-alt',
            'intervention_carrosserie' => 'fas fa-car',
            default => 'fas fa-wrench'
        };
    }

    /**
     * Accessor pour le montant total des pièces détachées
     */
    public function getMontantTotalPiecesAttribute(): float
    {
        return $this->piecesDetachees()->sum('montant_total');
    }

    /**
     * Accessor pour le montant total des pièces détachées formaté
     */
    public function getMontantTotalPiecesFormateAttribute(): string
    {
        return number_format($this->montant_total_pieces, 0, ',', ' ') . ' FCFA';
    }

    public function getAgeAttribute(): int
    {
        return $this->created_at->diffInDays(now());
    }

    public function getDureeTraitementAttribute(): ?int
    {
        if ($this->date_finalisation) {
            return $this->created_at->diffInDays($this->date_finalisation);
        }
        return null;
    }

    // Méthodes utilitaires
    public function ajouterAction(string $action, User $user, string $description = null): void
    {
        $actions = $this->historique_actions ?? [];
        $actions[] = [
            'action' => $action,
            'user' => $user->name,
            'user_id' => $user->id,
            'description' => $description,
            'date' => now()->toISOString()
        ];
        $this->historique_actions = $actions;
        $this->save();
    }

    public function peutEtreValideeParDeclarateur(): bool
    {
        return $this->etape === 'declarateur' && $this->statut === 'declaree';
    }

    public function peutEtreValideeParDirection(): bool
    {
        return $this->etape === 'direction' && $this->statut === 'en_attente_validation';
    }

    public function peutEtreTerminee(): bool
    {
        return $this->etape === 'direction' && $this->statut === 'validee';
    }
}