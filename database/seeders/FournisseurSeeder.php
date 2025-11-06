<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FournisseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fournisseurs = [
            [
                'nom' => 'Michelin Afrique',
                'contact' => 'Jean Dupont',
                'telephone' => '+225 20 30 40 50',
                'email' => 'contact@michelin-afrique.com',
                'adresse' => 'Abidjan, Côte d\'Ivoire',
                'nombre_pneus_fournis' => 0,
                'notes' => 'Aucun pneu fourni'
            ],
            [
                'nom' => 'Bridgestone Distribution',
                'contact' => 'Marie Kouassi',
                'telephone' => '+225 20 30 40 51',
                'email' => 'info@bridgestone-ci.com',
                'adresse' => 'Cocody, Abidjan',
                'nombre_pneus_fournis' => 0,
                'notes' => 'Aucun pneu fourni'
            ],
            [
                'nom' => 'Goodyear Import',
                'contact' => 'Pierre Koné',
                'telephone' => '+225 20 30 40 52',
                'email' => 'ventes@goodyear-ci.com',
                'adresse' => 'Marcory, Abidjan',
                'nombre_pneus_fournis' => 0,
                'notes' => 'Aucun pneu fourni'
            ],
            [
                'nom' => 'Continental Tires',
                'contact' => 'Fatou Traoré',
                'telephone' => '+225 20 30 40 53',
                'email' => 'contact@continental-ci.com',
                'adresse' => 'Plateau, Abidjan',
                'nombre_pneus_fournis' => 0,
                'notes' => 'Aucun pneu fourni'
            ]
        ];

        foreach ($fournisseurs as $fournisseur) {
            \App\Models\Fournisseur::create($fournisseur);
        }
    }
}
