<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShieldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shield:setup {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configuration complète de Filament Shield';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            $this->setupUser($email);
        } else {
            $this->setupAll();
        }
    }

    private function setupUser($email)
    {
        $this->info("🛡️ CONFIGURATION SHIELD POUR: $email");
        $this->info(str_repeat('=', 50));
        
        // 1. Générer les permissions
        $this->info("🔐 Génération des permissions...");
        $this->call('shield:generate', ['--all' => true]);
        
        // 2. Publier les ressources
        $this->info("📦 Publication des ressources...");
        $this->call('shield:publish');
        
        // 3. Assigner le rôle super_admin
        $this->info("👤 Attribution du rôle super_admin...");
        $this->call('fix:superadmin', [$email]);
        
        $this->info(str_repeat('=', 50));
        $this->info("✅ SHIELD CONFIGURÉ POUR $email !");
    }

    private function setupAll()
    {
        $this->info("🛡️ CONFIGURATION COMPLÈTE DE FILAMENT SHIELD");
        $this->info(str_repeat('=', 60));
        
        // 1. Vider les caches
        $this->info("🧹 Vidage des caches...");
        $this->call('optimize:clear');
        
        // 2. Générer toutes les permissions
        $this->info("🔐 Génération des permissions...");
        $this->call('shield:generate', ['--all' => true]);
        
        // 3. Publier les ressources
        $this->info("📦 Publication des ressources...");
        $this->call('shield:publish');
        
        // 4. Recréer les rôles
        $this->info("👥 Recréation des rôles...");
        $this->call('db:seed', ['--class' => 'ProductionRoleSeeder', '--force' => true]);
        
        // 5. Corriger tous les utilisateurs
        $this->info("🔧 Correction des utilisateurs...");
        $this->call('fix:production');
        
        // 6. Optimiser
        $this->info("⚡ Optimisation finale...");
        $this->call('optimize');
        
        $this->info(str_repeat('=', 60));
        $this->info("🎉 FILAMENT SHIELD CONFIGURÉ AVEC SUCCÈS !");
        $this->info("🌐 Accédez au panel: " . config('app.url') . '/admin');
    }
}
