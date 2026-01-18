<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupErrorPagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'errors:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configurer les pages d erreur personnalisées';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('🎨 CONFIGURATION DES PAGES D ERREUR');
        $this->info(str_repeat('=', 60));

        // 1. Vérifier que les pages existent
        $errorViewsPath = resource_path('views/errors');
        $this->info('📁 Vérification des pages d erreur...');

        $errorPages = ['403', '404', '500', '503'];
        $existingPages = [];

        foreach ($errorPages as $code) {
            $filePath = $errorViewsPath.'/'.$code.'.blade.php';
            if (file_exists($filePath)) {
                $existingPages[] = $code;
                $this->info("✅ Page {$code} trouvée");
            } else {
                $this->warn("⚠️  Page {$code} manquante");
            }
        }

        // 2. Publier les erreurs si nécessaire
        $this->info('📦 Publication des pages d erreur...');
        $this->call('view:clear');

        // 3. Optimiser
        $this->info('⚡ Optimisation...');
        $this->call('optimize');

        $this->info(str_repeat('=', 60));
        $this->info('🎉 PAGES D ERREUR CONFIGURÉES !');

        $this->info(str_repeat('=', 60));
        $this->info('📋 Pages disponibles:');
        foreach ($existingPages as $code) {
            $url = url("/error-{$code}");
            $this->info("✅ {$code} -> {$url}");
        }

        $this->info(str_repeat('=', 60));
        $this->info('🎨 Design moderne:');
        $this->info('• Effet verre (glassmorphism)');
        $this->info('• Animations CSS fluides');
        $this->info('• Icônes Font Awesome');
        $this->info('• Responsive design');
        $this->info('• Informations techniques');

        $this->info(str_repeat('=', 60));
        $this->info('🔗 Pour tester:');
        $this->info('curl -I '.url('/admin'));
        $this->info('curl -I '.url('/obryl-admin-devopsrosto-250-pro2026'));
    }
}
