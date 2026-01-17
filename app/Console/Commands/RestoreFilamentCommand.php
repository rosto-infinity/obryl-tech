<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RestoreFilamentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restore:filament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restaurer complètement le panel Filament en production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 RESTAURATION COMPLÈTE DU PANEL FILAMENT');
        $this->info(str_repeat('=', 60));
        
        if (!$this->confirm('⚠️  Ceci va réinitialiser complètement Filament. Continuer?')) {
            $this->info('❌ Opération annulée');
            return;
        }

        // 1. Vider tous les caches
        $this->info('🧹 ÉTAPE 1/6: Vidage complet des caches...');
        $this->call('optimize:clear');
        
        // 2. Recréer les permissions Shield
        $this->info('🔐 ÉTAPE 2/6: Regénération des permissions Shield...');
        $this->call('shield:generate', ['--all' => true]);
        
        // 3. Recréer les rôles
        $this->info('👥 ÉTAPE 3/6: Recréation des rôles...');
        $this->call('db:seed', ['--class' => 'ProductionRoleSeeder', '--force' => true]);
        
        // 4. Publier les ressources Filament
        $this->info('📦 ÉTAPE 4/6: Publication des ressources Filament...');
        $this->call('vendor:publish', [
            '--tag' => 'filament-shield-config',
            '--force' => true
        ]);
        
        // 5. Recréer les liens de navigation
        $this->info('🔗 ÉTAPE 5/6: Recréation des liens de navigation...');
        $this->recreateNavigation();
        
        // 6. Optimisation finale
        $this->info('⚡ ÉTAPE 6/6: Optimisation finale...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        
        $this->info(str_repeat('=', 60));
        $this->info('✅ PANEL FILAMENT RESTAURÉ AVEC SUCCÈS!');
        $this->info('🌐 Accédez au panel: ' . config('app.url') . '/admin');
        $this->info('👤 Email: admin@obryl.tech');
        $this->info('🔐 Rôle: super_admin');
    }

    private function recreateNavigation()
    {
        $this->call('tinker', [
            '--execute' => "
                use App\Models\User;
                use Spatie\Permission\Models\Role;
                
                // S'assurer que tous les utilisateurs ont les bons rôles
                User::whereDoesntHave('roles')->get()->each(function(\$user) {
                    if (\$user->user_type) {
                        \$roleName = \$user->user_type->value;
                        \$role = Role::where('name', \$roleName)->first();
                        if (\$role) {
                            \$user->assignRole(\$roleName);
                            
                            // Ajouter le rôle admin si super_admin
                            if (\$roleName === 'super_admin') {
                                \$adminRole = Role::where('name', 'admin')->first();
                                if (\$adminRole) {
                                    \$user->assignRole('admin');
                                }
                            }
                        }
                    }
                });
                
                // S'assurer que l'admin principal a le bon rôle
                \$admin = User::where('email', 'admin@obryl.tech')->first();
                if (\$admin) {
                    \$admin->assignRole('super_admin');
                    \$admin->assignRole('admin');
                }
                
                echo '✅ Navigation recréée avec succès' . PHP_EOL;
            "
        ]);
    }
}
