<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-users';

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
        
        $this->info('Utilisateurs dans la base de données:');
        $this->line('=====================================');
        
        foreach ($users as $user) {
            $this->line("ID: {$user->id} | Nom: {$user->name} | Email: {$user->email} | Rôle: {$user->role}");
        }
        
        $this->line('=====================================');
        $this->info("Total: {$users->count()} utilisateurs");
    }
}
