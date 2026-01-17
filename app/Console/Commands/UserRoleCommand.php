<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class UserRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {action} {email?} {role?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gérer les rôles des utilisateurs';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'list':
                $this->listUsers();

                break;
            case 'assign':
                $this->assignRole();

                break;
            case 'remove':
                $this->removeRole();

                break;
            case 'check':
                $this->checkUser();

                break;
            default:
                $this->error('Action non valide. Actions disponibles: list, assign, remove, check');
                $this->showUsage();

                break;
        }
    }

    private function listUsers(): void
    {
        $this->info('📋 LISTE DES UTILISATEURS ET LEURS RÔLES');
        $this->info(str_repeat('=', 60));

        $users = User::with('roles')->get();

        if ($users->isEmpty()) {
            $this->warn('Aucun utilisateur trouvé.');

            return;
        }

        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->implode(', ') ?: 'Aucun';
            $userType = $user->user_type ? $user->user_type->value : 'N/A';
            $this->line(sprintf(
                '👤 %-30s | %-15s | %s',
                $user->email,
                $userType,
                $roles
            ));
        }

        $this->info(str_repeat('=', 60));
        $this->info('Total: '.$users->count().' utilisateurs');
    }

    private function assignRole(): void
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');

        if (! $email || ! $roleName) {
            $this->error('❌ Email et rôle requis: php artisan user:role assign email@domain.com role_name');

            return;
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error("❌ Utilisateur '$email' non trouvé.");

            return;
        }

        $role = Role::where('name', $roleName)->first();
        if (! $role) {
            $this->error("❌ Rôle '$roleName' non trouvé.");
            $this->info('Rôles disponibles: '.Role::all()->pluck('name')->implode(', '));

            return;
        }

        $user->assignRole($role);
        $this->info("✅ Rôle '$roleName' assigné à '$email' avec succès!");
    }

    private function removeRole(): void
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');

        if (! $email || ! $roleName) {
            $this->error('❌ Email et rôle requis: php artisan user:role remove email@domain.com role_name');

            return;
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error("❌ Utilisateur '$email' non trouvé.");

            return;
        }

        if (! $user->hasRole($roleName)) {
            $this->warn("⚠️  L'utilisateur '$email' n'a pas le rôle '$roleName'.");

            return;
        }

        $user->removeRole($roleName);
        $this->info("✅ Rôle '$roleName' retiré de '$email' avec succès!");
    }

    private function checkUser(): void
    {
        $email = $this->argument('email');

        if (! $email) {
            $this->error('❌ Email requis: php artisan user:role check email@domain.com');

            return;
        }

        $user = User::with('roles')->where('email', $email)->first();
        if (! $user) {
            $this->error("❌ Utilisateur '$email' non trouvé.");

            return;
        }

        $this->info("🔍 INFORMATIONS UTILISATEUR: $email");
        $this->info(str_repeat('=', 50));
        $this->line('👤 Nom: '.$user->name);
        $this->line('📧 Email: '.$user->email);
        $this->line('🏷️  Type: '.($user->user_type ? $user->user_type->value : 'N/A'));
        $this->line('👥 Rôles: '.($user->roles->pluck('name')->implode(', ') ?: 'Aucun'));
        $this->line('📅 Créé le: '.$user->created_at->format('d/m/Y H:i'));
        $this->line('🔄 Mis à jour: '.$user->updated_at->format('d/m/Y H:i'));
        $this->info(str_repeat('=', 50));
    }

    private function showUsage(): void
    {
        $this->info('📖 UTILISATION:');
        $this->line('  php artisan user:role list                              # Lister tous les utilisateurs');
        $this->line('  php artisan user:role assign email@domain.com role_name   # Assigner un rôle');
        $this->line('  php artisan user:role remove email@domain.com role_name   # Retirer un rôle');
        $this->line('  php artisan user:role check email@domain.com             # Vérifier un utilisateur');
        $this->line('');
        $this->info('🎯 Rôles disponibles: '.Role::all()->pluck('name')->implode(', '));
    }
}
