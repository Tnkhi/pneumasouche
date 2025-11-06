<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'Douala, Cameroun',
            'Yaoundé, Cameroun', 
            'Garoua, Cameroun',
            'Bafoussam, Cameroun',
            'Bamenda, Cameroun',
            'Maroua, Cameroun',
            'Ngaoundéré, Cameroun',
            'Bertoua, Cameroun',
            'Ebolowa, Cameroun',
            'Kumba, Cameroun'
        ];

        $vehicules = \App\Models\Vehicule::whereNull('position_actuelle')->get();
        
        foreach ($vehicules as $vehicule) {
            $vehicule->update([
                'position_actuelle' => $positions[array_rand($positions)]
            ]);
        }

        $this->command->info('Positions actuelles ajoutées à ' . $vehicules->count() . ' véhicules.');
    }
}
