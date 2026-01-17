<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProductionRoleSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Création des rôles et permissions pour la production...');

        // 1. Créer tous les rôles
        $roles = [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'client' => 'Client',
            'developer' => 'Developer',
            'support' => 'Support',
        ];

        foreach ($roles as $roleKey => $roleName) {
            $role = Role::firstOrCreate(['name' => $roleKey]);
            $this->command->info("✅ Rôle '{$roleName}' créé/mis à jour");
        }

        // 2. Super Admin (Toutes les permissions)
        $superAdmin = Role::where('name', 'super_admin')->first();
        $superAdmin->syncPermissions(Permission::all());
        $this->command->info('👑 Super Admin configuré avec toutes les permissions');

        // 3. Admin (Presque tout)
        $admin = Role::where('name', 'admin')->first();
        $admin->syncPermissions(Permission::all());
        $this->command->info('🔧 Admin configuré avec toutes les permissions');

        // 4. Client
        $client = Role::where('name', 'client')->first();
        $clientPermissions = [
            'ViewAny:Project',
            'View:Project',
            'Create:Project',
            'Update:Project',
            'ViewAny:Review',
            'Create:Review',
            'ViewAny:SupportTicket',
            'View:SupportTicket',
            'Create:SupportTicket',
            'ViewAny:Notification',
            'View:Notification',
        ];
        $client->syncPermissions($clientPermissions);
        $this->command->info('👤 Client configuré avec '.count($clientPermissions).' permissions');

        // 5. Developer
        $developer = Role::where('name', 'developer')->first();
        $developerPermissions = [
            'ViewAny:Project',
            'View:Project',
            'Update:Project',
            'ViewAny:Commission',
            'View:Commission',
            'ViewAny:SupportTicket',
            'View:SupportTicket',
            'Create:SupportTicket',
            'ViewAny:Notification',
            'View:Notification',
        ];
        $developer->syncPermissions($developerPermissions);
        $this->command->info('💻 Developer configuré avec '.count($developerPermissions).' permissions');

        // 6. Support
        $support = Role::where('name', 'support')->first();
        $supportPermissions = [
            'ViewAny:SupportTicket',
            'View:SupportTicket',
            'Update:SupportTicket',
            'ViewAny:User',
            'View:User',
            'ViewAny:Notification',
            'View:Notification',
        ];
        $support->syncPermissions($supportPermissions);
        $this->command->info('🎧 Support configuré avec '.count($supportPermissions).' permissions');

        // 7. Résumé
        $this->command->info("\n📊 RÉSUMÉ DES RÔLES CRÉÉS:");
        $this->command->info('═════════════════════════════════════════════════════════════');

        $allRoles = Role::with('permissions')->get();
        foreach ($allRoles as $role) {
            $this->command->info(sprintf(
                '• %-12s : %d permissions',
                strtoupper($role->name),
                $role->permissions->count()
            ));
        }

        $this->command->info('═════════════════════════════════════════════════════════════');
        $this->command->info('✅ Tous les rôles et permissions sont prêts pour la production !');
    }
}
