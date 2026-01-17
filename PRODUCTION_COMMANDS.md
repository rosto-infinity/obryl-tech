# 🚀 COMMANDES PRODUCTION - RÔLES ET PERMISSIONS

## 📋 COMMANDES ESSENTIELLES

### 1. Création Complète des Rôles (Production)
```bash
# Commande principale pour créer tous les rôles
php artisan db:seed --class=ProductionRoleSeeder --force
```

### 2. Test des Rôles (Avant Production)
```bash
# Tester la configuration des rôles
php artisan db:seed --class=TestRoleSeeder --force
```

### 3. Vérification des Rôles Créés
```bash
# Lister tous les rôles avec leurs permissions
php artisan tinker --execute="
\$roles = Spatie\Permission\Models\Role::with('permissions')->get();
echo '📊 RÔLES ET PERMISSIONS CRÉÉS:' . PHP_EOL;
echo str_repeat('=', 50) . PHP_EOL;
foreach (\$roles as \$role) {
    echo sprintf('%-12s : %d permissions', strtoupper(\$role->name), \$role->permissions->count()) . PHP_EOL;
}
echo str_repeat('=', 50) . PHP_EOL;
echo 'Total: ' . \$roles->count() . ' rôles' . PHP_EOL;
echo 'Total: ' . Spatie\Permission\Models\Permission::count() . ' permissions' . PHP_EOL;
"
```

### 4. Vérification des Permissions par Rôle
```bash
# Voir les permissions spécifiques pour chaque rôle
php artisan tinker --execute="
\$roles = ['super_admin', 'admin', 'client', 'developer', 'support'];
foreach (\$roles as \$roleName) {
    \$role = Spatie\Permission\Models\Role::where('name', \$roleName)->with('permissions')->first();
    echo PHP_EOL . strtoupper(\$roleName) . ' (' . \$role->permissions->count() . ' permissions):' . PHP_EOL;
    echo str_repeat('-', 40) . PHP_EOL;
    foreach (\$role->permissions as \$permission) {
        echo '  • ' . \$permission->name . PHP_EOL;
    }
}
"
```

---

## 🎯 RÔLES SPÉCIFIÉS

### Super Admin (121 permissions)
```bash
# Créer le rôle Super Admin
php artisan tinker --execute="
\$superAdmin = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super_admin']);
\$superAdmin->syncPermissions(Spatie\Permission\Models\Permission::all());
echo '✅ Super Admin créé avec ' . \$superAdmin->permissions->count() . ' permissions';
"
```

### Admin (121 permissions)
```bash
# Créer le rôle Admin
php artisan tinker --execute="
\$admin = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
\$admin->syncPermissions(Spatie\Permission\Models\Permission::all());
echo '✅ Admin créé avec ' . \$admin->permissions->count() . ' permissions';
"
```

### Client (11 permissions)
```bash
# Créer le rôle Client
php artisan tinker --execute="
\$client = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'client']);
\$permissions = [
    'ViewAny:Project', 'View:Project', 'Create:Project', 'Update:Project',
    'ViewAny:Review', 'Create:Review',
    'ViewAny:SupportTicket', 'View:SupportTicket', 'Create:SupportTicket',
    'ViewAny:Notification', 'View:Notification'
];
\$client->syncPermissions(\$permissions);
echo '✅ Client créé avec ' . \$client->permissions->count() . ' permissions';
"
```

### Developer (10 permissions)
```bash
# Créer le rôle Developer
php artisan tinker --execute="
\$developer = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'developer']);
\$permissions = [
    'ViewAny:Project', 'View:Project', 'Update:Project',
    'ViewAny:Commission', 'View:Commission',
    'ViewAny:SupportTicket', 'View:SupportTicket', 'Create:SupportTicket',
    'ViewAny:Notification', 'View:Notification'
];
\$developer->syncPermissions(\$permissions);
echo '✅ Developer créé avec ' . \$developer->permissions->count() . ' permissions';
"
```

### Support (7 permissions)
```bash
# Créer le rôle Support
php artisan tinker --execute="
\$support = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'support']);
\$permissions = [
    'ViewAny:SupportTicket', 'View:SupportTicket', 'Update:SupportTicket',
    'ViewAny:User', 'View:User',
    'ViewAny:Notification', 'View:Notification'
];
\$support->syncPermissions(\$permissions);
echo '✅ Support créé avec ' . \$support->permissions->count() . ' permissions';
"
```

---

## 🔐 UTILISATEURS ET RÔLES

### Assigner un rôle à un utilisateur
```bash
# Assigner un rôle spécifique
php artisan tinker --execute="
\$user = App\Models\User::where('email', 'admin@obryl.tech')->first();
if (\$user) {
    \$user->assignRole('super_admin');
    echo '✅ Rôle super_admin assigné à ' . \$user->email;
} else {
    echo '❌ Utilisateur non trouvé';
}
"
```

### Vérifier les rôles d'un utilisateur
```bash
# Voir les rôles d'un utilisateur
php artisan tinker --execute="
\$user = App\Models\User::where('email', 'admin@obryl.tech')->first();
if (\$user) {
    echo 'Rôles de ' . \$user->email . ': ' . \$user->roles->pluck('name')->join(', ');
} else {
    echo '❌ Utilisateur non trouvé';
}
"
```

### Créer des utilisateurs de test
```bash
# Créer un utilisateur pour chaque rôle
php artisan tinker --execute="
\$roles = [
    'super_admin' => 'superadmin@obryl.tech',
    'admin' => 'admin@obryl.tech', 
    'client' => 'client@obryl.tech',
    'developer' => 'developer@obryl.tech',
    'support' => 'support@obryl.tech'
];

foreach (\$roles as \$roleName => \$email) {
    \$user = App\Models\User::firstOrCreate(['email' => \$email], [
        'name' => ucfirst(\$roleName),
        'password' => bcrypt('password'),
        'user_type' => \$roleName
    ]);
    \$user->assignRole(\$roleName);
    echo '✅ Utilisateur ' . \$roleName . ' créé: ' . \$email . ' (password: password)';
}
"
```

---

## 📊 STATISTIQUES ET VÉRIFICATIONS

### Statistiques complètes
```bash
# Vue d'ensemble complète
php artisan tinker --execute="
echo '📊 STATISTIQUES COMPLÈTES' . PHP_EOL;
echo str_repeat('=', 50) . PHP_EOL;
echo 'Total permissions: ' . Spatie\Permission\Models\Permission::count() . PHP_EOL;
echo 'Total rôles: ' . Spatie\Permission\Models\Role::count() . PHP_EOL;
echo 'Total utilisateurs: ' . App\Models\User::count() . PHP_EOL;

echo PHP_EOL . 'Rôles:' . PHP_EOL;
\$roles = Spatie\Permission\Models\Role::with('permissions')->get();
foreach (\$roles as \$role) {
    \$userCount = \$role->users()->count();
    echo sprintf('  %-12s : %d permissions, %d utilisateurs', strtoupper(\$role->name), \$role->permissions->count(), \$userCount) . PHP_EOL;
}
"
```

### Test des permissions
```bash
# Tester si un rôle a une permission spécifique
php artisan tinker --execute="
\$tests = [
    ['role' => 'client', 'permission' => 'Create:Project'],
    ['role' => 'developer', 'permission' => 'Update:Project'],
    ['role' => 'support', 'permission' => 'Update:SupportTicket'],
    ['role' => 'admin', 'permission' => 'Delete:User']
];

foreach (\$tests as \$test) {
    \$role = Spatie\Permission\Models\Role::where('name', \$test['role'])->first();
    \$hasPermission = \$role ? \$role->hasPermissionTo(\$test['permission']) : false;
    echo sprintf('%-10s -> %-20s : %s', strtoupper(\$test['role']), \$test['permission'], \$hasPermission ? '✅ AUTORISÉ' : '❌ REFUSÉ') . PHP_EOL;
}
"
```

---

## 🚨 DÉPANNAGE RAPIDE

### Réinitialiser les rôles
```bash
# Supprimer et recréer tous les rôles
php artisan tinker --execute"
Spatie\Permission\Models\Role::query()->delete();
Spatie\Permission\Models\Permission::query()->delete();
echo '✅ Rôles et permissions supprimés';
"
php artisan db:seed --class=ProductionRoleSeeder --force
```

### Vérifier la configuration
```bash
# Vérifier que le package est bien configuré
php artisan tinker --execute="
echo 'Configuration Spatie Permission:' . PHP_EOL;
echo 'Package installé: ' . (class_exists('Spatie\Permission\Models\Role') ? '✅ Oui' : '❌ Non') . PHP_EOL;
echo 'Modèle User utilise HasRoles: ' . (method_exists(App\Models\User::class, 'roles') ? '✅ Oui' : '❌ Non') . PHP_EOL;
"
```

---

## 🎯 RÉSUMÉ DES COMMANDES PRODUCTION

### Commande unique pour tout créer
```bash
# LA COMMANDE MAGIQUE - Crée tous les rôles et permissions
php artisan db:seed --class=ProductionRoleSeeder --force
```

### Vérification rapide
```bash
# Vérifier que tout est OK
php artisan tinker --execute="
echo '✅ Rôles: ' . Spatie\Permission\Models\Role::count();
echo '✅ Permissions: ' . Spatie\Permission\Models\Permission::count();
echo '✅ Utilisateurs: ' . App\Models\User::count();
"
```

---

**🎉 UTILISEZ CES COMMANDES EN PRODUCTION POUR CRÉER TOUS LES RÔLES !**
