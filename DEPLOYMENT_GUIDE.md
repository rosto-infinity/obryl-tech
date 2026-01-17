# 🚀 GUIDE DE DÉPLOIEMENT PRODUCTION - OBRYL TECH

## 📋 PRÉREQUIS

### Environnement
- **PHP**: >= 8.4
- **Laravel**: 12.44.0
- **MySQL**: >= 8.0
- **Composer**: Dernière version

### Configuration
- Variables d'environnement configurées
- Base de données créée
- Permissions des dossiers (storage, bootstrap/cache)

---

## 🎯 COMMANDES DE DÉPLOIEMENT

### 1. Déploiement Automatique (Recommandé)

```bash
# Exécuter le script de déploiement complet
./deploy-production.sh
```

### 2. Déploiement Manuel

```bash
# 1. Installation des dépendances
composer install --optimize-autoloader --no-dev --no-interaction

# 2. Configuration
php artisan config:clear
php artisan cache:clear

# 3. Migration de la base de données
php artisan migrate --force

# 4. Création des rôles et permissions
php artisan db:seed --class=ProductionRoleSeeder --force

# 5. Optimisation
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 👥 RÔLES ET PERMISSIONS

### Structure des Rôles

| Rôle | Permissions | Description |
|------|-------------|-------------|
| **Super Admin** | 121 | Accès total à tout |
| **Admin** | 121 | Accès administratif complet |
| **Client** | 11 | Gestion de projets et tickets |
| **Developer** | 10 | Gestion de projets et commissions |
| **Support** | 7 | Gestion des tickets et utilisateurs |

### Permissions par Rôle

#### 🏆 Super Admin / Admin
- **Toutes les permissions** : Accès complet à toutes les fonctionnalités

#### 👤 Client
- **Projets**: Voir, créer, modifier ses projets
- **Avis**: Voir et créer des avis
- **Tickets**: Voir, créer, gérer ses tickets
- **Notifications**: Voir ses notifications

#### 💻 Developer
- **Projets**: Voir, modifier les projets assignés
- **Commissions**: Voir ses commissions
- **Tickets**: Voir, créer des tickets
- **Notifications**: Voir ses notifications

#### 🎧 Support
- **Tickets**: Voir, modifier tous les tickets
- **Utilisateurs**: Voir les informations utilisateurs
- **Notifications**: Voir les notifications système

---

## 🧪 TESTS AVANT PRODUCTION

### 1. Tester les rôles
```bash
# Exécuter le seeder de test
php artisan db:seed --class=TestRoleSeeder --force
```

### 2. Vérifier les permissions
```bash
# Vérifier la configuration
php artisan tinker --execute="
\$roles = Spatie\Permission\Models\Role::with('permissions')->get();
foreach (\$roles as \$role) {
    echo \$role->name . ': ' . \$role->permissions->count() . ' permissions' . PHP_EOL;
}
"
```

### 3. Test des accès
```bash
# Créer un utilisateur de test pour chaque rôle
php artisan tinker --execute="
\$roles = ['super_admin', 'admin', 'client', 'developer', 'support'];
foreach (\$roles as \$roleName) {
    \$user = App\Models\User::factory()->create([
        'email' => \$roleName . '@test.com',
        'user_type' => \$roleName
    ]);
    \$user->assignRole(\$roleName);
    echo '✅ Utilisateur ' . \$roleName . ' créé: ' . \$user->email . PHP_EOL;
}
"
```

---

## 🔐 UTILISATEURS PAR DÉFAUT

### Compte Super Admin
- **Email**: `admin@obryl.tech`
- **Mot de passe**: Définir dans `.env`
- **Rôle**: Super Admin

### Accès Filament
- **URL**: `https://votre-domaine.com/admin`
- **Identifiants**: Utiliser le compte Super Admin

---

## 📊 VÉRIFICATION POST-DÉPLOIEMENT

### 1. Vérifier les rôles
```bash
php artisan tinker --execute="
echo '📊 Rôles créés:' . PHP_EOL;
\$roles = Spatie\Permission\Models\Role::all();
foreach (\$roles as \$role) {
    echo '  • ' . \$role->name . ' (' . \$role->permissions->count() . ' permissions)' . PHP_EOL;
}
"
```

### 2. Vérifier les permissions
```bash
php artisan tinker --execute="
echo '🔐 Total permissions: ' . Spatie\Permission\Models\Permission::count() . PHP_EOL;
echo '👥 Total rôles: ' . Spatie\Permission\Models\Role::count() . PHP_EOL;
"
```

### 3. Test des URLs
- **Panel Admin**: `/admin`
- **Projets**: `/projects`
- **Tickets**: `/support`
- **Notifications**: `/notifications`

---

## 🚨 DÉPANNAGE

### Erreurs Communes

#### 1. Permission denied
```bash
# Corriger les permissions des dossiers
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

#### 2. Cache problems
```bash
# Vider tous les caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 3. Database connection
```bash
# Vérifier la connexion
php artisan tinker --execute="
try {
    DB::connection()->getPdo();
    echo '✅ Connexion DB réussie';
} catch (Exception \$e) {
    echo '❌ Erreur DB: ' . \$e->getMessage();
}
"
```

---

## 🔄 MAINTENANCE

### Mises à jour régulières
```bash
# Mettre à jour les dépendances
composer update

# Mettre à jour les permissions
php artisan db:seed --class=ProductionRoleSeeder --force

# Optimiser
php artisan optimize
```

### Sauvegardes
```bash
# Base de données
mysqldump -u username -p database_name > backup.sql

# Fichiers
tar -czf backup_files.tar.gz storage/ bootstrap/cache/
```

---

## 📞 SUPPORT

### En cas de problème
1. **Vérifier les logs**: `storage/logs/laravel.log`
2. **Tester en local**: Reproduire l'erreur
3. **Contacter le support**: Fournir les logs et environnement

### Documentation
- **Laravel**: https://laravel.com/docs
- **Spatie Permission**: https://spatie.be/docs/laravel-permission
- **Filament**: https://filamentphp.com/docs

---

## ✅ CHECKLIST FINALE

- [ ] Environnement configuré
- [ ] Base de données créée
- [ ] Dépendances installées
- [ ] Migration exécutée
- [ ] Rôles et permissions créés
- [ ] Cache optimisé
- [ ] Tests effectués
- [ ] URLs vérifiées
- [ ] Documentation lue

---

**🎉 OBRYL TECH est prêt pour la production !**
