<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetUserActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-user-activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::all();
        
        $this->info('Réinitialisation de last_activity pour tous les utilisateurs...');
        
        foreach ($users as $user) {
            $user->update(['last_activity' => now()]);
            $this->line("Utilisateur {$user->name} mis à jour");
        }
        
        $this->info("Réinitialisation terminée pour {$users->count()} utilisateurs");
    }
}
