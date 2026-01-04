# 📋 Documentation Détaillée - Portfolio Développeurs

## 📑 Table des Matières

1. [Architecture Générale](#architecture-générale)
2. [Modèles de Données](#modèles-de-données)
3. [Composants Livewire](#composants-livewire)
4. [Routes et Binding](#routes-et-binding)
5. [Vues et Layouts](#vues-et-layouts)
6. [Processus de Migration](#processus-de-migration)
7. [Dépannage et Solutions](#dépannage-et-solutions)

---

## 🏗️ Architecture Générale

### Stack Technique

- **PHP**: 8.4.16 - Langage serveur avec typage strict
- **Laravel**: 12.44.0 - Framework web PHP moderne
- **Livewire**: 3.x - Framework réactif pour composants dynamiques
- **Frontend**: Blade + Alpine.js + TailwindCSS - Templating et styling
- **Base de données**: MySQL - Stockage persistant

### Structure des Dossiers

```
projet-portfolio/
├── app/
│   ├── Models/                    # Modèles Eloquent (représentation DB)
│   │   ├── User.php              # Utilisateurs (clients/développeurs)
│   │   ├── Project.php           # Projets portfolio
│   │   ├── Profile.php           # Profils développeurs
│   │   ├── Review.php            # Avis clients
│   │   └── Commission.php        # Commissions/paiements
│   │
│   ├── Livewire/                 # Composants Livewire (logique interactive)
│   │   ├── Project/
│   │   │   ├── ProjectList.php       # Liste paginée des projets
│   │   │   ├── ProjectDetail.php     # Détail d'un projet
│   │   │   ├── ProjectFilter.php     # Filtrage des projets
│   │   │   └── ProjectProgress.php   # Suivi de progression
│   │   │
│   │   ├── Developer/
│   │   │   ├── DeveloperList.php     # Liste des développeurs
│   │   │   ├── DeveloperProfile.php  # Profil développeur
│   │   │   └── DeveloperSearch.php   # Recherche développeurs
│   │   │
│   │   ├── Portfolio/
│   │   │   ├── PortfolioGallery.php  # Galerie portfolio
│   │   │   ├── ProjectCard.php       # Carte projet
│   │   │   └── ProjectLike.php       # Système de likes
│   │   │
│   │   └── Settings/
│   │       ├── Profile.php           # Paramètres profil
│   │       ├── Password.php          # Changement mot de passe
│   │       └── Appearance.php        # Thème (clair/sombre)
│   │
│   ├── Enums/                    # Énumérations PHP (types constants)
│   │   ├── ProjectType.php       # Types: web, mobile, desktop, api
│   │   ├── ProjectStatus.php     # Statuts: pending, in_progress, etc.
│   │   ├── ProjectPriority.php   # Priorités: low, medium, high, critical
│   │   └── UserType.php          # Types: client, developer, admin
│   │
│   └── Http/
│       ├── Controllers/          # Contrôleurs (logique métier)
│       └── Requests/             # Validation des requêtes
│
├── database/
│   ├── migrations/               # Scripts de création DB
│   │   ├── create_users_table.php
│   │   ├── create_projects_table.php
│   │   ├── create_profiles_table.php
│   │   └── create_reviews_table.php
│   │
│   └── seeders/                  # Données de test
│       ├── UserSeeder.php
│       ├── ProjectSeeder.php
│       └── UserSlugSeeder.php
│
├── resources/
│   ├── views/
│   │   ├── components/           # Composants Blade réutilisables
│   │   │   └── layouts/
│   │   │       ├── public.blade.php    # Layout public (sans auth)
│   │   │       └── app.blade.php       # Layout app (avec auth)
│   │   │
│   │   ├── livewire/             # Vues Livewire (templates)
│   │   │   ├── project/
│   │   │   │   ├── project-list.blade.php
│   │   │   │   ├── project-detail.blade.php
│   │   │   │   └── project-filter.blade.php
│   │   │   │
│   │   │   ├── developer/
│   │   │   │   ├── developer-list.blade.php
│   │   │   │   └── developer-profile.blade.php
│   │   │   │
│   │   │   └── portfolio/
│   │   │       └── portfolio-gallery.blade.php
│   │   │
│   │   └── pages/                # Pages principales
│   │       ├── projects.blade.php
│   │       ├── developers.blade.php
│   │       ├── portfolio.blade.php
│   │       └── welcome.blade.php
│   │
│   └── js/
│       ├── app.js               # Point d'entrée JavaScript
│       └── bootstrap.js         # Configuration Alpine.js
│
└── routes/
    ├── web.php                  # Routes HTTP publiques
    ├── api.php                  # Routes API (JSON)
    └── auth.php                 # Routes authentification
```

---

## 📊 Modèles de Données

### 1️⃣ Modèle User (Utilisateur)

**Fichier**: `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // ============================================
    // CONFIGURATION DE BASE
    // ============================================
    
    /**
     * Les attributs qui peuvent être assignés en masse
     * Cela signifie qu'on peut faire: User::create(['name' => '...', 'email' => '...'])
     * 
     * ⚠️ IMPORTANT: Ne jamais ajouter 'password' ici pour la sécurité
     */
    protected $fillable = [
        'name',           // Nom complet de l'utilisateur
        'email',          // Adresse email unique
        'password',       // Mot de passe (hashé)
        'phone',          // Numéro de téléphone
        'avatar',         // URL de la photo de profil
        'user_type',      // Type: 'client' ou 'developer'
        'status',         // Statut: 'active', 'inactive', 'suspended'
        'slug',           // URL-friendly identifier (ex: 'john-doe-123')
    ];

    /**
     * Les attributs à cacher lors de la sérialisation (JSON)
     * Utile pour ne pas exposer le mot de passe dans les API
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à convertir (casting)
     * Convertit automatiquement les valeurs au type spécifié
     */
    protected $casts = [
        'email_verified_at' => 'datetime',  // Convertir en objet Carbon
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELATIONS (Liens avec autres modèles)
    // ============================================

    /**
     * Relation 1-to-1: Un utilisateur a UN profil
     * 
     * Utilisation:
     * $user->profile;              // Accès au profil
     * $user->profile->bio;         // Accès aux propriétés du profil
     * $user->profile()->first();   // Query builder
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Relation 1-to-Many: Un utilisateur a PLUSIEURS projets
     * 
     * Utilisation:
     * $user->projects;             // Tous les projets
     * $user->projects()->count();  // Nombre de projets
     * $user->projects()->where('status', 'completed')->get();
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    /**
     * Relation 1-to-Many: Un développeur a PLUSIEURS projets assignés
     */
    public function developedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'developer_id');
    }

    /**
     * Relation 1-to-Many: Un utilisateur a PLUSIEURS avis
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relation 1-to-Many: Un utilisateur a PLUSIEURS commissions
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class, 'developer_id');
    }

    // ============================================
    // ROUTE MODEL BINDING
    // ============================================

    /**
     * Définit la clé utilisée pour le route binding
     * 
     * Exemple:
     * Route::get('developers/{developer}', DeveloperProfile::class)
     * 
     * Si getRouteKeyName() retourne 'slug':
     * - URL: /developers/john-doe-123
     * - Laravel cherche: User::where('slug', 'john-doe-123')->first()
     * 
     * Si getRouteKeyName() retourne 'id':
     * - URL: /developers/1
     * - Laravel cherche: User::find(1)
     * 
     * ⚠️ NOTE: Utiliser 'id' en développement, 'slug' en production pour SEO
     */
    public function getRouteKeyName(): string
    {
        return 'id'; // Changer en 'slug' pour la production
    }

    // ============================================
    // ACCESSEURS (Propriétés calculées)
    // ============================================

    /**
     * Accesseur: Retourne les initiales de l'utilisateur
     * 
     * Utilisation:
     * $user->initials();  // Retourne 'JD' pour 'John Doe'
     * 
     * Utile pour les avatars par défaut
     */
    public function initials(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            $initials .= strtoupper($name[0] ?? '');
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Accesseur: Retourne le type d'utilisateur en français
     */
    public function getUserTypeLabel(): string
    {
        return match($this->user_type) {
            'client' => 'Client',
            'developer' => 'Développeur',
            'admin' => 'Administrateur',
            default => 'Utilisateur',
        };
    }

    /**
     * Accesseur: Vérifie si l'utilisateur est un développeur
     */
    public function isDeveloper(): bool
    {
        return $this->user_type === 'developer';
    }

    /**
     * Accesseur: Vérifie si l'utilisateur est un client
     */
    public function isClient(): bool
    {
        return $this->user_type === 'client';
    }

    /**
     * Accesseur: Vérifie si l'utilisateur est actif
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
```

**Explication détaillée des concepts**:

| Concept | Explication | Exemple |
|---------|-------------|---------|
| **$fillable** | Propriétés assignables en masse | `User::create(['name' => 'John'])` |
| **$hidden** | Propriétés cachées en JSON | Le mot de passe ne s'affiche pas en API |
| **$casts** | Conversion de type automatique | `email_verified_at` devient objet Carbon |
| **Relations** | Liens entre modèles | `$user->profile` retourne le profil |
| **Route Binding** | Résolution automatique du paramètre | `/developers/123` → cherche User avec id=123 |

---

### 2️⃣ Modèle Project (Projet)

**Fichier**: `app/Models/Project.php`

```php
<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes; // Permet la suppression logique (soft delete)

    // ============================================
    // CONFIGURATION DE BASE
    // ============================================

    /**
     * Les attributs assignables en masse
     * Permet: Project::create(['title' => '...', 'description' => '...'])
     */
    protected $fillable = [
        // Identité du projet
        'code',                    // Code unique (ex: 'PRJ-001')
        'title',                   // Titre du projet
        'description',             // Description longue
        'slug',                    // URL-friendly (ex: 'mon-projet-web')
        
        // Relations
        'client_id',               // ID du client qui a commandé
        'developer_id',            // ID du développeur assigné
        
        // Classification
        'type',                    // Type: web, mobile, desktop, api, consulting
        'status',                  // Statut: pending, in_progress, completed, published
        'priority',                // Priorité: low, medium, high, critical
        
        // Budget
        'budget',                  // Budget prévu (décimal)
        'final_cost',              // Coût réel (décimal)
        'currency',                // Devise (XAF, EUR, USD)
        
        // Dates
        'deadline',                // Date limite
        'started_at',              // Date de début
        'completed_at',            // Date de fin
        
        // Progression
        'progress_percentage',     // Pourcentage d'avancement (0-100)
        
        // Contenu
        'technologies',            // JSON: ["Laravel", "Vue.js", "MySQL"]
        'attachments',             // JSON: fichiers attachés
        'milestones',              // JSON: jalons du projet
        'tasks',                   // JSON: tâches
        'collaborators',           // JSON: collaborateurs (IDs d'utilisateurs)
        
        // Publication
        'is_published',            // Visible publiquement?
        'is_featured',             // Mis en avant?
        
        // Statistiques (dénormalisées pour performance)
        'likes_count',             // Nombre de likes
        'views_count',             // Nombre de vues
        'reviews_count',           // Nombre d'avis
        'average_rating',          // Note moyenne (0-5)
        
        // Admin
        'admin_notes',             // Notes administrateur
        'cancellation_reason',     // Raison d'annulation
        
        // Images
        'featured_image',          // Image principale
        'gallery_images',          // JSON: galerie d'images
    ];

    /**
     * Casting des attributs
     * Convertit automatiquement les types
     */
    protected $casts = [
        // Énums (types constants avec méthodes)
        'type' => ProjectType::class,
        'status' => ProjectStatus::class,
        'priority' => ProjectPriority::class,
        
        // JSON (converti en array automatiquement)
        'technologies' => 'json',
        'attachments' => 'json',
        'milestones' => 'json',
        'tasks' => 'json',
        'collaborators' => 'json',
        'gallery_images' => 'json',
        
        // Booléens
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        
        // Dates (converties en objets Carbon)
        'deadline' => 'date',
        'started_at' => 'date',
        'completed_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime', // Pour soft delete
    ];

    // ============================================
    // RELATIONS
    // ============================================

    /**
     * Relation Inverse: Le projet appartient à UN client
     * 
     * Utilisation:
     * $project->client;           // Objet User du client
     * $project->client->name;     // Nom du client
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relation Inverse: Le projet est assigné à UN développeur
     * 
     * Utilisation:
     * $project->developer;        // Objet User du développeur
     * $project->developer->profile->specialization;
     */
    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    /**
     * Relation 1-to-Many: Un projet a PLUSIEURS avis
     * 
     * Utilisation:
     * $project->reviews;          // Tous les avis
     * $project->reviews()->avg('rating');  // Note moyenne
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relation 1-to-Many: Un projet a PLUSIEURS commissions
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    // ============================================
    // ROUTE MODEL BINDING
    // ============================================

    /**
     * Utilise le slug pour le route binding (meilleur pour SEO)
     * 
     * Route: /projects/{project}
     * URL: /projects/mon-projet-web
     * Laravel cherche: Project::where('slug', 'mon-projet-web')->first()
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ============================================
    // ACCESSEURS (Propriétés calculées)
    // ============================================

    /**
     * Accesseur: Récupère les jalons du projet
     * 
     * ⚠️ IMPORTANT: Utiliser getAttribute() pour éviter les boucles infinies
     * 
     * Utilisation:
     * $project->milestones;       // Retourne un array
     * foreach ($project->milestones as $milestone) { ... }
     */
    public function getMilestonesAttribute()
    {
        // Récupère la valeur brute de la base de données
        $milestones = $this->getAttribute('milestones');
        
        // Si null, retourner array vide
        if ($milestones === null) {
            return [];
        }
        
        // Si c'est une chaîne JSON, décoder
        if (is_string($milestones)) {
            return json_decode($milestones, true) ?? [];
        }
        
        // Si c'est déjà un array, retourner tel quel
        return is_array($milestones) ? $milestones : [];
    }

    /**
     * Accesseur: Récupère les tâches du projet
     * Même logique que getMilestonesAttribute()
     */
    public function getTasksAttribute()
    {
        $tasks = $this->getAttribute('tasks');
        
        if ($tasks === null) {
            return [];
        }
        
        if (is_string($tasks)) {
            return json_decode($tasks, true) ?? [];
        }
        
        return is_array($tasks) ? $tasks : [];
    }

    /**
     * Accesseur: Récupère les collaborateurs du projet
     * Retourne les IDs des utilisateurs collaborateurs
     */
    public function getCollaboratorsAttribute()
    {
        $collaborators = $this->getAttribute('collaborators');
        
        if ($collaborators === null) {
            return [];
        }
        
        if (is_string($collaborators)) {
            return json_decode($collaborators, true) ?? [];
        }
        
        return is_array($collaborators) ? $collaborators : [];
    }

    /**
     * Accesseur: Récupère les images de la galerie
     */
    public function getGalleryImagesAttribute()
    {
        $images = $this->getAttribute('gallery_images');
        
        if ($images === null) {
            return [];
        }
        
        if (is_string($images)) {
            return json_decode($images, true) ?? [];
        }
        
        return is_array($images) ? $images : [];
    }

    /**
     * Accesseur: Récupère les technologies utilisées
     */
    public function getTechnologiesAttribute()
    {
        $technologies = $this->getAttribute('technologies');
        
        if ($technologies === null) {
            return [];
        }
        
        if (is_string($technologies)) {
            return json_decode($technologies, true) ?? [];
        }
        
        return is_array($technologies) ? $technologies : [];
    }

    // ============================================
    // MÉTHODES MÉTIER
    // ============================================

    /**
     * Vérifie si le projet est complété
     * 
     * Utilisation:
     * if ($project->isCompleted()) { ... }
     */
    public function isCompleted(): bool
    {
        return $this->status === ProjectStatus::COMPLETED;
    }

    /**
     * Vérifie si le projet est en cours
     */
    public function isInProgress(): bool
    {
        return $this->status === ProjectStatus::IN_PROGRESS;
    }

    /**
     * Vérifie si le projet est publié
     */
    public function isPublished(): bool
    {
        return $this->is_published === true;
    }

    /**
     * Récupère les projets similaires
     * 
     * Critères de similarité:
     * 1. Même type (web, mobile, etc.)
     * 2. Partage au moins une technologie
     * 3. Statut: published
     * 4. Pas supprimé (soft delete)
     * 
     * Utilisation:
     * $similar = $project->getSimilarProjects(6);
     */
    public function getSimilarProjects(int $limit = 6)
    {
        return Project::query()
            // Exclure le projet actuel
            ->where('id', '!=', $this->id)
            
            // Seulement les projets publiés
            ->where('status', ProjectStatus::PUBLISHED->value)
            
            // Même type OU technologies communes
            ->where(function ($query) {
                $query->where('type', $this->type->value)
                    ->orWhereJsonContains('technologies', $this->technologies);
            })
            
            // Exclure les supprimés
            ->whereNull('deleted_at')
            
            // Ordre aléatoire pour plus de variété
            ->orderByRaw('RAND()')
            
            // Limiter le nombre de résultats
            ->limit($limit)
            
            // Récupérer
            ->get();
    }

    /**
     * Calcule la durée du projet en jours
     * 
     * Utilisation:
     * $duration = $project->getDurationInDays();  // Retourne 45
     */
    public function getDurationInDays(): ?int
    {
        if (!$this->started_at || !$this->completed_at) {
            return null;
        }
        
        return $this->completed_at->diffInDays($this->started_at);
    }

    /**
     * Récupère le statut de progression en pourcentage
     * 
     * Utilisation:
     * echo $project->getProgressPercentage();  // 75
     */
    public function getProgressPercentage(): int
    {
        return $this->progress_percentage ?? 0;
    }

    /**
     * Récupère la barre de progression en HTML
     * Utile pour les templates
     */
    public function getProgressBar(): string
    {
        $percentage = $this->getProgressPercentage();
        $color = match(true) {
            $percentage < 33 => 'bg-red-500',
            $percentage < 66 => 'bg-yellow-500',
            default => 'bg-green-500',
        };
        
        return "<div class='w-full bg-gray-200 rounded-full h-2'>
                    <div class='{$color} h-2 rounded-full' style='width: {$percentage}%'></div>
                </div>";
    }
}
```

**Points clés à retenir**:

| Concept | Explication | Impact |
|---------|-------------|--------|
| **SoftDeletes** | Suppression logique (pas vraiment supprimé) | Les données restent en DB avec `deleted_at` |
| **Casting JSON** | Conversion auto array ↔ JSON | `$project->technologies` retourne un array |
| **Accesseurs** | Propriétés calculées | `$project->milestones` exécute `getMilestonesAttribute()` |
| **getAttribute()** | Récupère la valeur brute | Évite les boucles infinies avec les accesseurs |
| **Route Binding** | Résolution automatique | `/projects/mon-projet` → cherche par slug |

---

### 3️⃣ Modèle Profile (Profil Développeur)

**Fichier**: `app/Models/Profile.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    // ============================================
    // CONFIGURATION DE BASE
    // ============================================

    /**
     * Le nom de la table (par défaut: 'profiles')
     * Peut être personnalisé si nécessaire
     */
    protected $table = 'profiles';

    /**
     * Les attributs assignables en masse
     * Permet: Profile::create(['bio' => '...', 'skills' => [...]])
     */
    protected $fillable = [
        // Relation
        'user_id',                 // ID de l'utilisateur propriétaire
        
        // Informations personnelles
        'bio',                     // Biographie courte
        'specialization',          // Spécialisation (backend, frontend, fullstack, etc.)
        'experience_years',        // Années d'expérience
        
        // Compétences
        'skills',                  // JSON: ["PHP", "Laravel", "Vue.js", ...]
        'education',               // JSON: formations
        'certifications',          // JSON: certifications
        
        // Disponibilité
        'availability',            // Disponibilité: available, busy, unavailable
        'hourly_rate',             // Tarif horaire
        'skill_level',             // Niveau: junior, mid, senior, expert
        
        // Liens externes
        'portfolio_url',           // URL du portfolio personnel
        'github_url',              // Profil GitHub
        'linkedin_url',            // Profil LinkedIn
        'twitter_url',             // Profil Twitter
        
        // Vérification
        'is_verified',             // Profil vérifié par admin?
        'verification_date',       // Date de vérification
        
        // Statistiques
        'total_projects',          // Nombre total de projets
        'total_earnings',          // Gains totaux
        'average_rating',          // Note moyenne
    ];

    /**
     * Casting des attributs
     */
    protected $casts = [
        // JSON arrays
        'skills' => 'json',
        'education' => 'json',
        'certifications' => 'json',
        
        // Booléens
        'is_verified' => 'boolean',
        
        // Dates
        'verification_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELATIONS
    // ============================================

    /**
     * Relation Inverse: Le profil appartient à UN utilisateur
     * 
     * Utilisation:
     * $profile->user;             // Objet User
     * $profile->user->name;       // Nom de l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // ACCESSEURS
    // ============================================

    /**
     * Accesseur: Récupère les compétences
     * Gère la conversion JSON → array de manière sécurisée
     */
    public function getSkillsAttribute()
    {
        $skills = $this->getAttribute('skills');
        
        if ($skills === null) {
            return [];
        }
        
        if (is_string($skills)) {
            return json_decode($skills, true) ?? [];
        }
        
        return is_array($skills) ? $skills : [];
    }

    /**
     * Accesseur: Récupère l'éducation
     */
    public function getEducationAttribute()
    {
        $education = $this->getAttribute('education');
        
        if ($education === null) {
            return [];
        }
        
        if (is_string($education)) {
            return json_decode($education, true) ?? [];
        }
        
        return is_array($education) ? $education : [];
    }

    /**
     * Accesseur: Récupère les certifications
     */
    public function getCertificationsAttribute()
    {
        $certifications = $this->getAttribute('certifications');
        
        if ($certifications === null) {
            return [];
        }
        
        if (is_string($certifications)) {
            return json_decode($certifications, true) ?? [];
        }
        
        return is_array($certifications) ? $certifications : [];
    }

    // ============================================
    // MÉTHODES MÉTIER
    // ============================================

    /**
     * Vérifie si le profil est complet
     * Un profil complet a tous les champs essentiels remplis
     */
    public function isComplete(): bool
    {
        return !empty($this->bio) 
            && !empty($this->specialization)
            && count($this->skills) > 0
            && !empty($this->hourly_rate);
    }

    /**
     * Récupère le pourcentage de complétion du profil
     * Utile pour afficher une barre de progression
     */
    public function getCompletionPercentage(): int
    {
        $fields = [
            'bio' => !empty($this->bio),
            'specialization' => !empty($this->specialization),
            'skills' => count($this->skills) > 0,
            'education' => count($this->education) > 0,
            'certifications' => count($this->certifications) > 0,
            'hourly_rate' => !empty($this->hourly_rate),
            'portfolio_url' => !empty($this->portfolio_url),
            'github_url' => !empty($this->github_url),
            'linkedin_url' => !empty($this->linkedin_url),
        ];
        
        $completed = array_sum(array_values($fields));
        $total = count($fields);
        
        return (int) (($completed / $total) * 100);
    }

    /**
     * Ajoute une compétence à la liste
     * 
     * Utilisation:
     * $profile->addSkill('Laravel');
     */
    public function addSkill(string $skill): void
    {
        $skills = $this->skills ?? [];
        
        if (!in_array($skill, $skills)) {
            $skills[] = $skill;
            $this->update(['skills' => $skills]);
        }
    }

    /**
     * Supprime une compétence
     */
    public function removeSkill(string $skill): void
    {
        $skills = $this->skills ?? [];
        $skills = array_filter($skills, fn($s) => $s !== $skill);
        $this->update(['skills' => array_values($skills)]);
    }

    /**
     * Récupère le label de la spécialisation
     */
    public function getSpecializationLabel(): string
    {
        return match($this->specialization) {
            'backend' => 'Développeur Backend',
            'frontend' => 'Développeur Frontend',
            'fullstack' => 'Développeur Full Stack',
            'mobile' => 'Développeur Mobile',
            'devops' => 'DevOps Engineer',
            'designer' => 'Designer',
            default => 'Développeur',
        };
    }

    /**
     * Récupère le label de la disponibilité
     */
    public function getAvailabilityLabel(): string
    {
        return match($this->availability) {
            'available' => 'Disponible',
            'busy' => 'Occupé',
            'unavailable' => 'Indisponible',
            default => 'Non spécifiée',
        };
    }

    /**
     * Récupère le label du niveau de compétence
     */
    public function getSkillLevelLabel(): string
    {
        return match($this->skill_level) {
            'junior' => 'Junior (0-2 ans)',
            'mid' => 'Intermédiaire (2-5 ans)',
            'senior' => 'Senior (5-10 ans)',
            'expert' => 'Expert (10+ ans)',
            default => 'Non spécifié',
        };
    }
}
```

---

## ⚡ Composants Livewire

### 1️⃣ Composant ProjectDetail (Détail Projet)

**Fichier**: `app/Livewire/Project/ProjectDetail.php`

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Composant Livewire: Affichage détaillé d'un projet
 * 
 * Cycle de vie:
 * 1. mount() - Initialisation du composant
 * 2. render() - Affichage de la vue
 * 3. Écoute des événements Livewire
 * 
 * Utilisation dans la route:
 * Route::get('projects/{project}', ProjectDetail::class)
 */
class ProjectDetail extends Component
{
    // ============================================
    // PROPRIÉTÉS PUBLIQUES
    // ============================================

    /**
     * Le projet à afficher
     * 
     * Type: Project (modèle Eloquent)
     * Assigné automatiquement par route binding
     * 
     * Livewire injecte automatiquement le projet
     * grâce à la route: Route::get('projects/{project}', ProjectDetail::class)
     */
    public Project $project;

    /**
     * Projets similaires (pour suggestions)
     * 
     * Type: Collection Eloquent
     * Contient jusqu'à 6 projets similaires
     */
    public EloquentCollection $similarProjects;

    /**
     * Membres de l'équipe (collaborateurs)
     * 
     * Type: Collection Support
     * Contient les objets User des collaborateurs
     */
    public SupportCollection $teamMembers;

    // ============================================
    // PROPRIÉTÉS CALCULÉES (Computed Properties)
    // ============================================

    /**
     * Statistiques du projet
     * 
     * Structure:
     * [
     *     'views' => 1250,
     *     'likes' => 45,
     *     'reviews' => 8,
     *     'rating' => 4.5,
     * ]
     */
    public array $stats = [];

    /**
     * Progression des jalons
     * 
     * Structure:
     * [
     *     'completed' => 3,
     *     'total' => 5,
     *     'percentage' => 60.0,
     * ]
     */
    public array $milestoneProgress = [];

    // ============================================
    // CYCLE DE VIE: MOUNT
    // ============================================

    /**
     * Initialisation du composant
     * 
     * Appelé UNE SEULE FOIS lors du chargement initial
     * 
     * Paramètres:
     * - $project: Injecté automatiquement par route binding
     * 
     * Responsabilités:
     * 1. Charger les relations (eager loading)
     * 2. Initialiser les propriétés publiques
     * 3. Préparer les données pour la vue
     * 
     * ⚠️ IMPORTANT: Ne pas faire d'appels API lourds ici
     */
    public function mount(Project $project): void
    {
        // ========== ÉTAPE 1: Charger les relations ==========
        // Eager loading: Charge les relations en une seule requête
        // Évite les N+1 queries
        $this->project = $project->load([
            'client',                    // Utilisateur client
            'developer',                 // Utilisateur développeur
            'developer.profile',         // Profil du développeur
            'reviews',                   // Avis du projet
        ]);

        // ========== ÉTAPE 2: Récupérer les projets similaires ==========
        // Utilise la méthode du modèle pour trouver des projets similaires
        $this->similarProjects = $project->getSimilarProjects(6);

        // ========== ÉTAPE 3: Traiter les collaborateurs ==========
        // Les collaborateurs sont stockés en JSON dans la base de données
        // Exemple: [1, 2, 3] (IDs d'utilisateurs)
        
        // Récupère la valeur brute (peut être string JSON ou array)
        $collaborators = $project->getAttribute('collaborators') ?? [];
        
        // Si c'est une chaîne JSON, la décoder
        if (is_string($collaborators)) {
            $collaborators = json_decode($collaborators, true) ?? [];
        }
        
        // Convertir les IDs en objets User
        $this->teamMembers = collect($collaborators)
            ->map(fn ($id) => User::find($id))  // Chercher chaque utilisateur
            ->filter()                           // Enlever les null
            ->values();                          // Réindexer les clés

        // ========== ÉTAPE 4: Initialiser les propriétés calculées ==========
        $this->stats = $this->getStatsProperty();
        $this->milestoneProgress = $this->getMilestoneProgressProperty();
    }

    // ============================================
    // PROPRIÉTÉS CALCULÉES
    // ============================================

    /**
     * Récupère les statistiques du projet
     * 
     * Retour:
     * [
     *     'views' => nombre de vues,
     *     'likes' => nombre de likes,
     *     'reviews' => nombre d'avis,
     *     'rating' => note moyenne,
     * ]
     * 
     * Utilisation dans la vue:
     * {{ $stats['views'] }}
     * {{ $stats['rating'] }}
     */
    public function getStatsProperty(): array
    {
        return [
            'views' => $this->project->views_count ?? 0,
            'likes' => $this->project->likes_count ?? 0,
            'reviews' => $this->project->reviews_count ?? 0,
            'rating' => $this->project->average_rating ?? 0,
        ];
    }

    /**
     * Récupère la progression des jalons
     * 
     * Logique:
     * 1. Récupère tous les jalons
     * 2. Compte ceux qui sont complétés
     * 3. Calcule le pourcentage
     * 
     * Retour:
     * [
     *     'completed' => 3,      // Jalons complétés
     *     'total' => 5,          // Total de jalons
     *     'percentage' => 60.0,  // Pourcentage (0-100)
     * ]
     * 
     * Utilisation dans la vue:
     * Jalon {{ $milestoneProgress['completed'] }}/{{ $milestoneProgress['total'] }}
     * Progression: {{ $milestoneProgress['percentage'] }}%
     */
    public function getMilestoneProgressProperty(): array
    {
        // Récupère les jalons (utilise l'accesseur du modèle)
        // L'accesseur gère la conversion JSON → array
        $milestones = $this->project->milestones ?? [];
        
        // Compte les jalons complétés
        // Cherche les jalons avec 'status' => 'completed'
        $completed = collect($milestones)
            ->where('status', 'completed')
            ->count();
        
        // Total de jalons
        $total = count($milestones);
        
        // Calcule le pourcentage
        // Évite la division par zéro
        $percentage = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
        
        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $percentage,
        ];
    }

    // ============================================
    // ACTIONS (Méthodes publiques)
    // ============================================

    /**
     * Action: Aimer le projet
     * 
     * Appelée quand l'utilisateur clique sur le bouton "Like"
     * 
     * Logique:
     * 1. Incrémenter le compteur de likes
     * 2. Envoyer un événement Livewire
     * 3. Mettre à jour la vue automatiquement
     * 
     * Utilisation dans la vue:
     * <button wire:click="likeProject">Like</button>
     */
    public function likeProject(): void
    {
        // Incrémenter le compteur
        $this->project->increment('likes_count');
        
        // Dispatcher un événement (optionnel)
        $this->dispatch('projectLiked', projectId: $this->project->id);
    }

    /**
     * Action: Partager le projet
     * 
     * Appelée quand l'utilisateur clique sur "Partager"
     * 
     * Utilisation dans la vue:
     * <button wire:click="shareProject">Partager</button>
     */
    public function shareProject(): void
    {
        // Dispatcher un événement JavaScript
        $this->dispatch('projectShared', projectId: $this->project->id);
    }

    // ============================================
    // RENDU DE LA VUE
    // ============================================

    /**
     * Rend la vue du composant
     * 
     * Appelé après mount() et après chaque mise à jour
     * 
     * Retour: Vue Blade compilée
     * 
     * Fichier de vue:
     * resources/views/livewire/project/project-detail.blade.php
     * 
     * Variables disponibles dans la vue:
     * - $project: Le projet
     * - $similarProjects: Projets similaires
     * - $teamMembers: Collaborateurs
     * - $stats: Statistiques
     * - $milestoneProgress: Progression des jalons
     */
    public function render(): View
    {
        return view('livewire.project.project-detail');
    }
}
```

**Explication du cycle de vie Livewire**:

```
┌─────────────────────────────────────────────────────────────┐
│                    CYCLE DE VIE LIVEWIRE                    │
└─────────────────────────────────────────────────────────────┘

1. INITIALISATION (Première visite)
   ↓
   Route::get('projects/{project}', ProjectDetail::class)
   ↓
   Laravel injecte le $project via route binding
   ↓
   mount($project) est appelé
   ↓
   Propriétés publiques sont initialisées
   ↓
   render() est appelé
   ↓
   Vue est affichée

2. INTERACTION (Utilisateur clique sur un bouton)
   ↓
   <button wire:click="likeProject">
   ↓
   likeProject() est appelée
   ↓
   Les propriétés publiques sont mises à jour
   ↓
   render() est appelé
   ↓
   Vue est mise à jour (AJAX)

3. ÉCOUTEUR D'ÉVÉNEMENTS (Événement reçu)
   ↓
   #[On('eventName')]
   public function handleEvent() { ... }
   ↓
   Méthode est exécutée
   ↓
   render() est appelé
   ↓
   Vue est mise à jour
```

---

### 2️⃣ Composant ProjectList (Liste Projets)

**Fichier**: `app/Livewire/Project/ProjectList.php`

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Composant Livewire: Liste paginée et filtrée des projets
 * 
 * Fonctionnalités:
 * - Recherche par titre
 * - Filtrage par catégorie (type)
 * - Filtrage par technologie
 * - Pagination (12 projets par page)
 * - Mise à jour en temps réel (reactive)
 * 
 * Utilisation dans la route:
 * Route::get('projects', function() { return view('projects'); })
 * 
 * Dans la vue:
 * @livewire('project.project-list')
 */
class ProjectList extends Component
{
    use WithPagination; // Ajoute les méthodes de pagination

    // ============================================
    // PROPRIÉTÉS PUBLIQUES (Réactives)
    // ============================================

    /**
     * Chaîne de recherche
     * 
     * Utilisation:
     * <input wire:model="search" type="text" placeholder="Rechercher...">
     * 
     * Livewire met à jour automatiquement quand l'utilisateur tape
     * La vue se rafraîchit automatiquement (reactive)
     */
    public string $search = '';

    /**
     * Filtre par catégorie (type de projet)
     * 
     * Valeurs possibles:
     * - 'all' (tous)
     * - 'web' (applications web)
     * - 'mobile' (applications mobile)
     * - 'desktop' (applications desktop)
     * - 'api' (API REST)
     * - 'consulting' (consulting)
     */
    public string $categoryFilter = 'all';

    /**
     * Filtre par technologie
     * 
     * Valeurs possibles:
     * - 'all' (toutes)
     * - 'laravel'
     * - 'vue'
     * - 'react'
     * - etc.
     */
    public string $techFilter = 'all';

    /**
     * Nombre de projets par page
     */
    public int $perPage = 12;

    // ============================================
    // PROPRIÉTÉS CALCULÉES (Computed)
    // ============================================

    /**
     * Récupère la liste paginée des projets
     * 
     * Logique:
     * 1. Récupère tous les projets publiés
     * 2. Applique les filtres de recherche
     * 3. Applique les filtres de catégorie
     * 4. Applique les filtres de technologie
     * 5. Trie par date (plus récents d'abord)
     * 6. Pagine les résultats
     * 
     * Utilisation:
     * @foreach ($this->projects as $project)
     *     <x-project-card :project="$project" />
     * @endforeach
     * 
     * {{ $this->projects->links() }}  <!-- Pagination -->
     */
    public function getProjectsProperty(): LengthAwarePaginator
    {
        return Project::query()
            // ========== FILTRE 1: Statut ==========
            // Seulement les projets publiés
            ->where('status', 'published')
            
            // ========== FILTRE 2: Recherche ==========
            // Si l'utilisateur a tapé quelque chose
            ->when($this->search, function ($query) {
                // Chercher dans le titre et la description
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            
            // ========== FILTRE 3: Catégorie ==========
            // Si un filtre de catégorie est sélectionné
            ->when($this->categoryFilter !== 'all', function ($query) {
                // Chercher par type exact
                $query->where('type', $this->categoryFilter);
            })
            
            // ========== FILTRE 4: Technologie ==========
            // Si un filtre de technologie est sélectionné
            ->when($this->techFilter !== 'all', function ($query) {
                // Chercher dans le JSON 'technologies'
                // whereJsonContains: Vérifie si le JSON contient la valeur
                $query->whereJsonContains('technologies', $this->techFilter);
            })
            
            // ========== TRI ==========
            // Plus récents d'abord
            ->latest()
            
            // ========== PAGINATION ==========
            // Paginer par $perPage (12 par défaut)
            ->paginate($this->perPage);
    }

    // ============================================
    // RENDU
    // ============================================

    /**
     * Rend la vue du composant
     * 
     * Fichier de vue:
     * resources/views/livewire/project/project-list.blade.php
     * 
     * Variables disponibles:
     * - $projects: Liste paginée des projets
     * - $search: Chaîne de recherche
     * - $categoryFilter: Filtre de catégorie
     * - $techFilter: Filtre de technologie
     */
    public function render()
    {
        return view('livewire.project.project-list');
    }
}
```

**Explication des filtres**:

```php
// ========== FILTRE: when() ==========
// Syntaxe: ->when(condition, callback)
// Si condition est true, exécute le callback

// Exemple 1: Recherche
->when($this->search, function ($query) {
    // Exécuté seulement si $this->search n'est pas vide
    $query->where('title', 'like', '%' . $this->search . '%');
})

// Exemple 2: Filtre catégorie
->when($this->categoryFilter !== 'all', function ($query) {
    // Exécuté seulement si un filtre est sélectionné
    $query->where('type', $this->categoryFilter);
})

// ========== whereJsonContains() ==========
// Cherche une valeur dans un champ JSON
// Exemple: technologies = ["Laravel", "Vue.js", "MySQL"]
// whereJsonContains('technologies', 'Laravel') → MATCH
// whereJsonContains('technologies', 'React') → NO MATCH
```

---

## 🔗 Routes et Binding

### Structure des Routes

**Fichier**: `routes/web.php`

```php
<?php

use App\Livewire\Project\ProjectDetail;
use App\Livewire\Project\ProjectList;
use App\Livewire\Developer\DeveloperList;
use App\Livewire\Developer\DeveloperProfile;
use App\Livewire\Portfolio\PortfolioGallery;

// ============================================
// ROUTES PUBLIQUES (Sans authentification)
// ============================================

/**
 * Route: Page d'accueil
 * URL: /
 * Méthode: GET
 */
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========== PROJETS ==========

/**
 * Route: Liste des projets
 * URL: /projects
 * Composant: ProjectList
 * 
 * Fonctionnalités:
 * - Recherche par titre
 * - Filtrage par catégorie
 * - Filtrage par technologie
 * - Pagination
 */
Route::get('projects', function() {
    return view('projects');
})->name('projects.list');

/**
 * Route: Détail d'un projet (par slug)
 * URL: /projects/mon-projet-web
 * Composant: ProjectDetail
 * 
 * Route Binding:
 * - Paramètre: {project}
 * - Clé: slug (défini dans Project::getRouteKeyName())
 * - Résolution: Laravel cherche Project::where('slug', 'mon-projet-web')->first()
 * - Injection: Le projet est injecté dans ProjectDetail::mount($project)
 * 
 * Erreur 404: Si le projet n'existe pas
 */
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');

/**
 * Route: Détail d'un projet (par ID - redirection)
 * URL: /projects/by-id/45
 * 
 * Utilisé pour les anciennes URLs ou les liens internes
 * Redirige vers la nouvelle URL avec le slug
 * 
 * Exemple:
 * /projects/by-id/45 → /projects/mon-projet-web (301 redirect)
 */
Route::get('projects/by-id/{id}', function($id) {
    $project = App\Models\Project::findOrFail($id);
    return redirect()->route('projects.detail', $project->slug);
})->name('projects.detail.by-id');

/**
 * Route: Filtrer les projets (AJAX)
 * URL: /projects/filter
 * Composant: ProjectFilter
 * 
 * Utilisé pour les appels AJAX sans rechargement de page
 */
Route::get('projects/filter', ProjectFilter::class)->name('projects.filter');

// ========== DÉVELOPPEURS ==========

/**
 * Route: Liste des développeurs
 * URL: /developers
 * Composant: DeveloperList
 * 
 * Fonctionnalités:
 * - Recherche par nom
 * - Filtrage par spécialisation
 * - Filtrage par disponibilité
 * - Pagination
 */
Route::get('developers', function() {
    return view('developers');
})->name('developers.list');

/**
 * Route: Recherche développeurs (AJAX)
 * URL: /developers/search
 * Composant: DeveloperSearch
 */
Route::get('developers/search', DeveloperSearch::class)->name('developers.search');

/**
 * Route: Filtrer développeurs (AJAX)
 * URL: /developers/filter
 * Composant: DeveloperFilter
 */
Route::get('developers/filter', DeveloperFilter::class)->name('developers.filter');

/**
 * Route: Profil développeur
 * URL: /developers/john-doe-123
 * Composant: DeveloperProfile
 * 
 * Route Binding:
 * - Paramètre: {developer}
 * - Clé: id (défini dans User::getRouteKeyName())
 * - Résolution: Laravel cherche User::find(123)
 * - Injection: L'utilisateur est injecté dans DeveloperProfile::mount($developer)
 * 
 * Note: Utiliser 'slug' en production pour SEO
 */
Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');

// ========== PORTFOLIO ==========

/**
 * Route: Galerie portfolio
 * URL: /portfolio
 * Composant: PortfolioGallery
 * 
 * Affiche tous les projets publiés avec filtrage
 */
Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');

/**
 * Route: Carte projet (composant)
 * URL: /portfolio/project-card
 * Composant: ProjectCard
 * 
 * Utilisé pour afficher une carte projet
 */
Route::get('portfolio/project-card', ProjectCard::class)->name('portfolio.project-card');

/**
 * Route: Like projet (AJAX)
 * URL: /portfolio/project-like
 * Composant: ProjectLike
 * 
 * Utilisé pour aimer un projet sans rechargement
 */
Route::get('portfolio/project-like', ProjectLike::class)->name('portfolio.project-like');

// ============================================
// ROUTES PROTÉGÉES (Nécessitent authentification)
// ============================================

/**
 * Middleware 'auth': Vérifie que l'utilisateur est connecté
 * Middleware 'verified': Vérifie que l'email est confirmé
 * 
 * Si non connecté: Redirection vers /login
 * Si email non confirmé: Redirection vers /email/verify
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ========== DASHBOARD ==========
    
    /**
     * Route: Dashboard utilisateur
     * URL: /dashboard
     * Vue: dashboard.blade.php
     * 
     * Affiche le tableau de bord personnalisé
     */
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    // ========== PARAMÈTRES ==========
    
    /**
     * Route: Redirection paramètres
     * URL: /settings → /settings/profile
     */
    Route::redirect('settings', 'settings/profile');
    
    /**
     * Route: Paramètres profil
     * URL: /settings/profile
     * Composant: Profile
     * 
     * Permet de modifier:
     * - Nom, email, téléphone
     * - Avatar
     * - Bio, compétences, etc.
     */
    Route::get('settings/profile', Profile::class)->name('profile.edit');
    
    /**
     * Route: Paramètres mot de passe
     * URL: /settings/password
     * Composant: Password
     * 
     * Permet de changer le mot de passe
     */
    Route::get('settings/password', Password::class)->name('user-password.edit');
    
    /**
     * Route: Paramètres apparence
     * URL: /settings/appearance
     * Composant: Appearance
     * 
     * Permet de choisir:
     * - Thème (clair/sombre/système)
     * - Langue
     */
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
    
    // ========== PROJETS ==========
    
    /**
     * Route: Suivi de progression d'un projet
     * URL: /projects/45/progress
     * Composant: ProjectProgress
     * 
     * Permet au développeur de suivre la progression
     * Accessible seulement par le développeur assigné
     */
    Route::get('projects/{project}/progress', ProjectProgress::class)->name('projects.progress');
    
    // ========== COMMISSIONS ==========
    
    /**
     * Route: Dashboard commissions
     * URL: /commissions
     * Composant: CommissionDashboard
     * 
     * Affiche:
     * - Commissions en attente
     * - Commissions payées
     * - Gains totaux
     * - Historique
     */
    Route::get('commissions', CommissionDashboard::class)->name('commissions.dashboard');
});
```

### Route Model Binding Détaillé

```php
// ============================================
// ROUTE MODEL BINDING: EXPLICATION COMPLÈTE
// ============================================

/**
 * Qu'est-ce que le Route Model Binding?
 * 
 * C'est un mécanisme qui résout automatiquement les paramètres
 * de route en modèles Eloquent.
 * 
 * Avantages:
 * 1. Code plus propre (pas de findOrFail() manuel)
 * 2. Gestion automatique des erreurs 404
 * 3