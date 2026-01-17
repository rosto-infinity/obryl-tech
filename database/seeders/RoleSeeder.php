<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Rôle Admin (Presque tout)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        // 2. Rôle Client
        $client = Role::firstOrCreate(['name' => 'client']);
        $client->syncPermissions([
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
        ]);

        // 3. Rôle Développeur
        $developer = Role::firstOrCreate(['name' => 'developer']);
        $developer->syncPermissions([
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
        ]);

        // 4. Rôle Support
        $support = Role::firstOrCreate(['name' => 'support']);
        $support->syncPermissions([
            'ViewAny:SupportTicket',
            'View:SupportTicket',
            'Update:SupportTicket',
            'ViewAny:User',
            'View:User',
            'ViewAny:Notification',
            'View:Notification',
        ]);

        // 5. Super Admin (Défini dans config/filament-shield.php)
        Role::firstOrCreate(['name' => 'super_admin']);

        // 6. Assigner les rôles aux utilisateurs existants
        \App\Models\User::all()->each(function ($user): void {
            $user->syncRoles([$user->user_type->value]);
        });
    }
}
