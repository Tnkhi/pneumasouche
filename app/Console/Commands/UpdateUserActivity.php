<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateUserActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-activity';

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
        $users = \App\Models\User::whereNull('last_activity')->get();
        
        $this->info('Mise à jour de last_activity pour les utilisateurs...');
        
        foreach ($users as $user) {
            $user->update(['last_activity' => now()]);
            $this->line("Utilisateur {$user->name} mis à jour");
        }
        
        $this->info("Mise à jour terminée pour {$users->count()} utilisateurs");
    }
}
