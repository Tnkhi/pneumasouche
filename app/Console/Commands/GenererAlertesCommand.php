<?php

namespace App\Console\Commands;

use App\Services\AlerteIntelligenteService;
use Illuminate\Console\Command;

class GenererAlertesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alertes:generer {--force : Forcer la génération même si des alertes similaires existent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Générer les alertes intelligentes pour analyser la flotte';

    protected $alerteService;

    public function __construct(AlerteIntelligenteService $alerteService)
    {
        parent::__construct();
        $this->alerteService = $alerteService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚨 Génération des alertes intelligentes...');
        
        try {
            $alertes = $this->alerteService->analyserEtGenererAlertes();
            $count = count($alertes);
            
            if ($count > 0) {
                $this->info("✅ {$count} nouvelles alertes générées avec succès !");
                
                // Afficher un résumé des alertes
                $this->table(
                    ['Type', 'Priorité', 'Titre'],
                    collect($alertes)->map(function($alerte) {
                        return [
                            $alerte['type'],
                            $alerte['priorite'],
                            $alerte['titre']
                        ];
                    })->toArray()
                );
            } else {
                $this->info('ℹ️  Aucune nouvelle alerte à générer.');
            }
            
            // Afficher les statistiques
            $stats = $this->alerteService->getStatistiquesAlertes();
            $this->info("\n📊 Statistiques des alertes:");
            $this->line("   • Total: {$stats['total']}");
            $this->line("   • Actives: {$stats['actives']}");
            $this->line("   • Critiques: {$stats['critiques']}");
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de la génération des alertes: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
