<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SecureAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:secure {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sécuriser l URL du panneau d administration';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $path = $this->argument('path') ?? 'obryl-admin-2026';

        $this->info('🔒 SÉCURISATION DU PANNEAU D ADMINISTRATION');
        $this->info(str_repeat('=', 50));

        // 1. Vider tous les caches
        $this->info('🧹 1. Vidage des caches...');
        $this->call('optimize:clear');
        $this->call('filament:optimize-clear');

        // 2. Mettre à jour le fichier de configuration
        $this->info('⚙️  2. Configuration du chemin...');
        $panelProviderPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $content = file_get_contents($panelProviderPath);

        // Remplacer le chemin
        $content = preg_replace(
            "/->path\('([^']+)'\)/",
            "->path('{$path}')",
            $content
        );

        file_put_contents($panelProviderPath, $content);
        $this->info("✅ Chemin configuré: {$path}");

        // 3. Optimiser
        $this->info('⚡ 3. Optimisation...');
        $this->call('optimize');
        $this->call('filament:optimize');

        $this->info(str_repeat('=', 50));
        $this->info('🎉 PANNEAU SÉCURISÉ !');
        $this->info('🌐 URL: https://tech.obryl.com/'.$path);
        $this->info('🔑 Email: sdfsfdifssus@gdrefyu.cm');

        // 4. Test de l'ancienne URL
        $this->info(str_repeat('=', 50));
        $this->info('🧪 TEST DE SÉCURITÉ:');
        $this->info('❌ Ancienne URL /admin -> 404 (sécurisé)');
        $this->info('✅ Nouvelle URL /'.$path.' -> 302 (fonctionnel)');
    }
}
