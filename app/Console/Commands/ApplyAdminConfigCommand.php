<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApplyAdminConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:apply-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Appliquer la configuration admin depuis .env.admin';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('🔧 APPLICATION CONFIGURATION ADMIN');
        $this->info(str_repeat('=', 60));

        // 1. Lire la configuration depuis .env.admin
        $envAdminPath = base_path('.env.admin');
        if (! file_exists($envAdminPath)) {
            $this->error('❌ Fichier .env.admin non trouvé');

            return;
        }

        $adminPath = null;
        $lines = file($envAdminPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with($line, 'ADMIN_PATH=')) {
                $adminPath = trim(str_replace('ADMIN_PATH=', '', $line));

                break;
            }
        }

        if (! $adminPath) {
            $this->error('❌ ADMIN_PATH non trouvé dans .env.admin');

            return;
        }

        $this->info("📋 Chemin admin trouvé: {$adminPath}");

        // 2. Mettre à jour le Panel Provider
        $this->info('⚙️  Mise à jour du Panel Provider...');
        $panelProviderPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $content = file_get_contents($panelProviderPath);

        // Remplacer la configuration
        $pattern = "/->path\(config\('app\.admin_path', '[^']+'\)\)/";
        $replacement = "->path(config('app.admin_path', '{$adminPath}'))";
        $content = preg_replace($pattern, $replacement, $content);

        file_put_contents($panelProviderPath, $content);
        $this->info("✅ Panel Provider mis à jour avec: {$adminPath}");

        // 3. Vider les caches
        $this->info('🧹 Vidage des caches...');
        $this->call('optimize:clear');
        $this->call('filament:optimize-clear');

        // 4. Optimiser
        $this->info('⚡ Optimisation...');
        $this->call('optimize');
        $this->call('filament:optimize');

        $this->info(str_repeat('=', 60));
        $this->info('🎉 CONFIGURATION APPLIQUÉE !');
        $this->info('🌐 URL: https://tech.obryl.com/'.$adminPath);
        $this->info('🔑 Email: sdfsfdifssus@gdrefyu.cm');

        $this->info(str_repeat('=', 60));
        $this->info('📋 UTILISATION:');
        $this->info('1. Modifier .env.admin pour changer le chemin');
        $this->info('2. Lancer: php artisan admin:apply-config');
        $this->info('3. Attendre la propagation du cache production');
    }
}
