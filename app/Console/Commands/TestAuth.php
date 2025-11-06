<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-auth';

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
        $this->info('Test d\'authentification...');
        
        // Test avec l'admin
        $admin = \App\Models\User::where('email', 'admin@pneumatique.com')->first();
        
        if ($admin) {
            $this->line("Utilisateur trouvé: {$admin->name} ({$admin->email})");
            $this->line("Rôle: {$admin->role}");
            $this->line("Actif: " . ($admin->is_active ? 'Oui' : 'Non'));
            $this->line("Mot de passe hashé: " . substr($admin->password, 0, 20) . '...');
            
            // Test de vérification du mot de passe
            if (\Hash::check('password', $admin->password)) {
                $this->info('✓ Le mot de passe "password" est correct');
            } else {
                $this->error('✗ Le mot de passe "password" est incorrect');
            }
            
            // Test d'authentification
            if (\Auth::attempt(['email' => 'admin@pneumatique.com', 'password' => 'password'])) {
                $this->info('✓ Authentification réussie');
                \Auth::logout();
            } else {
                $this->error('✗ Authentification échouée');
            }
        } else {
            $this->error('Utilisateur admin non trouvé');
        }
    }
}
