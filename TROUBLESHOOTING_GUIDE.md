# 🔧 GUIDE COMPLET - RÔLES ET FILAMENT

## 📋 COMMANDES DISPONIBLES

### 1. Gestion des Rôles Utilisateurs

#### Lister tous les utilisateurs
```bash
php artisan user:role list
```

#### Assigner un rôle à un utilisateur
```bash
php artisan user:role assign email@domain.com role_name
```

#### Retirer un rôle d'un utilisateur
```bash
php artisan user:role remove email@domain.com role_name
```

#### Vérifier un utilisateur
```bash
php artisan user:role check email@domain.com
```

#### Rôles disponibles
- `super_admin` : Accès total
- `admin` : Accès administratif
- `client` : Client
- `developer` : Développeur
- `support` : Support

---

### 2. Gestion des Liens Filament

#### Vérifier les liens
```bash
php artisan filament:links check
```

#### Réparer les liens
```bash
php artisan filament:links fix
```

#### Réinitialiser complètement
```bash
php artisan filament:links reset
```

---

## 🚨 PROBLÈMES COURANTS ET SOLUTIONS

### Problème 1: Liens manquants dans Filament

#### Symptômes
- Navigation vide dans le panel admin
- Liens ne s'affichent pas
- Erreur 404 sur les pages admin

#### Solutions

##### 1. Vider les caches
```bash
php artisan optimize:clear
php artisan optimize
```

##### 2. Recréer les liens
```bash
php artisan filament:links fix
```

##### 3. Vérifier les permissions
```bash
# Vérifier que l'utilisateur a les bons rôles
php artisan user:role check admin@obryl.tech
```

##### 4. Recréer les rôles
```bash
php artisan db:seed --class=ProductionRoleSeeder --force
```

### Problème 2: Utilisateurs sans rôles

#### Symptômes
- Accès refusé au panel admin
- Erreur "403 Forbidden"
- Navigation limitée

#### Solutions

##### 1. Assigner manuellement un rôle
```bash
php artisan user:role assign email@domain.com admin
```

##### 2. Assigner en lot
```bash
# Assigner le rôle admin à tous les utilisateurs de type admin
php artisan tinker --execute="
App\Models\User::where('user_type', 'admin')->get()->each(function(\$user) {
    \$user->assignRole('admin');
    echo '✅ Admin assigné à ' . \$user->email . PHP_EOL;
});
"
```

##### 3. Recréer tous les rôles
```bash
php artisan db:seed --class=ProductionRoleSeeder --force
```

---

## 🔧 DIAGNOSTIC COMPLET

### Étape 1: Vérifier l'état actuel
```bash
# 1. Vérifier les utilisateurs et leurs rôles
php artisan user:role list

# 2. Vérifier les liens Filament
php artisan filament:links check

# 3. Vérifier les permissions
php artisan tinker --execute="
echo 'Total rôles: ' . Spatie\Permission\Models\Role::count() . PHP_EOL;
echo 'Total permissions: ' . Spatie\Permission\Models\Permission::count() . PHP_EOL;
"
```

### Étape 2: Corriger les problèmes
```bash
# 1. Recréer les rôles si nécessaire
php artisan db:seed --class=ProductionRoleSeeder --force

# 2. Réparer les liens Filament
php artisan filament:links fix

# 3. Optimiser
php artisan optimize
```

### Étape 3: Vérifier l'accès
```bash
# 1. Assigner le rôle super_admin à l'admin principal
php artisan user:role assign admin@obryl.tech super_admin

# 2. Vérifier l'accès
php artisan user:role check admin@obryl.tech
```

---

## 🎯 SCÉNARIOS SPÉCIFIQUES

### Scénario 1: Nouveau déploiement
```bash
# 1. Créer tous les rôles
php artisan db:seed --class=ProductionRoleSeeder --force

# 2. Assigner le rôle super_admin
php artisan user:role assign admin@obryl.tech super_admin

# 3. Optimiser
php artisan optimize

# 4. Vérifier
php artisan user:role check admin@obryl.tech
```

### Scénario 2: Liens cassés après mise à jour
```bash
# 1. Vider les caches
php artisan optimize:clear

# 2. Réparer les liens
php artisan filament:links fix

# 3. Recréer les caches
php artisan optimize
```

### Scénario 3: Utilisateurs perdent leurs rôles
```bash
# 1. Recréer les rôles
php artisan db:seed --class=ProductionRoleSeeder --force

# 2. Assigner les rôles selon le user_type
php artisan tinker --execute="
App\Models\User::all()->each(function(\$user) {
    if (\$user->user_type && !\$user->hasRole(\$user->user_type->value)) {
        \$user->assignRole(\$user->user_type->value);
        echo '✅ Rôle ' . \$user->user_type->value . ' assigné à ' . \$user->email . PHP_EOL;
    }
});
"
```

---

## 📊 COMMANDES RAPIDES

### Tout réparer en une commande
```bash
php artisan optimize:clear && \
php artisan db:seed --class=ProductionRoleSeeder --force && \
php artisan user:role assign admin@obryl.tech super_admin && \
php artisan optimize
```

### Vérifier l'état de santé
```bash
php artisan tinker --execute="
echo '🏥 SANTÉ DU SYSTÈME:' . PHP_EOL;
echo 'Rôles: ' . Spatie\Permission\Models\Role::count() . PHP_EOL;
echo 'Permissions: ' . Spatie\Permission\Models\Permission::count() . PHP_EOL;
echo 'Utilisateurs: ' . App\Models\User::count() . PHP_EOL;
echo 'Admin avec rôle: ' . App\Models\User::where('email', 'admin@obryl.tech')->first()->hasRole('super_admin') ? '✅' : '❌';
"
```

---

## 🌐 ACCÈS AU PANEL

### URLs importantes
- **Panel Admin**: `http://localhost:8000/admin`
- **Login**: `admin@obryl.tech`
- **Mot de passe**: Définir dans `.env`

### Si l'accès ne fonctionne pas
```bash
# 1. Vérifier que le serveur tourne
php artisan serve

# 2. Vérifier les permissions
php artisan user:role check admin@obryl.tech

# 3. Réparer les liens
php artisan filament:links fix
```

---

## 🔐 SÉCURITÉ

### Bonnes pratiques
1. **Toujours** assigner le rôle `super_admin` à l'admin principal
2. **Utiliser** des rôles spécifiques pour chaque type d'utilisateur
3. **Vérifier** régulièrement les permissions avec `php artisan user:role list`
4. **Sauvegarder** la base de données avant les modifications

### Commande de sécurité
```bash
# Vérifier qui a accès admin
php artisan tinker --execute="
\$adminUsers = App\Models\User::whereHas('roles', function(\$query) {
    \$query->whereIn('name', ['admin', 'super_admin']);
})->get();

echo '👥 Utilisateurs avec accès admin:' . PHP_EOL;
foreach (\$adminUsers as \$user) {
    echo '  • ' . \$user->email . ' (' . \$user->roles->pluck('name')->implode(', ') . ')' . PHP_EOL;
}
"
```

---

## ✅ CHECKLIST DE DÉPANNAGE

- [ ] Serveur Laravel en cours d'exécution
- [ ] Base de données accessible
- [ ] Rôles créés (`php artisan db:seed --class=ProductionRoleSeeder`)
- [ ] Admin a le rôle super_admin
- [ ] Caches vidés (`php artisan optimize:clear`)
- [ ] Liens Filament réparés (`php artisan filament:links fix`)
- [ ] Accès au panel testé

---

**🎉 AVEC CES COMMANDES, VOUS POUVEZ GÉRER TOUS LES PROBLÈMES DE RÔLES ET DE LIENS FILAMENT !**
