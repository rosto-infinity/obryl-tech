<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class FilamentLinksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament:links {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gérer les liens dans le panel Filament';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        
        switch ($action) {
            case 'check':
                $this->checkLinks();
                break;
            case 'fix':
                $this->fixLinks();
                break;
            case 'reset':
                $this->resetLinks();
                break;
            default:
                $this->error('Action non valide. Actions disponibles: check, fix, reset');
                $this->showUsage();
                break;
        }
    }

    private function checkLinks()
    {
        $this->info('🔍 VÉRIFICATION DES LIENS FILAMENT');
        $this->info(str_repeat('=', 50));
        
        // Vérifier les ressources Filament
        $resourcesPath = app_path('Filament/Resources');
        if (is_dir($resourcesPath)) {
            $resources = glob($resourcesPath . '/*Resource.php');
            $this->info('📁 Ressources trouvées: ' . count($resources));
            
            foreach ($resources as $resource) {
                $className = basename($resource, '.php');
                $this->line("  • $className");
            }
        } else {
            $this->warn('⚠️  Dossier Resources non trouvé');
        }
        
        // Vérifier les pages Filament
        $pagesPath = app_path('Filament/Pages');
        if (is_dir($pagesPath)) {
            $pages = glob($pagesPath . '/*.php');
            $this->info('📄 Pages trouvées: ' . count($pages));
            
            foreach ($pages as $page) {
                $className = basename($page, '.php');
                $this->line("  • $className");
            }
        } else {
            $this->warn('⚠️  Dossier Pages non trouvé');
        }
        
        // Vérifier la configuration
        $configFile = config_path('filament.php');
        if (file_exists($configFile)) {
            $this->info('✅ Fichier de configuration trouvé');
        } else {
            $this->warn('⚠️  Fichier de configuration non trouvé');
        }
        
        $this->info(str_repeat('=', 50));
    }

    private function fixLinks()
    {
        $this->info('🔧 RÉPARATION DES LIENS FILAMENT');
        $this->info(str_repeat('=', 50));
        
        // Vider les caches
        $this->info('🧹 Vidage des caches...');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('cache:clear');
        
        // Optimiser
        $this->info('⚡ Optimisation...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        
        // Vider le cache Filament
        $this->info('🎯 Vidage du cache Filament...');
        $this->call('filament:cache-clear');
        
        $this->info('✅ Liens Filament réparés avec succès!');
    }

    private function resetLinks()
    {
        $this->info('🔄 RÉINITIALISATION COMPLÈTE DES LIENS');
        $this->info(str_repeat('=', 50));
        
        if (!$this->confirm('⚠️  Ceci va réinitialiser complètement Filament. Continuer?')) {
            $this->info('❌ Opération annulée');
            return;
        }
        
        // Vider tous les caches
        $this->call('optimize:clear');
        
        // Recréer les caches
        $this->call('optimize');
        
        // Publier les assets
        $this->call('vendor:publish', ['--tag' => 'filament-config', '--force']);
        $this->call('vendor:publish', ['--tag' => 'filament-assets', '--force']);
        
        $this->info('✅ Filament réinitialisé avec succès!');
        $this->info('🌐 Accédez au panel: ' . config('app.url') . '/admin');
    }

    private function showUsage()
    {
        $this->info('📖 UTILISATION:');
        $this->line('  php artisan filament:links check    # Vérifier les liens');
        $this->line('  php artisan filament:links fix      # Réparer les liens');
        $this->line('  php artisan filament:links reset    # Réinitialiser complètement');
    }
}
