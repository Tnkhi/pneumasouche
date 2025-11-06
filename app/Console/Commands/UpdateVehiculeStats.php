<?php

namespace App\Console\Commands;

use App\Models\Vehicule;
use Illuminate\Console\Command;

class UpdateVehiculeStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicules:update-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour les statistiques de tous les véhicules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mise à jour des statistiques des véhicules...');
        
        $vehicules = Vehicule::all();
        $count = 0;
        
        foreach ($vehicules as $vehicule) {
            $vehicule->save(); // Cela déclenchera le recalcul automatique
            $count++;
        }
        
        $this->info("Statistiques mises à jour pour {$count} véhicules.");
        
        return 0;
    }
}
