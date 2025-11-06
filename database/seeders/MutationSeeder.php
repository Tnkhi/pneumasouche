<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mutations = [
            [
                'pneu_id' => 1,
                'vehicule_source_id' => null, // Montage initial
                'vehicule_destination_id' => 1,
                'date_mutation' => '2024-01-15',
                'motif' => 'Montage initial',
                'kilometrage_au_moment_mutation' => '0 km',
                'operateur' => 'Jean Kouassi',
                'observations' => 'Montage initial du pneu neuf'
            ],
            [
                'pneu_id' => 2,
                'vehicule_source_id' => null, // Montage initial
                'vehicule_destination_id' => 2,
                'date_mutation' => '2024-02-20',
                'motif' => 'Montage initial',
                'kilometrage_au_moment_mutation' => '0 km',
                'operateur' => 'Marie Traoré',
                'observations' => 'Montage initial du pneu neuf'
            ],
            [
                'pneu_id' => 3,
                'vehicule_source_id' => null, // Montage initial
                'vehicule_destination_id' => 3,
                'date_mutation' => '2024-03-10',
                'motif' => 'Montage initial',
                'kilometrage_au_moment_mutation' => '0 km',
                'operateur' => 'Pierre Koné',
                'observations' => 'Montage initial du pneu neuf'
            ],
            [
                'pneu_id' => 1,
                'vehicule_source_id' => 1,
                'vehicule_destination_id' => 2,
                'date_mutation' => '2024-06-15',
                'motif' => 'Optimisation du parc',
                'kilometrage_au_moment_mutation' => '15000 km',
                'operateur' => 'Jean Kouassi',
                'observations' => 'Mutation pour optimiser l\'utilisation des pneus'
            ],
            [
                'pneu_id' => 2,
                'vehicule_source_id' => 2,
                'vehicule_destination_id' => 4,
                'date_mutation' => '2024-08-20',
                'motif' => 'Maintenance préventive',
                'kilometrage_au_moment_mutation' => '25000 km',
                'operateur' => 'Marie Traoré',
                'observations' => 'Mutation pour maintenance préventive'
            ],
            [
                'pneu_id' => 4,
                'vehicule_source_id' => null, // Montage initial
                'vehicule_destination_id' => 4,
                'date_mutation' => '2024-04-05',
                'motif' => 'Montage initial',
                'kilometrage_au_moment_mutation' => '0 km',
                'operateur' => 'Fatou Ouattara',
                'observations' => 'Montage initial du pneu neuf'
            ],
            [
                'pneu_id' => 5,
                'vehicule_source_id' => null, // Montage initial
                'vehicule_destination_id' => 5,
                'date_mutation' => '2024-05-12',
                'motif' => 'Montage initial',
                'kilometrage_au_moment_mutation' => '0 km',
                'operateur' => 'Amadou Diallo',
                'observations' => 'Montage initial du pneu neuf'
            ]
        ];

        foreach ($mutations as $mutation) {
            \App\Models\Mutation::create($mutation);
        }
    }
}
