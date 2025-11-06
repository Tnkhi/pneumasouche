<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-user-status';

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
        
        $this->info('Statut des utilisateurs:');
        $this->line('=====================================');
        
        foreach ($users as $user) {
            $status = $user->is_active ? 'ACTIF' : 'INACTIF';
            $lastActivity = $user->last_activity ? $user->last_activity->format('d/m/Y H:i:s') : 'NULL';
            $this->line("ID: {$user->id} | {$user->name} | {$user->email} | {$user->role} | {$status} | Last: {$lastActivity}");
        }
        
        $this->line('=====================================');
    }
}
