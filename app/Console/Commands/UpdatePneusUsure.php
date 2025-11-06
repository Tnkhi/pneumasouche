<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pneu;

class UpdatePneusUsure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pneus:update-usure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mettre à jour le taux d\'usure de quelques pneus pour les tests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pneus = Pneu::where('id', '<=', 3)->get();
        
        foreach ($pneus as $pneu) {
            $pneu->update(['taux_usure' => 100]);
            $this->info("Pneu {$pneu->numero_serie} mis à jour avec taux d'usure 100%");
        }
        
        $this->info("Mise à jour terminée. {$pneus->count()} pneu(s) mis à jour.");
    }
}