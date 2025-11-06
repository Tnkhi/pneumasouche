<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Pneu extends Model
{
    protected $fillable = [
        'numero_serie',
        'prix_achat',
        'date_montage',
        'fournisseur_id',
        'marque',
        'largeur',
        'hauteur_flanc',
        'diametre_interieur',
        'indice_vitesse',
        'indice_charge',
        'duree_vie',
        'kilometrage',
        'vehicule_id',
        'taux_usure',
        'valeur_exploitation_restante'
    ];

    protected $casts = [
        'date_montage' => 'date',
        'prix_achat' => 'decimal:2',
        'taux_usure' => 'decimal:2',
        'valeur_exploitation_restante' => 'decimal:2'
    ];

    /**
     * Relation avec le fournisseur
     */
    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    /**
     * Relation avec le véhicule
     */
    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    /**
     * Relation avec les mutations
     */
    public function mutations(): HasMany
    {
        return $this->hasMany(Mutation::class)->orderBy('date_mutation', 'desc');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class)->orderBy('date_declaration', 'desc');
    }

    /**
     * Calcul automatique du taux d'usure
     */
    public function calculerTauxUsure(): float
    {
        if ($this->duree_vie <= 0) {
            return 0;
        }
        
        $taux = ($this->kilometrage / $this->duree_vie) * 100;
        return min($taux, 100); // Maximum 100%
    }

    /**
     * Calcul automatique de la valeur d'exploitation restante
     */
    public function calculerValeurRestante(): float
    {
        $tauxUsure = $this->calculerTauxUsure();
        $valeurRestante = $this->prix_achat * (1 - ($tauxUsure / 100));
        return max($valeurRestante, 0); // Minimum 0
    }

    /**
     * Accesseur pour le taux d'usure calculé
     */
    public function getTauxUsureAttribute($value): float
    {
        return $this->calculerTauxUsure();
    }

    /**
     * Accesseur pour la valeur restante calculée
     */
    public function getValeurExploitationRestanteAttribute($value): float
    {
        return $this->calculerValeurRestante();
    }

    /**
     * Accesseur pour l'âge du pneu en jours
     */
    public function getAgeAttribute(): int
    {
        return Carbon::parse($this->date_montage)->diffInDays(Carbon::now());
    }

    /**
     * Accesseur pour la dimension du pneu formatée
     */
    public function getDimensionAttribute(): string
    {
        return "{$this->largeur}/{$this->hauteur_flanc}R{$this->diametre_interieur}";
    }

    /**
     * Calculer le coût total des maintenances pour ce pneu
     */
    public function calculerCoutMaintenances(): float
    {
        return $this->maintenances()
            ->where('statut', 'validee')
            ->sum('cout_maintenance') ?? 0;
    }

    /**
     * Obtenir l'historique des dépenses du pneu
     */
    public function obtenirHistoriqueDepenses(): array
    {
        $depenses = [];

        // Prix d'achat
        $depenses[] = [
            'type' => 'achat',
            'description' => 'Prix d\'achat du pneu',
            'montant' => $this->prix_achat,
            'date' => $this->date_montage,
            'statut' => 'effectue'
        ];

        // Maintenances
        $maintenances = $this->maintenances()
            ->where('statut', 'validee')
            ->orderBy('date_declaration')
            ->get();

        foreach ($maintenances as $maintenance) {
            if ($maintenance->cout_maintenance > 0) {
                $depenses[] = [
                    'type' => 'maintenance',
                    'description' => "Maintenance: {$maintenance->motif}",
                    'montant' => $maintenance->cout_maintenance,
                    'date' => $maintenance->date_declaration,
                    'statut' => 'effectue',
                    'maintenance_id' => $maintenance->id,
                    'details' => $maintenance->description
                ];
            }
        }

        // Trier par date
        usort($depenses, function($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        return $depenses;
    }

    /**
     * Calculer le prix de revient total du pneu
     */
    public function calculerPrixDeReviement(): float
    {
        $prixAchat = $this->prix_achat;
        $coutMaintenances = $this->calculerCoutMaintenances();
        
        return $prixAchat + $coutMaintenances;
    }

    /**
     * Calculer le coût par kilomètre parcouru
     */
    public function calculerCoutParKilometre(): float
    {
        $prixReviement = $this->calculerPrixDeReviement();
        $kilometrage = $this->kilometrage;
        
        if ($kilometrage <= 0) {
            return 0;
        }
        
        return $prixReviement / $kilometrage;
    }

    /**
     * Calculer le coût par pourcentage d'usure
     */
    public function calculerCoutParUsure(): float
    {
        $prixReviement = $this->calculerPrixDeReviement();
        $tauxUsure = $this->calculerTauxUsure();
        
        if ($tauxUsure <= 0) {
            return 0;
        }
        
        return $prixReviement / $tauxUsure;
    }

    /**
     * Obtenir un résumé des coûts
     */
    public function obtenirResumeCouts(): array
    {
        $prixAchat = $this->prix_achat;
        $coutMaintenances = $this->calculerCoutMaintenances();
        $prixReviement = $this->calculerPrixDeReviement();
        $coutParKm = $this->calculerCoutParKilometre();
        $coutParUsure = $this->calculerCoutParUsure();
        $nombreMaintenances = $this->maintenances()->where('statut', 'validee')->count();

        return [
            'prix_achat' => $prixAchat,
            'cout_maintenances' => $coutMaintenances,
            'prix_reviement' => $prixReviement,
            'cout_par_kilometre' => $coutParKm,
            'cout_par_usure' => $coutParUsure,
            'nombre_maintenances' => $nombreMaintenances,
            'kilometrage' => $this->kilometrage,
            'taux_usure' => $this->calculerTauxUsure(),
            'duree_vie' => $this->duree_vie
        ];
    }

    /**
     * Boot method pour calculer automatiquement les valeurs
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($pneu) {
            $pneu->taux_usure = $pneu->calculerTauxUsure();
            $pneu->valeur_exploitation_restante = $pneu->calculerValeurRestante();
        });
    }
}
