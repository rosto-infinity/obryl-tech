<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FilamentShieldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament:shield {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gérer Filament Shield et les permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        
        switch ($action) {
            case 'install':
                $this->install();
                break;
            case 'setup':
                $this->setup();
                break;
            case 'generate':
                $this->generate();
                break;
            case 'publish':
                $this->publish();
                break;
            case 'reset':
                $this->reset();
                break;
            case 'status':
                $this->status();
                break;
            default:
                $this->error('Action non valide. Actions disponibles: install, setup, generate, publish, reset, status');
                $this->showUsage();
                break;
        }
    }

    private function install()
    {
        $this->info('🚀 INSTALLATION DE FILAMENT SHIELD');
        $this->info(str_repeat('=', 50));
        
        // 1. Publier la configuration
        $this->info('📦 Publication de la configuration...');
        $this->call('vendor:publish', [
            '--tag' => 'filament-shield-config',
            '--force' => true
        ]);
        
        // 2. Publier les migrations
        $this->info('🗄️  Publication des migrations...');
        $this->call('vendor:publish', [
            '--tag' => 'filament-shield-migrations',
            '--force' => true
        ]);
        
        // 3. Exécuter les migrations
        $this->info('⚡ Exécution des migrations...');
        $this->call('migrate', ['--force' => true]);
        
        // 4. Créer les permissions
        $this->info('🔐 Création des permissions...');
        $this->call('shield:generate', ['--all' => true]);
        
        // 5. Optimiser
        $this->info('⚡ Optimisation...');
        $this->call('optimize:clear');
        $this->call('optimize');
        
        $this->info('✅ Filament Shield installé avec succès!');
    }

    private function setup()
    {
        $this->info('🔧 CONFIGURATION DE FILAMENT SHIELD');
        $this->info(str_repeat('=', 50));
        
        // 1. Vider les caches
        $this->info('🧹 Vidage des caches...');
        $this->call('optimize:clear');
        
        // 2. Regénérer les permissions
        $this->info('🔐 Regénération des permissions...');
        $this->call('shield:generate', ['--all' => true]);
        
        // 3. Publier les ressources
        $this->info('📦 Publication des ressources...');
        $this->call('shield:publish');
        
        // 4. Optimiser
        $this->info('⚡ Optimisation...');
        $this->call('optimize');
        
        $this->info('✅ Filament Shield configuré avec succès!');
    }

    private function generate()
    {
        $this->info('🔐 GÉNÉRATION DES PERMISSIONS');
        $this->info(str_repeat('=', 50));
        
        // Générer toutes les permissions
        $this->call('shield:generate', ['--all' => true]);
        
        // Créer les permissions personnalisées
        $this->info('🎯 Création des permissions personnalisées...');
        $this->createCustomPermissions();
        
        $this->info('✅ Permissions générées avec succès!');
    }

    private function publish()
    {
        $this->info('📦 PUBLICATION DES RESSOURCES SHIELD');
        $this->info(str_repeat('=', 50));
        
        // Publier les ressources
        $this->call('shield:publish');
        
        // Publier les vues
        $this->call('vendor:publish', [
            '--tag' => 'filament-shield-views',
            '--force' => true
        ]);
        
        $this->info('✅ Ressources publiées avec succès!');
    }

    private function reset()
    {
        $this->info('🔄 RÉINITIALISATION DE FILAMENT SHIELD');
        $this->info(str_repeat('=', 50));
        
        if (!$this->confirm('⚠️  Ceci va réinitialiser complètement Filament Shield. Continuer?')) {
            $this->info('❌ Opération annulée');
            return;
        }
        
        // 1. Vider les caches
        $this->call('optimize:clear');
        
        // 2. Republier la configuration
        $this->call('vendor:publish', [
            '--tag' => 'filament-shield-config',
            '--force' => true
        ]);
        
        // 3. Recréer les permissions
        $this->call('shield:generate', ['--all' => true, '--fresh' => true]);
        
        // 4. Optimiser
        $this->call('optimize');
        
        $this->info('✅ Filament Shield réinitialisé avec succès!');
    }

    private function status()
    {
        $this->info('📊 ÉTAT DE FILAMENT SHIELD');
        $this->info(str_repeat('=', 50));
        
        // Vérifier si le package est installé
        if (class_exists('BezhanSalleh\FilamentShield\FilamentShieldPlugin')) {
            $this->info('✅ Filament Shield est installé');
        } else {
            $this->warn('⚠️  Filament Shield n\'est pas installé');
            return;
        }
        
        // Vérifier les permissions
        $this->call('tinker', [
            '--execute' => "
                echo 'Permissions: ' . \Spatie\Permission\Models\Permission::count() . PHP_EOL;
                echo 'Rôles: ' . \Spatie\Permission\Models\Role::count() . PHP_EOL;
                echo 'Utilisateurs avec rôles: ' . \App\Models\User::whereHas('roles')->count() . PHP_EOL;
            "
        ]);
        
        // Vérifier la configuration
        $configFile = config_path('filament-shield.php');
        if (file_exists($configFile)) {
            $this->info('✅ Fichier de configuration trouvé');
        } else {
            $this->warn('⚠️  Fichier de configuration non trouvé');
        }
        
        // Vérifier les ressources
        $resourcesPath = app_path('Filament/Resources');
        if (is_dir($resourcesPath)) {
            $resources = glob($resourcesPath . '/*Resource.php');
            $this->info('📁 Ressources trouvées: ' . count($resources));
        }
        
        $this->info(str_repeat('=', 50));
    }

    private function createCustomPermissions()
    {
        $this->call('tinker', [
            '--execute' => "
                use Spatie\Permission\Models\Permission;
                
                \$customPermissions = [
                    'ViewAny:WorkloadManagement',
                    'View:WorkloadManagement',
                    'Create:WorkloadManagement',
                    'Update:WorkloadManagement',
                    'Delete:WorkloadManagement',
                ];
                
                foreach (\$customPermissions as \$permission) {
                    Permission::firstOrCreate(['name' => \$permission]);
                }
                
                echo '✅ Permissions personnalisées créées: ' . count(\$customPermissions) . PHP_EOL;
            "
        ]);
    }

    private function showUsage()
    {
        $this->info('📖 UTILISATION:');
        $this->line('  php artisan filament:shield install   # Installation complète');
        $this->line('  php artisan filament:shield setup     # Configuration rapide');
        $this->line('  php artisan filament:shield generate  # Générer les permissions');
        $this->line('  php artisan filament:shield publish   # Publier les ressources');
        $this->line('  php artisan filament:shield reset     # Réinitialiser complètement');
        $this->line('  php artisan filament:shield status    # Vérifier l\'état');
    }
}
