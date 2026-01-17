<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixProductionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:production {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corriger les problèmes Filament en production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('⚠️  Cette commande va corriger les problèmes Filament en production. Continuer?')) {
                $this->info('❌ Opération annulée');
                return;
            }
        }

        $this->info('🔧 RÉPARATION FILAMENT PRODUCTION');
        $this->info(str_repeat('=', 50));

        // 1. Vider tous les caches
        $this->info('🧹 1. Vidage des caches...');
        $this->call('optimize:clear');
        $this->call('filament:cache-clear');

        // 2. Publier les ressources Filament
        $this->info('📦 2. Publication des ressources Filament...');
        $this->call('vendor:publish', ['--tag' => 'filament-config']);
        $this->call('vendor:publish', ['--tag' => 'filament-translations']);
        $this->call('vendor:publish', ['--tag' => 'filament-views']);

        // 3. Publier les ressources Filament Shield
        $this->info('🛡️ 3. Publication des ressources Filament Shield...');
        $this->call('vendor:publish', ['--tag' => 'filament-shield-config']);
        $this->call('vendor:publish', ['--tag' => 'filament-shield-views']);

        // 4. Générer les permissions
        $this->info('🔑 4. Génération des permissions...');
        $this->call('shield:generate', ['--all' => true]);

        // 5. Créer le super admin
        $this->info('👑 5. Configuration du super admin...');
        $this->call('shield:super-admin');

        // 6. Optimiser à nouveau
        $this->info('⚡ 6. Optimisation...');
        $this->call('optimize');

        // 7. Vérifier les permissions
        $this->info('🔍 7. Vérification des permissions...');
        $this->call('shield:check');

        $this->info(str_repeat('=', 50));
        $this->info('🎉 PRODUCTION CORRIGÉE !');
        $this->info('📱 Accédez à: https://tech.obryl.com/admin');
        $this->info('🔑 Utilisez votre email et mot de passe habituels');
    }
}
