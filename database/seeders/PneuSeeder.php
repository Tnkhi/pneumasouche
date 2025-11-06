<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PneuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pneus = [
            [
                'numero_serie' => 'MIC-001-2024',
                'prix_achat' => 85000,
                'date_montage' => '2024-01-15',
                'fournisseur_id' => 1,
                'marque' => 'Michelin',
                'largeur' => 215,
                'hauteur_flanc' => 70,
                'diametre_interieur' => 16,
                'indice_vitesse' => 'H',
                'indice_charge' => '100',
                'duree_vie' => 80000,
                'kilometrage' => 15000,
                'vehicule_id' => 1
            ],
            [
                'numero_serie' => 'BRI-002-2024',
                'prix_achat' => 75000,
                'date_montage' => '2024-02-20',
                'fournisseur_id' => 2,
                'marque' => 'Bridgestone',
                'largeur' => 225,
                'hauteur_flanc' => 65,
                'diametre_interieur' => 17,
                'indice_vitesse' => 'V',
                'indice_charge' => '102',
                'duree_vie' => 90000,
                'kilometrage' => 25000,
                'vehicule_id' => 2
            ],
            [
                'numero_serie' => 'GOO-003-2024',
                'prix_achat' => 65000,
                'date_montage' => '2024-03-10',
                'fournisseur_id' => 3,
                'marque' => 'Goodyear',
                'largeur' => 205,
                'hauteur_flanc' => 75,
                'diametre_interieur' => 15,
                'indice_vitesse' => 'T',
                'indice_charge' => '95',
                'duree_vie' => 70000,
                'kilometrage' => 35000,
                'vehicule_id' => 3
            ],
            [
                'numero_serie' => 'CON-004-2024',
                'prix_achat' => 95000,
                'date_montage' => '2024-04-05',
                'fournisseur_id' => 4,
                'marque' => 'Continental',
                'largeur' => 235,
                'hauteur_flanc' => 60,
                'diametre_interieur' => 18,
                'indice_vitesse' => 'W',
                'indice_charge' => '105',
                'duree_vie' => 100000,
                'kilometrage' => 5000,
                'vehicule_id' => 4
            ],
            [
                'numero_serie' => 'MIC-005-2024',
                'prix_achat' => 80000,
                'date_montage' => '2024-05-12',
                'fournisseur_id' => 1,
                'marque' => 'Michelin',
                'largeur' => 245,
                'hauteur_flanc' => 70,
                'diametre_interieur' => 16,
                'indice_vitesse' => 'H',
                'indice_charge' => '110',
                'duree_vie' => 85000,
                'kilometrage' => 12000,
                'vehicule_id' => 5
            ]
        ];

        foreach ($pneus as $pneu) {
            \App\Models\Pneu::create($pneu);
        }
    }
}
