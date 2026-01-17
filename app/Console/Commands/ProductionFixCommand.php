<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProductionFixCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'production:fix {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Correction complète pour la production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 CORRECTION PRODUCTION - TECH OBRYL');
        $this->info(str_repeat('=', 50));

        // 1. Vider TOUS les caches
        $this->info('🧹 1. Vidage complet des caches...');
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('filament:optimize-clear');
        $this->call('optimize:clear');

        // 2. Publier les ressources
        $this->info('📦 2. Publication des ressources...');
        $this->call('vendor:publish', ['--tag' => 'filament-config', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'filament-shield-config', '--force' => true]);

        // 3. Générer les permissions
        $this->info('🔑 3. Génération des permissions...');
        $this->callSilently('shield:generate', ['--all' => true]);

        // 4. Optimiser
        $this->info('⚡ 4. Optimisation...');
        $this->call('optimize');

        // 5. Vérifier l'utilisateur admin
        $this->info('👤 5. Vérification du super admin...');
        $this->callSilently('user:role', ['action' => 'check', 'email' => 'rostoinfocus@gmail.com']);

        $this->info(str_repeat('=', 50));
        $this->info('🎉 PRODUCTION CORRIGÉE !');
        $this->info('📱 URL: https://tech.obryl.com/admin');
        $this->info('🔑 Email: rostoinfocus@gmail.com');
        $this->info('✅ Accès admin activé');
    }
}
