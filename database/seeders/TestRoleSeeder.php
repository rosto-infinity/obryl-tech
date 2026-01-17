<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestRoleSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🧪 TEST DES RÔLES ET PERMISSIONS');
        $this->command->info('==================================');
        
        // Nettoyer les rôles et permissions existants
        $this->command->info('🧹 Nettoyage des données de test...');
        Permission::query()->delete();
        Role::query()->delete();
        
        // Créer les permissions de base
        $permissions = [
            // Users
            'ViewAny:User',
            'View:User',
            'Create:User',
            'Update:User',
            'Delete:User',
            
            // Projects
            'ViewAny:Project',
            'View:Project',
            'Create:Project',
            'Update:Project',
            'Delete:Project',
            
            // Reviews
            'ViewAny:Review',
            'View:Review',
            'Create:Review',
            'Update:Review',
            'Delete:Review',
            
            // Support Tickets
            'ViewAny:SupportTicket',
            'View:SupportTicket',
            'Create:SupportTicket',
            'Update:SupportTicket',
            'Delete:SupportTicket',
            
            // Commissions
            'ViewAny:Commission',
            'View:Commission',
            'Create:Commission',
            'Update:Commission',
            'Delete:Commission',
            
            // Notifications
            'ViewAny:Notification',
            'View:Notification',
            'Create:Notification',
            'Update:Notification',
            'Delete:Notification',
            
            // Workload Management
            'ViewAny:WorkloadManagement',
            'View:WorkloadManagement',
            'Create:WorkloadManagement',
            'Update:WorkloadManagement',
            'Delete:WorkloadManagement',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        $this->command->info('✅ ' . count($permissions) . ' permissions créées');
        
        // Créer les rôles avec leurs permissions
        $rolesConfig = [
            'super_admin' => Permission::all(),
            'admin' => Permission::all(),
            'client' => [
                'ViewAny:Project', 'View:Project', 'Create:Project', 'Update:Project',
                'ViewAny:Review', 'Create:Review',
                'ViewAny:SupportTicket', 'View:SupportTicket', 'Create:SupportTicket',
                'ViewAny:Notification', 'View:Notification'
            ],
            'developer' => [
                'ViewAny:Project', 'View:Project', 'Update:Project',
                'ViewAny:Commission', 'View:Commission',
                'ViewAny:SupportTicket', 'View:SupportTicket', 'Create:SupportTicket',
                'ViewAny:Notification', 'View:Notification'
            ],
            'support' => [
                'ViewAny:SupportTicket', 'View:SupportTicket', 'Update:SupportTicket',
                'ViewAny:User', 'View:User',
                'ViewAny:Notification', 'View:Notification'
            ]
        ];
        
        foreach ($rolesConfig as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
            
            $this->command->info(sprintf(
                "✅ %s: %d permissions",
                strtoupper($roleName),
                count($permissions)
            ));
        }
        
        // Test des permissions
        $this->testPermissions();
        
        $this->command->info("\n🎉 TEST TERMINÉ - Rôles prêts pour la production!");
    }
    
    private function testPermissions(): void
    {
        $this->command->info("\n🧪 TEST DES PERMISSIONS:");
        
        $tests = [
            ['role' => 'client', 'permission' => 'Create:Project', 'expected' => true],
            ['role' => 'client', 'permission' => 'Delete:User', 'expected' => false],
            ['role' => 'developer', 'permission' => 'Update:Project', 'expected' => true],
            ['role' => 'developer', 'permission' => 'Delete:Project', 'expected' => false],
            ['role' => 'support', 'permission' => 'Update:SupportTicket', 'expected' => true],
            ['role' => 'support', 'permission' => 'Create:Project', 'expected' => false],
            ['role' => 'admin', 'permission' => 'Delete:User', 'expected' => true],
            ['role' => 'super_admin', 'permission' => 'Delete:User', 'expected' => true],
        ];
        
        foreach ($tests as $test) {
            $role = Role::where('name', $test['role'])->first();
            $hasPermission = $role->hasPermissionTo($test['permission']);
            $status = $hasPermission === $test['expected'] ? '✅' : '❌';
            
            $this->command->info(sprintf(
                "  %s %s -> %s: %s",
                $status,
                strtoupper($test['role']),
                $test['permission'],
                $hasPermission ? 'AUTORISÉ' : 'REFUSÉ'
            ));
        }
    }
}
