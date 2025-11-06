<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use App\Models\Pneu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pneus = Pneu::all();
        $mecaniciens = User::where('role', 'mecanicien')->get();
        $declarateurs = User::where('role', 'declarateur')->get();
        $directions = User::where('role', 'direction')->get();

        if ($pneus->isEmpty() || $mecaniciens->isEmpty()) {
            $this->command->info('Pas assez de données pour créer des maintenances.');
            return;
        }

        $motifs = [
            'Usure excessive',
            'Panne',
            'Fissure',
            'Déformation',
            'Perte de pression',
            'Maintenance préventive',
            'Autre'
        ];

        $descriptions = [
            'Usure importante constatée sur la bande de roulement',
            'Panne soudaine nécessitant une intervention urgente',
            'Fissure visible sur le flanc du pneu',
            'Déformation de la jante affectant le pneu',
            'Perte de pression récurrente malgré les réparations',
            'Maintenance préventive programmée',
            'Problème technique nécessitant une expertise'
        ];

        // Créer des maintenances avec différents statuts
        for ($i = 0; $i < 15; $i++) {
            $pneu = $pneus->random();
            $mecanicien = $mecaniciens->random();
            $motif = $motifs[array_rand($motifs)];
            $description = $descriptions[array_rand($descriptions)];

            $maintenance = Maintenance::create([
                'pneu_id' => $pneu->id,
                'mecanicien_id' => $mecanicien->id,
                'motif_maintenance' => $motif,
                'description_probleme' => $description,
                'statut' => 'declaree',
                'etape' => 'mecanicien',
                'date_declaration' => now()->subDays(rand(1, 30))
            ]);

            // Ajouter l'action initiale
            $maintenance->ajouterAction('Déclaration créée', $mecanicien, 'Maintenance déclarée par le mécanicien');

            // Simuler différents états selon l'index
            if ($i < 5) {
                // Maintenances déclarées (déjà créées)
                continue;
            } elseif ($i < 8) {
                // Maintenances validées par le déclarateur
                $declarateur = $declarateurs->random();
                $maintenance->update([
                    'declarateur_id' => $declarateur->id,
                    'numero_reference' => 'REF-' . date('Y') . '-' . str_pad($maintenance->id, 3, '0', STR_PAD_LEFT),
                    'bon_necessaire' => 'Bon de commande pour pièces de rechange et main d\'œuvre',
                    'prix_maintenance' => rand(50000, 200000),
                    'statut' => 'en_attente_validation',
                    'etape' => 'direction',
                    'date_validation_declarateur' => now()->subDays(rand(1, 15))
                ]);
                $maintenance->ajouterAction('Validation déclarateur', $declarateur, 'Bon de maintenance ajouté');
            } elseif ($i < 11) {
                // Maintenances validées par la direction
                $declarateur = $declarateurs->random();
                $direction = $directions->random();
                
                $maintenance->update([
                    'declarateur_id' => $declarateur->id,
                    'numero_reference' => 'REF-' . date('Y') . '-' . str_pad($maintenance->id, 3, '0', STR_PAD_LEFT),
                    'bon_necessaire' => 'Bon de commande pour pièces de rechange et main d\'œuvre',
                    'prix_maintenance' => rand(50000, 200000),
                    'statut' => 'en_attente_validation',
                    'etape' => 'direction',
                    'date_validation_declarateur' => now()->subDays(rand(5, 20))
                ]);
                $maintenance->ajouterAction('Validation déclarateur', $declarateur, 'Bon de maintenance ajouté');

                $maintenance->update([
                    'direction_id' => $direction->id,
                    'commentaire_direction' => 'Maintenance approuvée par la direction',
                    'statut' => 'validee',
                    'etape' => 'terminee',
                    'date_validation_direction' => now()->subDays(rand(1, 10))
                ]);
                $maintenance->ajouterAction('Validation direction', $direction, 'Maintenance approuvée par la direction');
            } elseif ($i < 13) {
                // Maintenances terminées
                $declarateur = $declarateurs->random();
                $direction = $directions->random();
                
                $maintenance->update([
                    'declarateur_id' => $declarateur->id,
                    'numero_reference' => 'REF-' . date('Y') . '-' . str_pad($maintenance->id, 3, '0', STR_PAD_LEFT),
                    'bon_necessaire' => 'Bon de commande pour pièces de rechange et main d\'œuvre',
                    'prix_maintenance' => rand(50000, 200000),
                    'statut' => 'en_attente_validation',
                    'etape' => 'direction',
                    'date_validation_declarateur' => now()->subDays(rand(10, 25))
                ]);
                $maintenance->ajouterAction('Validation déclarateur', $declarateur, 'Bon de maintenance ajouté');

                $maintenance->update([
                    'direction_id' => $direction->id,
                    'commentaire_direction' => 'Maintenance approuvée par la direction',
                    'statut' => 'validee',
                    'etape' => 'terminee',
                    'date_validation_direction' => now()->subDays(rand(5, 15))
                ]);
                $maintenance->ajouterAction('Validation direction', $direction, 'Maintenance approuvée par la direction');

                $maintenance->update([
                    'rapport_finalisation' => 'Maintenance terminée avec succès. Pneu remis en état, test de pression effectué, montage validé.',
                    'statut' => 'terminee',
                    'date_finalisation' => now()->subDays(rand(1, 5))
                ]);
                $maintenance->ajouterAction('Finalisation', $mecanicien, 'Maintenance terminée avec succès. Pneu remis en état, test de pression effectué, montage validé.');
            } else {
                // Maintenances rejetées
                $declarateur = $declarateurs->random();
                $direction = $directions->random();
                
                $maintenance->update([
                    'declarateur_id' => $declarateur->id,
                    'numero_reference' => 'REF-' . date('Y') . '-' . str_pad($maintenance->id, 3, '0', STR_PAD_LEFT),
                    'bon_necessaire' => 'Bon de commande pour pièces de rechange et main d\'œuvre',
                    'prix_maintenance' => rand(50000, 200000),
                    'statut' => 'en_attente_validation',
                    'etape' => 'direction',
                    'date_validation_declarateur' => now()->subDays(rand(5, 20))
                ]);
                $maintenance->ajouterAction('Validation déclarateur', $declarateur, 'Bon de maintenance ajouté');

                $maintenance->update([
                    'direction_id' => $direction->id,
                    'commentaire_direction' => 'Maintenance rejetée - Coût trop élevé par rapport au budget disponible',
                    'statut' => 'rejetee',
                    'etape' => 'terminee',
                    'date_validation_direction' => now()->subDays(rand(1, 10))
                ]);
                $maintenance->ajouterAction('Rejet direction', $direction, 'Maintenance rejetée - Coût trop élevé par rapport au budget disponible');
            }
        }

        $this->command->info('Maintenances créées avec succès !');
    }
}
