<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class FixSuperAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:superadmin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attribuer le rôle super_admin à un utilisateur spécifique';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email');

        if (! $email) {
            $this->error('❌ Email requis: php artisan fix:superadmin email@domain.com');

            return;
        }

        $this->info('🔧 ATTRIBUTION DU RÔLE SUPER_ADMIN');
        $this->info(str_repeat('=', 50));

        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error("❌ Utilisateur '$email' non trouvé");

            return;
        }

        // Afficher l'état actuel
        $currentRoles = $user->roles->pluck('name')->implode(', ') ?: 'Aucun';
        $userType = $user->user_type ? $user->user_type->value : 'N/A';

        $this->line("👤 Email: $user->email");
        $this->line("👤 Nom: $user->name");
        $this->line("🏷️  Type: $userType");
        $this->line("👥 Rôles actuels: $currentRoles");

        // Obtenir le rôle super_admin
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();

        if (! $superAdminRole) {
            $this->error("❌ Rôle 'super_admin' non trouvé. Création en cours...");
            $superAdminRole = Role::create(['name' => 'super_admin']);
            $this->info("✅ Rôle 'super_admin' créé");
        }

        if (! $adminRole) {
            $this->error("❌ Rôle 'admin' non trouvé. Création en cours...");
            $adminRole = Role::create(['name' => 'admin']);
            $this->info("✅ Rôle 'admin' créé");
        }

        // Assigner les rôles
        $user->syncRoles([$superAdminRole->name]);

        // Ajouter aussi le rôle admin pour un accès complet
        $user->assignRole($adminRole->name);

        $this->info("✅ Rôle 'super_admin' assigné");
        $this->info("✅ Rôle 'admin' assigné");

        // Mettre à jour le user_type si nécessaire
        if (! $user->user_type || $user->user_type->value !== 'super_admin') {
            $user->user_type = \App\Enums\Auth\UserType::SUPER_ADMIN;
            $user->save();
            $this->info('✅ user_type mis à jour: super_admin');
        }

        // Vider les caches
        $this->info('🧹 Vidage des caches...');
        $this->call('optimize:clear');
        $this->call('optimize');

        // Vérifier le résultat
        $updatedUser = $user->fresh();
        $newRoles = $updatedUser->roles->pluck('name')->implode(', ');

        $this->line("👥 Nouveaux rôles: $newRoles");
        $this->info(str_repeat('=', 50));
        $this->info("🎉 UTILISATEUR $email CORRIGÉ AVEC SUCCÈS !");
        $this->info('🌐 Accédez au panel: '.config('app.url').'/admin');
    }
}
