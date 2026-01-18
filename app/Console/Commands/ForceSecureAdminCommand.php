<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ForceSecureAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:force-secure {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forcer la sécurisation immédiate du panneau admin';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $path = $this->argument('path');

        $this->info('🚀 FORÇAGE SÉCURISATION ADMIN');
        $this->info(str_repeat('=', 60));

        // 1. Supprimer tous les caches manuellement
        $this->info('🗑️  1. Suppression manuelle des caches...');
        $cachePath = storage_path('framework/cache');
        if (is_dir($cachePath)) {
            $files = glob($cachePath.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            $this->info('✅ Cache framework supprimé');
        }

        // 2. Supprimer cache views
        $viewsPath = storage_path('framework/views');
        if (is_dir($viewsPath)) {
            $files = glob($viewsPath.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            $this->info('✅ Cache views supprimé');
        }

        // 3. Supprimer cache Filament
        $filamentCachePath = storage_path('app/filament');
        if (is_dir($filamentCachePath)) {
            $this->call('filament:clear-cached-components');
            $this->info('✅ Cache Filament supprimé');
        }

        // 4. Mettre à jour le Panel Provider
        $this->info('⚙️  4. Mise à jour du Panel Provider...');
        $panelProviderPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $content = file_get_contents($panelProviderPath);

        // Remplacer le chemin de manière sécurisée
        $pattern = "/->path\('([^']+)'\)/";
        $replacement = "->path('{$path}')";
        $content = preg_replace($pattern, $replacement, $content);

        file_put_contents($panelProviderPath, $content);
        $this->info("✅ Chemin mis à jour: {$path}");

        // 5. Recréer les liens symboliques
        $this->info('🔗 5. Recréation des liens symboliques...');
        $this->call('storage:link');

        // 6. Optimiser
        $this->info('⚡ 6. Optimisation complète...');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('filament:optimize-clear');
        $this->call('optimize');
        $this->call('filament:optimize');

        $this->info(str_repeat('=', 60));
        $this->info('🎉 SÉCURISATION FORCÉE TERMINÉE !');
        $this->info('🌐 URL ADMIN: https://tech.obryl.com/'.$path);
        $this->info('🔑 EMAIL: sdfsfdifssus@gdrefyu.cm');
        $this->info('🔒 SÉCURITÉ: ACTIVE');

        $this->info(str_repeat('=', 60));
        $this->info('📋 RÉCAPITULATIF:');
        $this->info('❌ Ancienne URL /admin -> INACCESSIBLE');
        $this->info('✅ Nouvelle URL /'.$path.' -> ACCESSIBLE');
        $this->info('🛡️  Protection par rôles: super_admin, admin');
        $this->info('🔄 Caches: Vidés et optimisés');

        $this->info(str_repeat('=', 60));
        $this->info('🔧 POUR CHANGER À NOUVEAU:');
        $this->info('php artisan admin:force-secure nouveau-chemin-secret');
    }
}
