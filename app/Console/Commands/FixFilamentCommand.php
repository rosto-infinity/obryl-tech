<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixFilamentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament:fix {action?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Réparer les problèmes courants de Filament';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $action = $this->argument('action') ?? 'all';

        switch ($action) {
            case 'layout':
                $this->fixLayout();

                break;
            case 'links':
                $this->fixLinks();

                break;
            case 'permissions':
                $this->fixPermissions();

                break;
            case 'all':
                $this->fixAll();

                break;
            default:
                $this->error('Action non valide. Actions disponibles: layout, links, permissions, all');
                $this->showUsage();

                break;
        }
    }

    private function fixLayout(): void
    {
        $this->info('🔧 RÉPARATION DU LAYOUT FILAMENT');
        $this->info(str_repeat('=', 50));

        // 1. Créer le layout manquant
        $layoutPath = resource_path('views/components/app-layout.blade.php');
        if (! file_exists($layoutPath)) {
            $this->info('📄 Création du layout app-layout...');
            $this->createAppLayout();
        } else {
            $this->info('✅ Layout app-layout existe déjà');
        }

        // 2. Vider les caches de vues
        $this->info('🧹 Vidage des caches de vues...');
        $this->call('view:clear');

        $this->info('✅ Layout réparé avec succès!');
    }

    private function fixLinks(): void
    {
        $this->info('🔗 RÉPARATION DES LIENS FILAMENT');
        $this->info(str_repeat('=', 50));

        // 1. Vider tous les caches
        $this->info('🧹 Vidage complet des caches...');
        $this->call('optimize:clear');

        // 2. Regénérer les permissions
        $this->info('🔐 Regénération des permissions...');
        $this->call('shield:generate', ['--all' => true]);

        // 3. Recréer les caches
        $this->info('⚡ Recréation des caches...');
        $this->call('config:cache');
        $this->call('route:cache');

        $this->info('✅ Liens réparés avec succès!');
    }

    private function fixPermissions(): void
    {
        $this->info('🔐 RÉPARATION DES PERMISSIONS');
        $this->info(str_repeat('=', 50));

        // 1. Regénérer toutes les permissions
        $this->call('shield:generate', ['--all' => true]);

        // 2. Créer les rôles par défaut
        $this->info('👥 Création des rôles par défaut...');
        $this->call('db:seed', ['--class' => 'ProductionRoleSeeder']);

        // 3. Assigner les rôles aux utilisateurs
        $this->info('🔄 Assignation des rôles...');
        $this->assignRolesToUsers();

        $this->info('✅ Permissions réparées avec succès!');
    }

    private function fixAll(): void
    {
        $this->info('🚀 RÉPARATION COMPLÈTE DE FILAMENT');
        $this->info(str_repeat('=', 50));

        // 1. Réparer le layout
        $this->fixLayout();

        // 2. Réparer les liens
        $this->fixLinks();

        // 3. Réparer les permissions
        $this->fixPermissions();

        // 4. Optimisation finale
        $this->info('⚡ Optimisation finale...');
        $this->call('optimize');

        $this->info('✅ Filament réparé complètement!');
        $this->info('🌐 Accédez au panel: '.config('app.url').'/admin');
    }

    private function createAppLayout(): void
    {
        $layoutContent = <<<'BLADE'
<x-filament-panels::page>
    <div class="filament-layout">
        @livewire('filament.core.notifications')
        
        <main>
            {{ $slot }}
        </main>
    </div>
</x-filament-panels::page>
BLADE;

        file_put_contents(resource_path('views/components/app-layout.blade.php'), $layoutContent);
        $this->info('✅ Layout app-layout.blade.php créé');
    }

    private function assignRolesToUsers(): void
    {
        $this->call('tinker', [
            '--execute' => "
                use App\Models\User;
                use Spatie\Permission\Models\Role;
                
                // Assigner les rôles selon le user_type
                User::whereDoesntHave('roles')->get()->each(function(\$user) {
                    if (\$user->user_type) {
                        \$roleName = \$user->user_type->value;
                        \$role = Role::where('name', \$roleName)->first();
                        if (\$role) {
                            \$user->assignRole(\$role);
                            echo '✅ Rôle ' . \$roleName . ' assigné à ' . \$user->email . PHP_EOL;
                        }
                    }
                });
                
                // S'assurer que l'admin principal a le rôle super_admin
                \$admin = User::where('email', 'admin@obryl.tech')->first();
                if (\$admin && !\$admin->hasRole('super_admin')) {
                    \$admin->assignRole('super_admin');
                    echo '✅ Rôle super_admin assigné à admin@obryl.tech' . PHP_EOL;
                }
            ",
        ]);
    }

    private function showUsage(): void
    {
        $this->info('📖 UTILISATION:');
        $this->line('  php artisan filament:fix layout      # Réparer le layout');
        $this->line('  php artisan filament:fix links       # Réparer les liens');
        $this->line('  php artisan filament:fix permissions  # Réparer les permissions');
        $this->line('  php artisan filament:fix all         # Réparer tout (recommandé)');
    }
}
