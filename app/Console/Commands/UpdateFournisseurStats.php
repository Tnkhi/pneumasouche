<?php

namespace App\Console\Commands;

use App\Models\Fournisseur;
use Illuminate\Console\Command;

class UpdateFournisseurStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fournisseurs:update-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour les statistiques de tous les fournisseurs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mise à jour des statistiques des fournisseurs...');
        
        $fournisseurs = Fournisseur::all();
        $count = 0;
        
        foreach ($fournisseurs as $fournisseur) {
            $fournisseur->save(); // Cela déclenchera le recalcul automatique
            $count++;
        }
        
        $this->info("Statistiques mises à jour pour {$count} fournisseurs.");
        
        return 0;
    }
}
