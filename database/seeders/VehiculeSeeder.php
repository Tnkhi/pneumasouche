<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicules = [
            [
                'immatriculation' => 'CI-123-AB',
                'marque' => 'Toyota',
                'modele' => 'Hilux',
                'annee' => 2020,
                'type_vehicule' => 'Pick-up',
                'description' => 'Véhicule de transport de marchandises',
                'chauffeur' => 'Jean Kouassi',
                'nombre_pneus' => 0
            ],
            [
                'immatriculation' => 'CI-456-CD',
                'marque' => 'Mercedes',
                'modele' => 'Sprinter',
                'annee' => 2019,
                'type_vehicule' => 'Fourgon',
                'description' => 'Véhicule de livraison',
                'chauffeur' => 'Marie Traoré',
                'nombre_pneus' => 0
            ],
            [
                'immatriculation' => 'CI-789-EF',
                'marque' => 'Ford',
                'modele' => 'Transit',
                'annee' => 2021,
                'type_vehicule' => 'Fourgon',
                'description' => 'Véhicule de transport léger',
                'chauffeur' => 'Pierre Koné',
                'nombre_pneus' => 0
            ],
            [
                'immatriculation' => 'CI-321-GH',
                'marque' => 'Isuzu',
                'modele' => 'NPR',
                'annee' => 2018,
                'type_vehicule' => 'Camion',
                'description' => 'Camion de transport lourd',
                'chauffeur' => 'Fatou Ouattara',
                'nombre_pneus' => 0
            ],
            [
                'immatriculation' => 'CI-654-IJ',
                'marque' => 'Nissan',
                'modele' => 'Navara',
                'annee' => 2022,
                'type_vehicule' => 'Pick-up',
                'description' => 'Véhicule utilitaire',
                'chauffeur' => 'Amadou Diallo',
                'nombre_pneus' => 0
            ]
        ];

        foreach ($vehicules as $vehicule) {
            \App\Models\Vehicule::create($vehicule);
        }
    }
}
