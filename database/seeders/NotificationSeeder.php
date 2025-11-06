<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->count() === 0) {
            $this->command->info('Aucun utilisateur trouvé. Créez d\'abord des utilisateurs.');
            return;
        }

        $notifications = [
            [
                'type' => 'create',
                'model_type' => 'Pneu',
                'model_id' => 1,
                'title' => 'Nouveau Pneu Ajouté',
                'message' => 'Le pneu 123456789 (Michelin) a été ajouté au système.',
                'icon' => 'fas fa-tire',
                'color' => 'success',
                'user_id' => $users->first()->id,
                'data' => ['numero_serie' => '123456789', 'marque' => 'Michelin'],
                'is_read' => false,
                'created_at' => now()->subHours(2)
            ],
            [
                'type' => 'update',
                'model_type' => 'Vehicule',
                'model_id' => 1,
                'title' => 'Véhicule Modifié',
                'message' => 'Le véhicule ABC-123 (Toyota) a été modifié.',
                'icon' => 'fas fa-edit',
                'color' => 'warning',
                'user_id' => $users->first()->id,
                'data' => ['immatriculation' => 'ABC-123', 'marque' => 'Toyota'],
                'is_read' => true,
                'read_at' => now()->subHour(),
                'created_at' => now()->subHours(4)
            ],
            [
                'type' => 'mutation',
                'model_type' => 'Mutation',
                'model_id' => 1,
                'title' => 'Mutation de Pneu Effectuée',
                'message' => 'Le pneu 987654321 a été muté du véhicule XYZ-789 vers ABC-123.',
                'icon' => 'fas fa-exchange-alt',
                'color' => 'info',
                'user_id' => $users->first()->id,
                'data' => ['pneu_id' => 2, 'vehicule_source' => 'XYZ-789', 'vehicule_destination' => 'ABC-123'],
                'is_read' => false,
                'created_at' => now()->subHours(1)
            ],
            [
                'type' => 'mouvement',
                'model_type' => 'Mouvement',
                'model_id' => 1,
                'title' => 'Mouvement Enregistré',
                'message' => 'Un mouvement de 150 km a été enregistré pour le véhicule ABC-123.',
                'icon' => 'fas fa-route',
                'color' => 'primary',
                'user_id' => $users->first()->id,
                'data' => ['vehicule_id' => 1, 'distance_parcourue' => 150, 'destination' => 'Douala'],
                'is_read' => false,
                'created_at' => now()->subMinutes(30)
            ],
            [
                'type' => 'maintenance_declaree',
                'model_type' => 'Maintenance',
                'model_id' => 1,
                'title' => 'Maintenance Déclarée',
                'message' => 'Une maintenance a été déclarée pour le pneu 123456789 - Motif: Usure excessive.',
                'icon' => 'fas fa-wrench',
                'color' => 'warning',
                'user_id' => $users->first()->id,
                'data' => ['pneu_id' => 1, 'motif_maintenance' => 'Usure excessive'],
                'is_read' => true,
                'read_at' => now()->subMinutes(15),
                'created_at' => now()->subMinutes(45)
            ],
            [
                'type' => 'create',
                'model_type' => 'Fournisseur',
                'model_id' => 1,
                'title' => 'Nouveau Fournisseur Ajouté',
                'message' => 'Le fournisseur Pneus Plus a été ajouté au système.',
                'icon' => 'fas fa-truck',
                'color' => 'success',
                'user_id' => $users->first()->id,
                'data' => ['nom' => 'Pneus Plus', 'telephone' => '+237 6XX XXX XXX'],
                'is_read' => false,
                'created_at' => now()->subDays(1)
            ],
            [
                'type' => 'delete',
                'model_type' => 'Pneu',
                'model_id' => null,
                'title' => 'Pneu Supprimé',
                'message' => 'Le pneu 555666777 (Bridgestone) a été supprimé du système.',
                'icon' => 'fas fa-trash',
                'color' => 'danger',
                'user_id' => $users->first()->id,
                'data' => ['numero_serie' => '555666777', 'marque' => 'Bridgestone'],
                'is_read' => true,
                'read_at' => now()->subDays(1),
                'created_at' => now()->subDays(2)
            ],
            [
                'type' => 'maintenance_validee_direction',
                'model_type' => 'Maintenance',
                'model_id' => 2,
                'title' => 'Maintenance Validée par la Direction',
                'message' => 'La maintenance du pneu 123456789 a été validée par la direction.',
                'icon' => 'fas fa-check-double',
                'color' => 'success',
                'user_id' => $users->first()->id,
                'data' => ['pneu_id' => 1, 'numero_reference' => 'REF-2024-001'],
                'is_read' => false,
                'created_at' => now()->subMinutes(10)
            ]
        ];

        foreach ($notifications as $notificationData) {
            Notification::create($notificationData);
        }

        $this->command->info('Notifications de test créées avec succès !');
    }
}
