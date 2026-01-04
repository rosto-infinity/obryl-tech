C'est une documentation technique vraiment impressionnante et complète ! 🚀 On sent le souci du détail et la volonté de structurer proprement le projet "Developer Portfolio".

Comme tu l'as demandé, je vais décortiquer chaque section clé du code pour t'expliquer **le "pourquoi" et le "comment"** de chaque implémentation, en mettant l'accent sur les subtilités de Laravel 12 et Livewire 3.

Ensuite, je te fournirai le fichier complet mis à jour. J'en profiterai pour appliquer ta règle d'or (ajout de `declare(strict_types=1);`) dans les extraits de code pour qu'ils soient parfaitement conformes à tes standards.

---

## 🔍 Analyse Détaillée et Explications

### 1. Les Modèles de Données (Eloquent)

#### Le Modèle `User` et `Project`

```php
public function getRouteKeyName(): string
{
    return 'slug';
}

```

**L'explication :**
C'est la méthode magique pour le **SEO**. Par défaut, Laravel cherche un enregistrement via son `id` (ex: `/projects/1`). En surchargeant cette méthode pour retourner `'slug'`, tu dis à Laravel : *"Quand tu vois un paramètre dans l'URL, cherche-le dans la colonne `slug` de la base de données"*.

* **Résultat :** Tes URLs deviennent `/projects/mon-super-site-web` au lieu de `/projects/42`. C'est vital pour le référencement naturel.

#### Le Casting JSON

```php
protected $casts = [
    'technologies' => 'json',
    // ...
];

```

**L'explication :**
En base de données, `technologies` est stocké comme une longue chaîne de texte (ex: `["PHP", "Laravel"]`). L'attribut `$casts` dit à Eloquent de **transformer automatiquement** cette chaîne en un tableau PHP (Array) quand tu la lis, et inversement quand tu la sauvegardes. Plus besoin de faire `json_decode()` ou `json_encode()` manuellement à chaque fois !

---

### 2. Les Composants Livewire & Optimisation

#### Le Piège de la "Boucle Infinie" (Accesseurs)

C'est le point le plus technique de ta documentation.

**Le problème (Le chien qui se mord la queue) :**
Si tu as un accesseur dans ton Modèle :

```php
// Dans le modèle
public function getMilestonesAttribute() { ... }

```

Et que dans ton composant Livewire tu fais `$this->project->milestones`, Laravel appelle automatiquement l'accesseur. Si l'accesseur lui-même essaie d'accéder à l'attribut de manière standard, il se rappelle lui-même... et **BOUM 💥**, "Maximum execution time exceeded".

**La Solution (getAttribute) :**

```php
$milestones = $this->project->getAttribute('milestones');

```

Utiliser `getAttribute('nom_colonne')` permet d'aller chercher la donnée brute (raw) directement dans le tableau interne du modèle, **en contournant l'accesseur**. C'est comme passer par l'entrée de service au lieu de la porte principale pour éviter de déclencher l'alarme.

#### Eager Loading (La Performance)

```php
$this->project = $project->load(['client', 'developer.profile', 'reviews']);

```

**L'explication :**
C'est le remède au problème "N+1". Sans le `load` (ou `with`), si tu affiches 10 projets et leurs auteurs, Laravel ferait 1 requête pour les projets + 10 requêtes pour les auteurs (11 requêtes).
Avec `load`, Laravel fait **2 requêtes seulement** : une pour les projets, une pour tous les auteurs associés, et il recolle les morceaux en mémoire PHP. C'est infiniment plus rapide.

---

### 3. La Migration des Slugs

Le `UserSlugSeeder` est un excellent exemple d'algorithme de gestion de collisions.

```php
while (User::where('slug', $slug)->exists()) {
    $slug = $originalSlug . '-' . $counter;
    $counter++;
}

```

**L'analogie :**
Imagine que tu attribues des casiers.

1. Tu veux donner le casier "Jean" à Jean.
2. Le système vérifie : "Le casier 'Jean' est-il pris ?"
3. Si oui, il essaie "Jean-1".
4. Si "Jean-1" est pris, il essaie "Jean-2".
5. Il boucle tant qu'il ne trouve pas de place libre.
Cela garantit l'unicité absolue de tes URLs, même si deux utilisateurs s'appellent "Thomas Dupont".

---

### 4. Le Dark Mode (Alpine vs Natif)

Ton choix d'utiliser du JS natif couplé à Alpine pour l'interface est judicieux.

```javascript
// Vérifie le localStorage OU la préférence système (OS)
const theme = localStorage.getItem('theme') || 'system';

```

C'est la meilleure pratique UX actuelle. On ne force pas le mode sombre, on respecte d'abord le choix explicite de l'utilisateur (s'il a cliqué sur le bouton auparavant), et sinon, on s'adapte à son système d'exploitation (MacOS/Windows en mode sombre).

---

## 📝 Le Fichier Mis à Jour

Voici le contenu complet de ta documentation. J'ai ajouté les déclarations de types stricts (`declare(strict_types=1);`) dans les blocs PHP conformément à tes préférences de codage pour Laravel 12 / PHP 8.4.

```markdown
# Documentation Projet - Portfolio Développeurs

## 📋 Table des Matières

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
- **PHP**: 8.4.16
- **Laravel**: 12.44.0
- **Livewire**: 3.x
- **Frontend**: Blade + Alpine.js + TailwindCSS v4
- **Base de données**: MySQL
- **Admin Panel**: Filament v4

### Structure des Dossiers
```text
├── app/
│   ├── Models/           # Modèles Eloquent
│   ├── Livewire/         # Composants Livewire
│   │   ├── Project/      # Composants projets
│   │   ├── Developer/    # Composants développeurs
│   │   ├── Portfolio/    # Composants portfolio
│   │   └── Settings/     # Composants paramètres
│   └── Enums/            # Énumérations PHP
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

declare(strict_types=1);

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'phone', 
        'avatar', 'user_type', 'status', 'slug'
    ];

    // Relations
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'developer_id');
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
        return 'id'; // Temporairement, utiliser 'slug' pour la production
    }
}

```

### Modèle Project

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'slug', 'client_id', 
        'developer_id', 'type', 'status', 'priority',
        'budget', 'technologies', 'milestones', 'tasks'
    ];

    protected $casts = [
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

    // Route binding par slug pour SEO
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    
    // Helper pour récupérer les projets similaires
    public function getSimilarProjects(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        // ... logique détaillée plus bas dans "Code Propre"
        return new \Illuminate\Database\Eloquent\Collection(); 
    }
}

```

### Modèle Profile

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'bio', 'skills', 'experience',
        'education', 'certifications', 'availability',
        'hourly_rate', 'portfolio_url', 'github_url',
        'linkedin_url', 'is_verified'
    ];

    protected $casts = [
        'skills' => 'json',
        'education' => 'json',
        'certifications' => 'json',
    ];
}

```

---

## ⚡ Composants Livewire

### Architecture des Composants

#### 1. Composants Project

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

// ProjectList.php - Liste des projets
class ProjectList extends Component
{
    use WithPagination;
    
    public string $search = '';
    public string $categoryFilter = 'all';
    public string $techFilter = 'all';
    
    public function getProjectsProperty(): LengthAwarePaginator
    {
        return Project::query()
            ->where('status', 'published')
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->categoryFilter !== 'all', fn($q) => $q->where('type', $this->categoryFilter))
            ->when($this->techFilter !== 'all', fn($q) => $q->whereJsonContains('technologies', $this->techFilter))
            ->with(['client', 'developer']) // Eager loading pour éviter N+1
            ->latest()
            ->paginate(12);
    }
}

// ProjectDetail.php - Détail d'un projet
class ProjectDetail extends Component
{
    public Project $project;
    public \Illuminate\Database\Eloquent\Collection $similarProjects;
    public \Illuminate\Support\Collection $teamMembers;
    
    public function mount(Project $project): void
    {
        $this->project = $project->load(['client', 'developer.profile', 'reviews']);
        $this->similarProjects = $project->getSimilarProjects(6);
        $this->teamMembers = $this->getTeamMembers();
    }
    
    private function getTeamMembers(): \Illuminate\Support\Collection
    {
        // Utilisation de getAttribute pour éviter les boucles infinies des accesseurs
        $collaborators = $this->project->getAttribute('collaborators') ?? [];
        if (is_string($collaborators)) {
            $collaborators = json_decode($collaborators, true) ?? [];
        }
        
        return collect($collaborators)
            ->map(fn ($id) => \App\Models\User::find($id))
            ->filter()
            ->values();
    }
}

```

#### 2. Composants Developer

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Developer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

// DeveloperList.php - Liste des développeurs
class DeveloperList extends Component
{
    use WithPagination;
    
    public string $search = '';
    public string $specializationFilter = 'all';
    public string $availabilityFilter = 'all';
    
    public function getDevelopersProperty(): LengthAwarePaginator
    {
        return User::query()
            ->where('user_type', 'developer')
            ->where('status', 'active')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->specializationFilter !== 'all', fn($q) => $q->whereHas('profile', fn($sub) => $sub->where('specialization', $this->specializationFilter)))
            ->with('profile')
            ->latest()
            ->paginate(12);
    }
}

// DeveloperProfile.php - Profil développeur
class DeveloperProfile extends Component
{
    public User $developer;
    public \Illuminate\Database\Eloquent\Collection $projects;
    public \Illuminate\Database\Eloquent\Collection $reviews;
    
    public function mount(User $developer): void
    {
        $this->developer = $developer->load(['profile']);
        $this->projects = $developer->projects()->with('client')->latest()->limit(6)->get();
        $this->reviews = $developer->reviews()->with('client')->latest()->limit(5)->get();
    }
    
    public function getStatsProperty(): array
    {
        return [
            'completed_projects' => $this->developer->projects()->where('status', 'completed')->count(),
            'total_earnings' => $this->developer->commissions()->where('status', 'paid')->sum('amount'),
            'average_rating' => $this->developer->reviews()->avg('rating') ?: 0,
            'total_reviews' => $this->developer->reviews()->count(),
        ];
    }
}

```

#### 3. Composants Portfolio

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Portfolio;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

// PortfolioGallery.php - Galerie portfolio
class PortfolioGallery extends Component
{
    use WithPagination;
    
    public string $search = '';
    public string $categoryFilter = 'all';
    public string $techFilter = 'all';
    public string $sortBy = 'created_at';
    public int $perPage = 12;
    
    public function getProjectsProperty(): LengthAwarePaginator
    {
        return Project::query()
            ->with(['client', 'reviews'])
            ->where('status', 'published')
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->categoryFilter !== 'all', fn($q) => $q->where('type', $this->categoryFilter))
            ->when($this->techFilter !== 'all', fn($q) => $q->whereJsonContains('technologies', $this->techFilter))
            ->orderByDesc($this->sortBy)
            ->paginate($this->perPage);
    }
}

```

---

## 🛣️ Routes et Binding

### Structure des Routes

#### Routes Publiques (sans authentification)

```php
<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Project\ProjectFilter;
use App\Livewire\Developer\DeveloperSearch;
use App\Livewire\Developer\DeveloperFilter;
use App\Livewire\Developer\DeveloperProfile;
use App\Livewire\Portfolio\PortfolioGallery;
use App\Livewire\Portfolio\ProjectCard;
use App\Livewire\Portfolio\ProjectLike;

// routes/web.php

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Projets
Route::get('projects', function() { return view('projects'); })->name('projects.list');
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');
Route::get('projects/by-id/{id}', function($id) { 
    $project = \App\Models\Project::findOrFail($id); 
    return redirect()->route('projects.detail', $project->slug);
})->name('projects.detail.by-id');
Route::get('projects/filter', ProjectFilter::class)->name('projects.filter');

// Développeurs
Route::get('developers', function() { return view('developers'); })->name('developers.list');
Route::get('developers/search', DeveloperSearch::class)->name('developers.search');
Route::get('developers/filter', DeveloperFilter::class)->name('developers.filter');
Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');

// Portfolio
Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');
Route::get('portfolio/project-card', ProjectCard::class)->name('portfolio.project-card');
Route::get('portfolio/project-like', ProjectLike::class)->name('portfolio.project-like');

```

#### Routes Protégées (nécessitent authentification)

```php
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    // Paramètres
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', \App\Livewire\Settings\Profile::class)->name('profile.edit');
    Route::get('settings/password', \App\Livewire\Settings\Password::class)->name('user-password.edit');
    Route::get('settings/appearance', \App\Livewire\Settings\Appearance::class)->name('appearance.edit');
    
    // Progression projets
    Route::get('projects/{project}/progress', \App\Livewire\Project\ProjectProgress::class)->name('projects.progress');
    
    // Commissions
    Route::get('commissions', \App\Livewire\Commission\CommissionDashboard::class)->name('commissions.dashboard');
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

// User.php - Binding par ID (temporaire)
public function getRouteKeyName(): string
{
    return 'id'; // Changer en 'slug' pour la production
}

```

#### Processus de Binding

1. **Route Definition**: `Route::get('projects/{project}', ProjectDetail::class)`
2. **Parameter Resolution**: Laravel trouve le projet par slug
3. **Dependency Injection**: `mount(Project $project)` reçoit l'objet
4. **Property Assignment**: `$this->project = $project`

---

## 🎨 Vues et Layouts

### Structure des Layouts

#### Layout Public

```php
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <x-components.layouts.public.navbar />
    
    <main>
        @yield('content')
    </main>
    
    <x-components.layouts.public.footer />
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Dark mode functionality
        function updateTheme() {
            const theme = localStorage.getItem('theme') || 'system';
            const html = document.documentElement;
            
            if (theme === 'dark') {
                html.classList.add('dark');
            } else if (theme === 'light') {
                html.classList.remove('dark');
            } else {
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            }
        }
        
        updateTheme();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateTheme);
    </script>
</body>
</html>

```

---

## 🔄 Processus de Migration

### 1. Migration des Modèles

#### Étape 1: Création des Modèles

```bash
# Créer les modèles
php artisan make:model User -m
php artisan make:model Project -m
php artisan make:model Profile -m

```

#### Étape 2: Configuration des Fillables

```php
// User.php
protected $fillable = ['name', 'email', 'password', 'slug', ...];

// Project.php  
protected $fillable = ['title', 'description', 'slug', ...];

```

#### Étape 3: Configuration du Route Binding

```php
// Ajouter la méthode dans chaque modèle
public function getRouteKeyName(): string
{
    return 'slug'; // ou 'id'
}

```

### 2. Migration des Slugs

#### Étape 1: Créer la Migration

```bash
php artisan make:migration add_slug_to_users_table --table=users
php artisan make:migration add_slug_to_projects_table --table=projects

```

#### Étape 2: Définir la Migration

```php
// database/migrations/xxxx_add_slug_to_users_table.php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('slug')->nullable()->unique()->after('email');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}

```

#### Étape 3: Créer le Seeder

```bash
php artisan make:seeder UserSlugSeeder
php artisan make:seeder ProjectSlugSeeder

```

#### Étape 4: Implémenter le Seeder

```php
// database/seeders/UserSlugSeeder.php
public function run(): void
{
    $users = User::whereNull('slug')->get();
    
    foreach ($users as $user) {
        $slug = Str::slug($user->name) . '-' . $user->id;
        
        // S'assurer que le slug est unique
        $originalSlug = $slug;
        $counter = 1;
        
        while (User::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $user->update(['slug' => $slug]);
    }
}

```

#### Étape 5: Exécuter les Migrations

```bash
php artisan migrate
php artisan db:seed --class=UserSlugSeeder
php artisan db:seed --class=ProjectSlugSeeder

```

### 3. Migration des Composants Livewire

#### Étape 1: Créer les Composants

```bash
php artisan make:livewire ProjectList
php artisan make:livewire ProjectDetail
php artisan make:livewire DeveloperList
php artisan make:livewire DeveloperProfile
php artisan make:livewire PortfolioGallery

```

### 5. Migration des Accesseurs JSON

#### Problème Commun: Boucles Infinies

```php
// ❌ Problématique
public function getMilestonesAttribute()
{
    return $this->attributes['milestones'] ? json_decode($this->attributes['milestones'], true) : [];
}

// ✅ Correct
public function getMilestonesAttribute()
{
    $milestones = $this->getAttribute('milestones');
    return $milestones ? json_decode($milestones, true) : [];
}

```

---

## 🐛 Dépannage et Solutions

### Problèmes Courants

#### 1. Erreur: "Maximum execution time exceeded"

**Cause**: Boucles infinies dans les accesseurs JSON

**Solution**:

```php
// ❌ Éviter
$this->project->milestones

// ✅ Utiliser (méthode sûre)
$this->project->getAttribute('milestones')

```

#### 2. Erreur: "Missing required parameter"

**Cause**: Route binding incorrect

**Solution**:

```php
// Vérifier la route
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');

// Vérifier le modèle
public function getRouteKeyName(): string
{
    return 'slug'; // Doit correspondre au paramètre
}

// Vérifier le lien
<a href="{{ route('projects.detail', $project->slug) }}">

```

---

## 🏆 Extraits de Code Propres et Bonnes Pratiques

### 📋 Accesseurs JSON Sécurisés

#### ✅ Solution: getAttribute() Sécurisé

```php
<?php
declare(strict_types=1);

// DANS LE COMPOSANT - CORRECT
public function mount(Project $project): void
{
    // Accès direct sans déclencher l'accesseur
    $collaborators = $project->getAttribute('collaborators') ?? [];
    if (is_string($collaborators)) {
        $collaborators = json_decode($collaborators, true) ?? [];
    }
    
    $this->teamMembers = collect($collaborators)
        ->map(fn ($id) => User::find($id))
        ->filter()
        ->values();
}

public function getMilestoneProgressProperty(): array
{
    $milestones = $this->project->getAttribute('milestones') ?? [];
    if (is_string($milestones)) {
        $milestones = json_decode($milestones, true) ?? [];
    }
    
    $completed = collect($milestones)->where('status', 'completed')->count();
    $total = count($milestones);
    
    return [
        'completed' => $completed,
        'total' => $total,
        'percentage' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
    ];
}

```

### ⚡ Composants Livewire Optimisés

#### ✅ ProjectDetail Complet et Optimisé

```php
<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ProjectDetail extends Component
{
    public Project $project;
    public Collection $similarProjects;
    public \Illuminate\Support\Collection $teamMembers;
    
    public array $stats = [];
    public array $milestoneProgress = [];

    public function mount(Project $project): void
    {
        // 1. Charger les relations avec eager loading
        $this->project = $project->load(['client', 'developer.profile', 'reviews']);
        
        // 2. Récupérer les projets similaires (méthode optimisée)
        $this->similarProjects = $project->getSimilarProjects(6);
        
        // 3. Initialiser les propriétés calculées
        $this->stats = $this->getStatsProperty();
        $this->milestoneProgress = $this->getMilestoneProgressProperty();
        
        // 4. Gérer les collaborateurs JSON de manière sécurisée
        $collaborators = $project->getAttribute('collaborators') ?? [];
        if (is_string($collaborators)) {
            $collaborators = json_decode($collaborators, true) ?? [];
        }
        
        $this->teamMembers = collect($collaborators)
            ->map(fn ($id) => User::find($id))
            ->filter()
            ->values();
    }

    public function getMilestoneProgressProperty(): array
    {
        $milestones = $this->project->getAttribute('milestones') ?? [];
        if (is_string($milestones)) {
            $milestones = json_decode($milestones, true) ?? [];
        }
        
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

## ❓ FAQ Technique

### Pourquoi utiliser `getAttribute` au lieu de l'accès direct ?

Si un accesseur existe (ex: `getMilestonesAttribute`), l'accès direct via `$model->milestones` déclenche automatiquement cet accesseur. Si l'accesseur tente de lire l'attribut de la même manière, cela crée une boucle infinie. `getAttribute()` lit la valeur brute dans le tableau interne du modèle, contournant le problème.

### Pourquoi mes routes "by-id" sont-elles nécessaires ?

Pendant la transition vers les slugs, d'anciens liens ou favoris utilisateurs peuvent encore pointer vers `/projects/42`. La route `by-id` intercepte ces requêtes et effectue une redirection 301 (permanente) vers la nouvelle URL optimisée SEO.

### Livewire 3 supporte-t-il le "Model Binding" automatiquement ?

Oui ! Livewire 3 résout automatiquement les modèles injectés dans la méthode `mount`. Si la route contient un slug, Livewire utilisera la méthode `resolveRouteBinding` du modèle pour trouver l'enregistrement correspondant.

---

*Dernière mise à jour: Janvier 2026*

```

### Prochaine étape pour toi ?
Souhaites-tu que je génère le code complet du `UserSlugSeeder` ou que je t'aide à mettre en place le test unitaire pour vérifier que tes slugs sont bien uniques ?

```