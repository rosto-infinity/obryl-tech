<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class FixProductionRolesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:production {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corriger les rôles en production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            $this->fixUser($email);
        } else {
            $this->fixAllUsers();
        }
    }

    private function fixUser($email)
    {
        $this->info("🔧 CORRECTION DES RÔLES POUR: $email");
        $this->info(str_repeat('=', 50));
        
        $user = User::with('roles')->where('email', $email)->first();
        if (!$user) {
            $this->error("❌ Utilisateur '$email' non trouvé");
            return;
        }

        // Afficher l'état actuel
        $currentRoles = $user->roles->pluck('name')->implode(', ') ?: 'Aucun';
        $userType = $user->user_type ? $user->user_type->value : 'N/A';
        
        $this->line("👤 Email: $user->email");
        $this->line("🏷️  Type: $userType");
        $this->line("👥 Rôles actuels: $currentRoles");

        // Corriger les rôles
        if ($user->user_type) {
            $expectedRole = $user->user_type->value;
            $role = Role::where('name', $expectedRole)->first();
            
            if ($role) {
                // Synchroniser avec le rôle attendu
                $user->syncRoles([$expectedRole]);
                $this->info("✅ Rôle '$expectedRole' synchronisé");
                
                // Si c'est un super_admin, s'assurer qu'il a aussi le rôle admin
                if ($expectedRole === 'super_admin') {
                    $adminRole = Role::where('name', 'admin')->first();
                    if ($adminRole && !$user->hasRole('admin')) {
                        $user->assignRole('admin');
                        $this->info("✅ Rôle 'admin' ajouté");
                    }
                }
            } else {
                $this->error("❌ Rôle '$expectedRole' non trouvé");
            }
        }

        // Vérifier le résultat
        $newRoles = $user->fresh()->roles->pluck('name')->implode(', ');
        $this->line("👥 Nouveaux rôles: $newRoles");
        $this->info(str_repeat('=', 50));
    }

    private function fixAllUsers()
    {
        $this->info('🔧 CORRECTION DE TOUS LES RÔLES EN PRODUCTION');
        $this->info(str_repeat('=', 60));
        
        $users = User::with('roles')->get();
        $fixedCount = 0;
        
        foreach ($users as $user) {
            if ($user->user_type) {
                $expectedRole = $user->user_type->value;
                $role = Role::where('name', $expectedRole)->first();
                
                if ($role && !$user->hasRole($expectedRole)) {
                    // Synchroniser avec le rôle attendu
                    $user->syncRoles([$expectedRole]);
                    
                    // Si c'est un super_admin, ajouter aussi le rôle admin
                    if ($expectedRole === 'super_admin') {
                        $adminRole = Role::where('name', 'admin')->first();
                        if ($adminRole) {
                            $user->assignRole('admin');
                        }
                    }
                    
                    $this->line("✅ {$user->email} -> {$expectedRole}");
                    $fixedCount++;
                }
            }
        }
        
        $this->info(str_repeat('=', 60));
        $this->info("✅ $fixedCount utilisateurs corrigés");
        $this->info("📊 Total utilisateurs: " . $users->count());
        
        // Vider les caches
        $this->info('🧹 Vidage des caches...');
        $this->call('optimize:clear');
        $this->call('optimize');
        
        $this->info('🌐 Accédez au panel: ' . config('app.url') . '/admin');
    }
}
