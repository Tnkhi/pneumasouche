<?php

namespace App\Services;

use App\Models\Alerte;
use App\Models\Pneu;
use App\Models\Vehicule;
use App\Models\Maintenance;
use App\Models\Mutation;
use App\Models\Mouvement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AlerteIntelligenteService
{
    /**
     * Analyser et générer toutes les alertes intelligentes
     */
    public function analyserEtGenererAlertes(): array
    {
        $alertes = [];
        
        // Analyser les différents types d'alertes
        $alertes = array_merge($alertes, $this->analyserUsurePneus());
        $alertes = array_merge($alertes, $this->analyserMaintenances());
        $alertes = array_merge($alertes, $this->analyserMutations());
        $alertes = array_merge($alertes, $this->analyserVehicules());
        $alertes = array_merge($alertes, $this->analyserPerformance());
        
        // Sauvegarder les nouvelles alertes
        foreach ($alertes as $alerte) {
            $this->creerAlerte($alerte);
        }
        
        return $alertes;
    }

    /**
     * Analyser l'usure des pneus
     */
    private function analyserUsurePneus(): array
    {
        $alertes = [];
        $pneus = Pneu::with(['vehicule', 'fournisseur'])->get();
        
        foreach ($pneus as $pneu) {
            $tauxUsure = $pneu->calculerTauxUsure();
            
            // Alerte critique : usure > 90%
            if ($tauxUsure >= 90) {
                $alertes[] = [
                    'titre' => 'Usure Critique du Pneu',
                    'message' => "Le pneu {$pneu->numero_serie} ({$pneu->marque}) a atteint {$tauxUsure}% d'usure. Remplacement urgent requis.",
                    'type' => 'danger',
                    'priorite' => 'critique',
                    'categorie' => 'usure',
                    'pneu_id' => $pneu->id,
                    'vehicule_id' => $pneu->vehicule_id,
                    'donnees_contexte' => [
                        'taux_usure' => $tauxUsure,
                        'kilometrage' => $pneu->kilometrage,
                        'duree_vie' => $pneu->duree_vie,
                        'vehicule' => $pneu->vehicule?->immatriculation,
                    ]
                ];
            }
            // Alerte haute : usure entre 80% et 89%
            elseif ($tauxUsure >= 80) {
                $alertes[] = [
                    'titre' => 'Usure Élevée du Pneu',
                    'message' => "Le pneu {$pneu->numero_serie} ({$pneu->marque}) a atteint {$tauxUsure}% d'usure. Planifier le remplacement.",
                    'type' => 'warning',
                    'priorite' => 'haute',
                    'categorie' => 'usure',
                    'pneu_id' => $pneu->id,
                    'vehicule_id' => $pneu->vehicule_id,
                    'donnees_contexte' => [
                        'taux_usure' => $tauxUsure,
                        'kilometrage' => $pneu->kilometrage,
                        'duree_vie' => $pneu->duree_vie,
                        'vehicule' => $pneu->vehicule?->immatriculation,
                    ]
                ];
            }
            // Alerte moyenne : usure entre 70% et 79%
            elseif ($tauxUsure >= 70) {
                $alertes[] = [
                    'titre' => 'Usure Modérée du Pneu',
                    'message' => "Le pneu {$pneu->numero_serie} ({$pneu->marque}) a atteint {$tauxUsure}% d'usure. Surveiller de près.",
                    'type' => 'warning',
                    'priorite' => 'moyenne',
                    'categorie' => 'usure',
                    'pneu_id' => $pneu->id,
                    'vehicule_id' => $pneu->vehicule_id,
                    'donnees_contexte' => [
                        'taux_usure' => $tauxUsure,
                        'kilometrage' => $pneu->kilometrage,
                        'duree_vie' => $pneu->duree_vie,
                        'vehicule' => $pneu->vehicule?->immatriculation,
                    ]
                ];
            }
        }
        
        return $alertes;
    }

    /**
     * Analyser les maintenances
     */
    private function analyserMaintenances(): array
    {
        $alertes = [];
        
        // Maintenances en attente depuis plus de 7 jours
        $maintenancesEnAttente = Maintenance::where('statut', 'déclarée')
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->with(['pneu', 'mecanicien'])
            ->get();
            
        foreach ($maintenancesEnAttente as $maintenance) {
            $joursEnAttente = $maintenance->created_at->diffInDays(now());
            
            $alertes[] = [
                'titre' => 'Maintenance en Attente',
                'message' => "La maintenance #{$maintenance->id} pour le pneu {$maintenance->pneu->numero_serie} est en attente depuis {$joursEnAttente} jours.",
                'type' => 'warning',
                'priorite' => $joursEnAttente > 14 ? 'haute' : 'moyenne',
                'categorie' => 'maintenance',
                'maintenance_id' => $maintenance->id,
                'pneu_id' => $maintenance->pneu_id,
                'donnees_contexte' => [
                    'jours_en_attente' => $joursEnAttente,
                    'motif' => $maintenance->motif,
                    'mecanicien' => $maintenance->mecanicien?->name,
                ]
            ];
        }
        
        // Maintenances validées mais non exécutées
        $maintenancesValidees = Maintenance::where('statut', 'validée_direction')
            ->where('created_at', '<', Carbon::now()->subDays(3))
            ->with(['pneu', 'direction'])
            ->get();
            
        foreach ($maintenancesValidees as $maintenance) {
            $alertes[] = [
                'titre' => 'Maintenance Validée Non Exécutée',
                'message' => "La maintenance #{$maintenance->id} a été validée par la direction mais n'a pas encore été exécutée.",
                'type' => 'info',
                'priorite' => 'moyenne',
                'categorie' => 'maintenance',
                'maintenance_id' => $maintenance->id,
                'pneu_id' => $maintenance->pneu_id,
                'donnees_contexte' => [
                    'date_validation' => $maintenance->updated_at->format('d/m/Y'),
                    'direction' => $maintenance->direction?->name,
                ]
            ];
        }
        
        return $alertes;
    }

    /**
     * Analyser les mutations
     */
    private function analyserMutations(): array
    {
        $alertes = [];
        
        // Pneus avec trop de mutations (usure inégale)
        $pneusAvecMutations = Pneu::withCount('mutations')
            ->with(['vehicule', 'mutations'])
            ->get()
            ->filter(function($pneu) {
                return $pneu->mutations_count > 5;
            });
            
        foreach ($pneusAvecMutations as $pneu) {
            $alertes[] = [
                'titre' => 'Mutations Excessives',
                'message' => "Le pneu {$pneu->numero_serie} a subi {$pneu->mutations_count} mutations. Risque d'usure inégale.",
                'type' => 'warning',
                'priorite' => 'moyenne',
                'categorie' => 'mutation',
                'pneu_id' => $pneu->id,
                'vehicule_id' => $pneu->vehicule_id,
                'donnees_contexte' => [
                    'nombre_mutations' => $pneu->mutations_count,
                    'taux_usure' => $pneu->calculerTauxUsure(),
                ]
            ];
        }
        
        return $alertes;
    }

    /**
     * Analyser les véhicules
     */
    private function analyserVehicules(): array
    {
        $alertes = [];
        
        // Véhicules sans mouvement depuis plus de 30 jours
        $vehiculesInactifs = Vehicule::whereDoesntHave('mouvements', function($query) {
            $query->where('date_mouvement', '>=', Carbon::now()->subDays(30));
        })->with('pneus')->get();
        
        foreach ($vehiculesInactifs as $vehicule) {
            $alertes[] = [
                'titre' => 'Véhicule Inactif',
                'message' => "Le véhicule {$vehicule->immatriculation} ({$vehicule->marque} {$vehicule->modele}) n'a pas eu de mouvement depuis plus de 30 jours.",
                'type' => 'info',
                'priorite' => 'faible',
                'categorie' => 'performance',
                'vehicule_id' => $vehicule->id,
                'donnees_contexte' => [
                    'dernier_mouvement' => $vehicule->mouvements()->latest()->first()?->date_mouvement?->format('d/m/Y'),
                    'nombre_pneus' => $vehicule->pneus->count(),
                ]
            ];
        }
        
        return $alertes;
    }

    /**
     * Analyser la performance globale
     */
    private function analyserPerformance(): array
    {
        $alertes = [];
        
        // Analyser le stock de pneus
        $totalPneus = Pneu::count();
        $pneusUsures = Pneu::whereRaw('(kilometrage / duree_vie) * 100 >= 80')->count();
        $pourcentageUsures = $totalPneus > 0 ? ($pneusUsures / $totalPneus) * 100 : 0;
        
        if ($pourcentageUsures > 50) {
            $alertes[] = [
                'titre' => 'Stock de Pneus Critique',
                'message' => "{$pourcentageUsures}% des pneus ont une usure élevée. Planifier les achats de remplacement.",
                'type' => 'danger',
                'priorite' => 'haute',
                'categorie' => 'stock',
                'donnees_contexte' => [
                    'total_pneus' => $totalPneus,
                    'pneus_usures' => $pneusUsures,
                    'pourcentage_usures' => round($pourcentageUsures, 2),
                ]
            ];
        }
        
        return $alertes;
    }

    /**
     * Créer une alerte si elle n'existe pas déjà
     */
    private function creerAlerte(array $donneesAlerte): void
    {
        // Vérifier si une alerte similaire existe déjà
        $alerteExistante = Alerte::where('categorie', $donneesAlerte['categorie'])
            ->where('statut', 'active')
            ->where(function($query) use ($donneesAlerte) {
                if (isset($donneesAlerte['pneu_id'])) {
                    $query->where('pneu_id', $donneesAlerte['pneu_id']);
                }
                if (isset($donneesAlerte['vehicule_id'])) {
                    $query->where('vehicule_id', $donneesAlerte['vehicule_id']);
                }
                if (isset($donneesAlerte['maintenance_id'])) {
                    $query->where('maintenance_id', $donneesAlerte['maintenance_id']);
                }
            })
            ->first();
            
        if (!$alerteExistante) {
            try {
                Alerte::create($donneesAlerte);
                Log::info('Alerte créée: ' . $donneesAlerte['titre']);
            } catch (\Exception $e) {
                Log::error('Erreur création alerte: ' . $e->getMessage());
            }
        }
    }

    /**
     * Obtenir les alertes actives
     */
    public function getAlertesActives(): array
    {
        return Alerte::actives()
            ->with(['pneu', 'vehicule', 'maintenance', 'user'])
            ->orderBy('priorite', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Obtenir les statistiques des alertes
     */
    public function getStatistiquesAlertes(): array
    {
        return [
            'total' => Alerte::count(),
            'actives' => Alerte::actives()->count(),
            'critiques' => Alerte::critiques()->count(),
            'par_categorie' => Alerte::actives()
                ->selectRaw('categorie, count(*) as total')
                ->groupBy('categorie')
                ->pluck('total', 'categorie')
                ->toArray(),
            'par_priorite' => Alerte::actives()
                ->selectRaw('priorite, count(*) as total')
                ->groupBy('priorite')
                ->pluck('total', 'priorite')
                ->toArray(),
        ];
    }

    /**
     * Marquer une alerte comme résolue
     */
    public function resoudreAlerte(int $alerteId, string $commentaire = null): bool
    {
        try {
            $alerte = Alerte::findOrFail($alerteId);
            $alerte->marquerCommeResolue($commentaire);
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur résolution alerte: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Ignorer une alerte
     */
    public function ignorerAlerte(int $alerteId): bool
    {
        try {
            $alerte = Alerte::findOrFail($alerteId);
            $alerte->ignorer();
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur ignore alerte: ' . $e->getMessage());
            return false;
        }
    }
}

