<?php

namespace Database\Seeders;

use App\Models\Alerte;
use App\Models\Pneu;
use App\Models\Vehicule;
use App\Models\Maintenance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlerteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer quelques alertes de test
        $pneus = Pneu::with('vehicule')->get();
        $vehicules = Vehicule::all();
        $maintenances = Maintenance::all();

        if ($pneus->count() > 0) {
            // Alerte d'usure critique
            Alerte::create([
                'titre' => 'Usure Critique du Pneu',
                'message' => 'Le pneu ' . $pneus->first()->numero_serie . ' a atteint 95% d\'usure. Remplacement urgent requis.',
                'type' => 'danger',
                'priorite' => 'critique',
                'statut' => 'active',
                'categorie' => 'usure',
                'pneu_id' => $pneus->first()->id,
                'vehicule_id' => $pneus->first()->vehicule_id,
                'donnees_contexte' => [
                    'taux_usure' => 95,
                    'kilometrage' => $pneus->first()->kilometrage,
                    'duree_vie' => $pneus->first()->duree_vie,
                ]
            ]);

            // Alerte d'usure élevée
            if ($pneus->count() > 1) {
                Alerte::create([
                    'titre' => 'Usure Élevée du Pneu',
                    'message' => 'Le pneu ' . $pneus->skip(1)->first()->numero_serie . ' a atteint 85% d\'usure. Planifier le remplacement.',
                    'type' => 'warning',
                    'priorite' => 'haute',
                    'statut' => 'active',
                    'categorie' => 'usure',
                    'pneu_id' => $pneus->skip(1)->first()->id,
                    'vehicule_id' => $pneus->skip(1)->first()->vehicule_id,
                    'donnees_contexte' => [
                        'taux_usure' => 85,
                        'kilometrage' => $pneus->skip(1)->first()->kilometrage,
                        'duree_vie' => $pneus->skip(1)->first()->duree_vie,
                    ]
                ]);
            }
        }

        if ($vehicules->count() > 0) {
            // Alerte véhicule inactif
            Alerte::create([
                'titre' => 'Véhicule Inactif',
                'message' => 'Le véhicule ' . $vehicules->first()->immatriculation . ' n\'a pas eu de mouvement depuis plus de 30 jours.',
                'type' => 'info',
                'priorite' => 'faible',
                'statut' => 'active',
                'categorie' => 'performance',
                'vehicule_id' => $vehicules->first()->id,
                'donnees_contexte' => [
                    'dernier_mouvement' => '2024-08-15',
                    'nombre_pneus' => $vehicules->first()->pneus->count(),
                ]
            ]);
        }

        if ($maintenances->count() > 0) {
            // Alerte maintenance en attente
            Alerte::create([
                'titre' => 'Maintenance en Attente',
                'message' => 'La maintenance #' . $maintenances->first()->id . ' est en attente depuis plus de 7 jours.',
                'type' => 'warning',
                'priorite' => 'moyenne',
                'statut' => 'active',
                'categorie' => 'maintenance',
                'maintenance_id' => $maintenances->first()->id,
                'pneu_id' => $maintenances->first()->pneu_id,
                'donnees_contexte' => [
                    'jours_en_attente' => 10,
                    'motif' => $maintenances->first()->motif,
                ]
            ]);
        }

        // Alerte de stock critique
        Alerte::create([
            'titre' => 'Stock de Pneus Critique',
            'message' => '60% des pneus ont une usure élevée. Planifier les achats de remplacement.',
            'type' => 'danger',
            'priorite' => 'haute',
            'statut' => 'active',
            'categorie' => 'stock',
            'donnees_contexte' => [
                'total_pneus' => $pneus->count(),
                'pneus_usures' => round($pneus->count() * 0.6),
                'pourcentage_usures' => 60,
            ]
        ]);

        $this->command->info('Alertes de test créées avec succès !');
    }
}
