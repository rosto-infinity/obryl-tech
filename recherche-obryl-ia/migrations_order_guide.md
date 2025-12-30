# 📂 Ordre des Migrations - Obryl Tech Platform

## 🎯 Principe d'Ordre

Les migrations doivent être exécutées dans l'ordre des **dépendances des clés étrangères** :
1. Tables **indépendantes** d'abord (users, categories)
2. Tables **dépendantes** ensuite (projects, reviews)
3. Tables **pivot/relation** en dernier (project_collaborators)

---

## 📋 Liste Complète des Migrations (Ordre d'Exécution)

### 🔹 PHASE 1 : Tables Fondamentales (Aucune dépendance)

```bash
# 1. Users - Base de tout le système
2025_01_01_000001_create_users_table.php

# 2. Catégories Blog (indépendant)
2025_01_01_000002_create_blog_categories_table.php
```

---

### 🔹 PHASE 2 : Tables Dépendantes de Users

```bash
# 3. Profils Développeurs (dépend de users)
2025_01_02_000001_create_developer_profiles_table.php

# 4. Projets (dépend de users.client_id)
2025_01_02_000002_create_projects_table.php

# 5. Articles Blog (dépend de users.author_id)
2025_01_02_000003_create_blog_posts_table.php
```

---

### 🔹 PHASE 3 : Tables Dépendantes de Projects

```bash
# 6. Jalons de Projets (dépend de projects)
2025_01_03_000001_create_project_milestones_table.php

# 7. Paiements (dépend de projects + users)
2025_01_03_000002_create_project_payments_table.php

# 8. Chats (dépend de projects + users)
2025_01_03_000003_create_chats_table.php

# 9. Collaborateurs (dépend de projects + users)
2025_01_03_000004_create_project_collaborators_table.php

# 10. Portfolio Public (dépend de projects)
2025_01_03_000005_create_portfolio_projects_table.php
```

---

### 🔹 PHASE 4 : Tables Dépendantes de Developer Profiles

```bash
# 11. Avis/Reviews (dépend de projects + developer_profiles)
2025_01_04_000001_create_reviews_table.php
```

---

### 🔹 PHASE 5 : Tables Complémentaires

```bash
# 12. Likes Portfolio (dépend de portfolio_projects + users)
2025_01_05_000001_create_portfolio_likes_table.php

# 13. Commentaires Blog (dépend de blog_posts + users)
2025_01_05_000002_create_blog_comments_table.php

# 14. Notifications (dépend de users)
2025_01_05_000003_create_notifications_table.php

# 15. Activités (Logs) - optionnel
2025_01_05_000004_create_activity_log_table.php
```

---

### 🔹 PHASE 6 : Permissions (Spatie)

```bash
# 16-19. Spatie Permissions (auto-generated)
2025_01_06_000001_create_permission_tables.php
```

---

## 📊 Visualisation Graphique de l'Ordre

```
NIVEAU 0 (Indépendantes)
├── users ⬅️ DÉPART
└── blog_categories

NIVEAU 1 (Dépendent de users)
├── developer_profiles (users)
├── projects (users.client_id)
└── blog_posts (users.author_id)

NIVEAU 2 (Dépendent de projects)
├── project_milestones (projects)
├── project_payments (projects, users)
├── chats (projects, users)
├── project_collaborators (projects, users)
└── portfolio_projects (projects)

NIVEAU 3 (Dépendent de developer_profiles)
└── reviews (projects, developer_profiles, users)

NIVEAU 4 (Dépendent de tables N3)
├── portfolio_likes (portfolio_projects, users)
├── blog_comments (blog_posts, users)
└── notifications (users)

NIVEAU 5 (Système)
└── permissions (Spatie) + activity_log
```

---

## ⚡ Commandes de Génération

### Créer toutes les migrations dans l'ordre :

```bash
# Phase 1 : Fondamentales
php artisan make:migration create_users_table
php artisan make:migration create_blog_categories_table

# Phase 2 : Dépendantes Users
php artisan make:migration create_developer_profiles_table
php artisan make:migration create_projects_table
php artisan make:migration create_blog_posts_table

# Phase 3 : Dépendantes Projects
php artisan make:migration create_project_milestones_table
php artisan make:migration create_project_payments_table
php artisan make:migration create_chats_table
php artisan make:migration create_project_collaborators_table
php artisan make:migration create_portfolio_projects_table

# Phase 4 : Reviews
php artisan make:migration create_reviews_table

# Phase 5 : Complémentaires
php artisan make:migration create_portfolio_likes_table
php artisan make:migration create_blog_comments_table
php artisan make:migration create_notifications_table
php artisan make:migration create_activity_log_table

# Phase 6 : Permissions
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

---

## 🔍 Vérification des Dépendances

### Checklist avant `php artisan migrate`

✅ **Vérifier que :**
1. `users` existe avant `developer_profiles`
2. `users` + `projects` existent avant `chats`
3. `projects` existe avant `project_milestones`
4. `developer_profiles` existe avant `reviews`
5. `blog_posts` existe avant `blog_comments`

### Commande de Vérification

```bash
# Lister les migrations dans l'ordre
php artisan migrate:status

# Tester sur base vierge
php artisan migrate:fresh --seed
```

---

## 🛠️ Résolution de Problèmes

### Erreur : "SQLSTATE[HY000]: General error: 1005 Can't create table"

**Cause :** Clé étrangère vers une table non existante

**Solution :**
```bash
# 1. Rollback
php artisan migrate:rollback --step=5

# 2. Vérifier l'ordre dans database/migrations/
ls -la database/migrations/

# 3. Renommer les fichiers si nécessaire
mv 2025_01_01_000005_create_chats_table.php 2025_01_03_000003_create_chats_table.php

# 4. Relancer
php artisan migrate
```

---

## 📝 Template de Naming Convention

```
YYYY_MM_DD_HHMMSS_action_table_name.php

Exemples :
- 2025_01_01_000001_create_users_table.php
- 2025_01_02_000001_create_developer_profiles_table.php
- 2025_01_03_000002_add_balance_to_developer_profiles_table.php
- 2025_01_04_000001_create_reviews_table.php
```

**Convention de priorité :**
- `000001` = Très prioritaire (users, roles)
- `000002-000009` = Prioritaire (tables principales)
- `000010-000099` = Normal (tables secondaires)

---

## 🎯 Résumé Final

**Ordre Critique à Respecter :**

1. **users** → Toujours en PREMIER
2. **developer_profiles, projects, blog_posts** → Dépendent de users
3. **project_milestones, chats, collaborators** → Dépendent de projects
4. **reviews** → Dépendent de developer_profiles
5. **likes, comments** → Dépendent de portfolio/blog
6. **permissions** → En DERNIER (optionnel)

**Total Migrations : ~19 fichiers**

**Durée Exécution : ~2-5 secondes** (base vide)

---

## 💡 Astuce Pro

Utiliser un **seeder master** pour tester :

```php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    $this->call([
        UserSeeder::class,              // 1. Users
        DeveloperProfileSeeder::class,   // 2. Profiles
        ProjectSeeder::class,            // 3. Projects
        MilestoneSeeder::class,          // 4. Milestones
        CollaboratorSeeder::class,       // 5. Collaborators
        ChatSeeder::class,               // 6. Chats
        ReviewSeeder::class,             // 7. Reviews
    ]);
}
```

Puis :
```bash
php artisan migrate:fresh --seed
```

✅ **Vos migrations sont maintenant prêtes à être exécutées dans l'ordre optimal !**
