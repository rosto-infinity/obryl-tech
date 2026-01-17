<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PublishFilamentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament:publish {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publier toutes les ressources Filament';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('📦 PUBLICATION DES RESSOURCES FILAMENT');
        $this->info(str_repeat('=', 50));

        // 1. Configurations Filament
        $this->info('⚙️ 1. Publication des configurations Filament...');
        $this->call('vendor:publish', ['--tag' => 'filament-config']);
        $this->call('vendor:publish', ['--tag' => 'filament-config', '--force' => true]);

        // 2. Vues Filament
        $this->info('🎨 2. Publication des vues Filament...');
        $this->call('vendor:publish', ['--tag' => 'filament-views']);
        $this->call('vendor:publish', ['--tag' => 'filament-views', '--force' => true]);

        // 3. Traductions Filament
        $this->info('🌍 3. Publication des traductions Filament...');
        $this->call('vendor:publish', ['--tag' => 'filament-translations']);
        $this->call('vendor:publish', ['--tag' => 'filament-translations', '--force' => true]);

        // 4. Assets Filament
        $this->info('🎯 4. Publication des assets Filament...');
        $this->call('vendor:publish', ['--tag' => 'filament-assets']);
        $this->call('vendor:publish', ['--tag' => 'filament-assets', '--force' => true]);

        if ($this->option('all')) {
            // 5. Configurations Filament Shield
            $this->info('🛡️ 5. Publication des configurations Filament Shield...');
            $this->call('vendor:publish', ['--tag' => 'filament-shield-config']);
            $this->call('vendor:publish', ['--tag' => 'filament-shield-config', '--force' => true]);

            // 6. Vues Filament Shield
            $this->info('🔐 6. Publication des vues Filament Shield...');
            $this->call('vendor:publish', ['--tag' => 'filament-shield-views']);
            $this->call('vendor:publish', ['--tag' => 'filament-shield-views', '--force' => true]);

            // 7. Permissions
            $this->info('🔑 7. Génération des permissions...');
            $this->call('shield:generate', ['--all' => true]);

            // 8. Super Admin
            $this->info('👑 8. Configuration du super admin...');
            $this->call('shield:super-admin');
        }

        // 9. Optimiser
        $this->info('⚡ 9. Optimisation...');
        $this->call('optimize');

        $this->info(str_repeat('=', 50));
        $this->info('🎉 RESSOURCES FILAMENT PUBLIÉES !');

        if ($this->option('all')) {
            $this->info('🔐 Permissions Filament Shield configurées');
            $this->info('👑 Super admin configuré');
        }

        $this->info('📱 Accédez à: /admin');
    }
}
