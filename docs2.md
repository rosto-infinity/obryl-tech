

Voici une explication détaillée de la structure et des portions de code de votre documentation, suivie du fichier mis à jour avec les corrections et les meilleures pratiques (notamment la gestion sûre du JSON et l'utilisation de PHP Enums).

---

# 📚 Explication Détaillée du Code

## 1. Architecture Générale
Cette section pose les bases. L'objectif est d'utiliser une stack moderne (PHP 8.4 / Laravel 12) pour créer une application à page unique (SPA) sans utiliser de framework JS lourd (React/Vue), grâce à **Livewire**.

*   **Structure des Dossiers :** Séparation logique des responsabilités.
    *   `app/Enums/` : Stocke les types statiques (ex: `UserType::DEVELOPER`). C'est la tendance 2026 pour remplacer les `enum` SQL qui sont rigides.
    *   `app/Livewire/` : Chaque dossier (`Project`, `Developer`) contient les composants gérant l'interface et la logique métier.

## 2. Modèles de Données (Eloquent)
Les modèles sont l'interface avec votre base de données MySQL.

*   **Modèle Project (`Project.php`) :**
    *   **`$fillable`** : Définit quels champs peuvent être remplis massivement (ex: `$project->update([...])`).
    *   **`$casts`** : C'est crucial. `'technologies' => 'json'` indique à Laravel que si la base de données contient `"['Laravel', 'Vue']"`, il doit le transformer automatiquement en tableau PHP `['Laravel', 'Vue']`.
    *   **`getRouteKeyName()`** : Retourne `'slug'`. Cela signifie que l'URL sera `/projects/mon-super-projet` au lieu de `/projects/5`. C'est vital pour le SEO.

*   **Modèle User (`User.php`) :**
    *   Utilise des relations (`hasOne`, `hasMany`) pour lier l'utilisateur aux projets et au profil.
    *   Le binding utilise temporairement `'id'`, mais doit migrer vers `'slug'`.

## 3. Composants Livewire
C'est le cœur de l'application.

*   **ProjectDetail (`App\Livewire\Project\ProjectDetail.php`) :**
    *   **`mount(Project $project)`** : C'est le constructeur du composant. Laravel injecte automatiquement le projet depuis l'URL.
    *   **La Correction Importante (JSON)** : Dans la version mise à jour, nous utilisons une méthode `toArray()`. Pourquoi ? Parfois Livewire peut transmettre du JSON brut (String) au lieu d'un tableau PHP. Si on fait `count($string)`, PHP 8.4 lance une erreur fatale. La méthode `toArray` garantit qu'on travaille toujours avec un tableau.
    *   **Eager Loading (`load`)** : `$project->load(['client', ...])` permet de récupérer toutes les relations en une seule requête SQL, évitant le problème N+1.

*   **DeveloperList (`App\Livewire\Developer\DeveloperList.php`) :**
    *   **Pagination** : Utilise `LengthAwarePaginator` pour afficher les développeurs page par page (performance).
    *   **Filtrage Dynamique** : Les méthodes `when()` ajoutent des filtres SQL seulement si l'utilisateur a entré une recherche ou sélectionné une catégorie.

## 4. Routes et Binding
Définit comment les URLs mènent au code.

*   **`Route::get('projects/{project}', ProjectDetail::class)`** : C'est la méthode moderne. On ne passe plus par une Closure `function() {}`. On pointe directement vers la classe Livewire.
*   **Route Model Binding** : Laravel voit `{project}` dans l'URL et cherche automatiquement dans la base de données via le `slug`. Il injecte ensuite l'objet `$project` dans le composant.

## 5. Vues et Layouts
Gère l'aspect visuel avec TailwindCSS et Blade.

*   **Dark Mode Natif** : Le code JS dans le layout `public.blade.php` gère le thème sans dépendance externe. Il écoute les préférences système (`prefers-color-scheme`) et stocke le choix dans `localStorage`.

---

# 📄 Fichier de Documentation Mis à Jour

Voici le fichier `docs-projet-dev-portfolio.md` corrigé et optimisé avec les bonnes pratiques (Enum PHP, gestion sûre du JSON, binding par Slug).

```markdown
# Documentation Projet - Portfolio Développeurs

## 📋 Table des Matières

1. [Architecture Générale](#architecture-générale)
2. [Modèles de Données](#modèles-de-données)
3. [Enums PHP (2026 Standard)](#enums-php-2026-standard)
4. [Composants Livewire](#composants-livewire)
5. [Routes et Binding](#routes-et-binding)
6. [Vues et Layouts](#vues-et-layouts)
7. [Processus de Migration](#processus-de-migration)
8. [Dépannage et Solutions](#dépannage-et-solutions)

---

## 🏗️ Architecture Générale

### Stack Technique
- **PHP**: 8.4.16
- **Laravel**: 12.44.0
- **Livewire**: 3.x
- **Frontend**: Blade + Alpine.js + TailwindCSS
- **Base de données**: MySQL

### Structure des Dossiers
```
├── app/
│   ├── Models/           # Modèles Eloquent
│   ├── Livewire/         # Composants Livewire
│   │   ├── Project/      # Composants projets
│   │   ├── Developer/    # Composants développeurs
│   │   ├── Portfolio/    # Composants portfolio
│   │   └── Settings/     # Composants paramètres
│   └── Enums/            # Énumérations PHP (Pure PHP)
├── database/
│   ├── migrations/       # Migrations DB
│   └── seeders/         # Seeders
├── resources/
│   ├── views/
│   │   ├── livewire/     # Vues Livewire
│   │   └── components/   # Composants Blade
│   └── js/              # JavaScript
└── routes/
    └── web.php          # Routes web
```

---

## 📊 Modèles de Données

### Modèle User
```php
<?php

namespace App\Models;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'phone', 
        'avatar', 'user_type', 'status', 'slug'
    ];

    protected $casts = [
        'user_type' => \App\Enums\UserType::class,
        'status' => \App\Enums\Status::class,
    ];

    // Relations
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    // Route binding
    public function getRouteKeyName(): string
    {
        return 'id'; // À remplacer par 'slug' après migration
    }
}
```

### Modèle Project
```php
<?php

namespace App\Models;

use App\Enums\ProjectType;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'slug', 'client_id', 
        'developer_id', 'type', 'status', 'priority',
        'budget', 'technologies', 'milestones', 'tasks'
    ];

    protected $casts = [
        'type' => ProjectType::class,
        'status' => ProjectStatus::class,
        'technologies' => 'json',
        'milestones' => 'json',
        'tasks' => 'json',
        'collaborators' => 'json',
    ];

    // Relations
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Route binding par slug
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
```

---

## 🚀 Enums PHP (2026 Standard)

En 2026, on évite `enum` en base de données. On utilise `string` en DB + PHP Enums Backed.

### Définition de l'Enum
**Fichier : `app/Enums/ProjectStatus.php`**
```php
<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
    case ARCHIVED = 'archived';
}
```

### Migration Correspondante
```php
// Dans la table "projects"
$table->string('status')->default('published'); // STRING au lieu de ENUM
```

### Utilisation
```php
// Dans le code
$project->status = ProjectStatus::PUBLISHED; // Laravel sauvegarde 'published'
if ($project->status === ProjectStatus::PUBLISHED) { ... } // Comparaison stricte
```

---

## ⚡ Composants Livewire

### 1. Composant ProjectDetail (Optimisé & Sécurisé)

Ce composant est corrigé pour gérer les cas où le JSON arrive sous forme de string (bug fréquent dans Livewire).

```php
<?php

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\View\View;
use Livewire\Component;

class ProjectDetail extends Component
{
    public Project $project;
    public EloquentCollection $similarProjects;
    public SupportCollection $teamMembers;
    
    public array $stats = [];
    public array $milestoneProgress = [];

    public function mount(Project $project): void
    {
        // 1. Charger les relations avec eager loading
        $this->project = $project->load(['client', 'developer.profile', 'reviews']);
        
        // 2. Récupérer les projets similaires
        $this->similarProjects = $project->getSimilarProjects(6);
        
        // --- CORRECTION CRITIQUE : NORMALISATION DES CHAMPS JSON ---
        // On force la conversion String -> Array pour éviter les count() errors
        $this->project->technologies = $this->toArray($this->project->technologies);
        $this->project->milestones = $this->toArray($this->project->milestones);
        $this->project->collaborators = $this->toArray($this->project->collaborators);
        // -----------------------------------------------------------

        // 3. Initialiser les stats
        $this->stats = $this->getStatsProperty();
        $this->milestoneProgress = $this->getMilestoneProgressProperty();
        
        // 4. Gérer les membres de l'équipe
        $collaborators = $this->project->collaborators; // Maintenant un tableau
        
        $this->teamMembers = collect($collaborators)
            ->map(fn ($id) => User::find($id))
            ->filter()
            ->values();
    }

    /**
     * Helper pour convertir les JSON strings en tableau PHP proprement.
     */
    private function toArray($value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return is_array($value) ? $value : [];
    }

    public function getMilestoneProgressProperty(): array
    {
        // $this->project->milestones est garanti être un tableau grâce à mount()
        $milestones = $this->project->milestones ?? [];
        
        $completed = collect($milestones)->where('status', 'completed')->count();
        $total = count($milestones);
        
        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
        ];
    }

    public function getStatsProperty(): array
    {
        return [
            'views' => $this->project->views_count ?? 0,
            'likes' => $this->project->likes_count ?? 0,
            'reviews' => $this->project->reviews_count ?? 0,
            'rating' => $this->project->average_rating ?? 0,
        ];
    }

    public function render(): View
    {
        return view('livewire.project.project-detail');
    }
}
```

---

## 🛣️ Routes et Binding

### Structure des Routes

```php
// routes/web.php

use App\Livewire\Project\ProjectDetail;
use App\Livewire\Project\ProjectFilter;
use App\Livewire\Developer\DeveloperProfile;
use App\Livewire\Portfolio\PortfolioGallery;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// --- PROJETS ---
// Liste : affiche simplement la vue contenant le composant Livewire
Route::get('projects', function() { return view('projects'); })->name('projects.list');

// Détail : Binding direct vers le composant Livewire
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');

// Filtres
Route::get('projects/filter', ProjectFilter::class)->name('projects.filter');

// --- DÉVELOPPEURS ---
Route::get('developers', function() { return view('developers'); })->name('developers.list');
Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');

// --- PORTFOLIO ---
Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');

// --- PROTECTED (Authentifié) ---
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('projects/{project}/progress', \App\Livewire\Project\ProjectProgress::class)->name('projects.progress');
});
```

### Route Model Binding

#### Configuration du Binding
```php
// Project.php - Binding par slug
public function getRouteKeyName(): string
{
    return 'slug';
}
```

**Comment ça marche :**
1. URL : `/projects/mon-projet-web`
2. Laravel appelle `Project::where('slug', 'mon-projet-web')->first()`
3. Livewire reçoit l'objet `$project` directement dans `mount`.

---

## 🔄 Processus de Migration

### 1. Migration des Slugs (Base de Données)

```php
// database/migrations/xxxx_add_slug_to_projects_table.php
public function up(): void
{
    Schema::table('projects', function (Blueprint $table) {
        $table->string('slug')->nullable()->unique()->after('title');
    });
}
```

### 2. Seeder pour générer les Slugs

```php
// database/seeders/ProjectSlugSeeder.php
class ProjectSlugSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::whereNull('slug')->get();
        
        foreach ($projects as $project) {
            // Génère un slug unique basé sur le titre et l'ID
            $slug = Str::slug($project->title) . '-' . $project->id;
            
            $originalSlug = $slug;
            $counter = 1;
            
            // Gestion des doublons (si deux projets ont le même titre)
            while (Project::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $project->update(['slug' => $slug]);
        }
    }
}
```

---

## 🐛 Dépannage et Solutions

### 1. Erreur: "count(): Argument #1 must be of type Countable|array, string given"
**Cause**: Livewire a parfois du mal à caster le JSON en tableau directement, surtout sur des properties typées.

**Solution**: Normaliser les données dans le `mount` (voir section Composants Livewire ci-dessus).

### 2. Erreur: "Missing required parameter for [Route: projects.detail]"
**Cause**: Utilisation d'une Closure dans `web.php` qui ne passait pas la variable, ou variable `$project` non initialisée dans le composant.

**Solution**: 
```php
// ✅ Dans routes/web.php
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');

// ✅ Dans ProjectDetail.php
public Project $project; // Typage force l'injection automatique
```

### 3. Erreur: "Attempt to read property "value" on null"
**Cause**: Accès à une Enum null (ex: `$this->type->value` alors que le champ est NULL).

**Solution**: Utiliser l'opérateur Nullsafe `?->` ou vérifier l'existence.
```php
// ✅ Sécurisé
$query->where('type', $this->type?->value);
```

---

## 📝 Checklist de Déploiement

### Avant la Mise en Production

- [ ] Migrer les colonnes `enum` vers `string`.
- [ ] Créer et lancer les Seeders de Slugs.
- [ ] Activer le binding par `slug` dans les modèles.
- [ ] Vérifier toutes les commandes `count()` sur des potentiels JSON.

*Dernière mise à jour: Janvier 2026*
```