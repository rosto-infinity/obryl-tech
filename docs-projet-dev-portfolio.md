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

namespace App\Models;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'phone', 
        'avatar', 'user_type', 'status', 'slug'
    ];

    // Relations
    public function profile(): HasOne
    public function projects(): HasMany
    public function reviews(): HasMany
    public function commissions(): HasMany

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

namespace App\Models;

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
    public function developer(): BelongsTo
    public function reviews(): HasMany

    // Route binding par slug
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
```

### Modèle Profile
```php
<?php

namespace App\Models;

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
            ->latest()
            ->paginate(12);
    }
}

// ProjectDetail.php - Détail d'un projet
class ProjectDetail extends Component
{
    public Project $project;
    public Collection $similarProjects;
    public Collection $teamMembers;
    
    public function mount(Project $project): void
    {
        $this->project = $project->load(['client', 'developer.profile', 'reviews']);
        $this->similarProjects = $project->getSimilarProjects(6);
        $this->teamMembers = $this->getTeamMembers();
    }
    
    private function getTeamMembers(): Collection
    {
        $collaborators = $this->project->getAttribute('collaborators') ?? [];
        if (is_string($collaborators)) {
            $collaborators = json_decode($collaborators, true) ?? [];
        }
        
        return collect($collaborators)
            ->map(fn ($id) => User::find($id))
            ->filter()
            ->values();
    }
}
```

#### 2. Composants Developer
```php
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
    public Collection $projects;
    public Collection $reviews;
    
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
// routes/web.php

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Projets
Route::get('projects', function() { return view('projects'); })->name('projects.list');
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');
Route::get('projects/by-id/{id}', function($id) { 
    $project = App\Models\Project::findOrFail($id); 
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
    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
    
    // Progression projets
    Route::get('projects/{project}/progress', ProjectProgress::class)->name('projects.progress');
    
    // Commissions
    Route::get('commissions', CommissionDashboard::class)->name('commissions.dashboard');
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
<!-- resources/views/components/layouts/public.blade.php -->
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <!-- Navbar Publique -->
    <x-components.layouts.public.navbar />
    
    <!-- Contenu Principal -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <x-components.layouts.public.footer />
    
    <!-- Scripts -->
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

#### Layout App (authentifié)
```php
<!-- resources/views/components/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="flex h-full">
        <!-- Sidebar -->
        <x-components.layouts.app.sidebar />
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <x-components.layouts.app.header />
            
            <!-- Content -->
            <main class="flex-1 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
```

### Vues des Composants

#### Vue Project List
```php
<!-- resources/views/projects.blade.php -->
@extends('components.layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @livewire('project.project-list')
</div>
@endsection
```

#### Vue Developer List
```php
<!-- resources/views/developers.blade.php -->
@extends('components.layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @livewire('developer.developer-list')
</div>
@endsection
```

#### Vue Portfolio
```php
<!-- resources/views/portfolio.blade.php -->
@extends('components.layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @livewire('portfolio.portfolio-gallery')
</div>
@endsection
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

#### Étape 2: Implémenter la Logique
```php
// Exemple: ProjectDetail.php
class ProjectDetail extends Component
{
    public Project $project;
    
    public function mount(Project $project): void
    {
        $this->project = $project->load(['client', 'developer.profile']);
    }
    
    public function render(): View
    {
        return view('livewire.project.project-detail');
    }
}
```

#### Étape 3: Créer les Vues
```php
<!-- resources/views/livewire/project/project-detail.blade.php -->
<div>
    <h1>{{ $project->title }}</h1>
    <p>{{ $project->description }}</p>
    <!-- Autres détails -->
</div>
```

### 4. Migration des Routes

#### Étape 1: Configurer les Routes
```php
// routes/web.php
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');
Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');
```

#### Étape 2: Mettre à Jour les Liens
```php
<!-- Ancien -->
<a href="{{ route('projects.detail', $project->id) }}">

<!-- Nouveau -->
<a href="{{ route('projects.detail', $project->slug) }}">
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

#### Solution: Utiliser getAttribute()
```php
// Dans les composants Livewire
$collaborators = $project->getAttribute('collaborators') ?? [];
if (is_string($collaborators)) {
    $collaborators = json_decode($collaborators, true) ?? [];
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

// ✅ Utiliser
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

#### 3. Erreur: "Typed property must not be accessed before initialization"
**Cause**: Propriété non initialisée dans le composant

**Solution**:
```php
// ❌ Incorrect
class ProjectDetail extends Component
{
    public Project $project; // Non initialisée
}

// ✅ Correct
class ProjectDetail extends Component
{
    public Project $project;
    
    public function mount(Project $project): void
    {
        $this->project = $project; // Initialisation
    }
}
```

#### 4. Erreur: "Undefined array key"
**Cause**: Accès direct aux attributs JSON

**Solution**:
```php
// ❌ Problématique
public function getMilestonesAttribute()
{
    return $this->attributes['milestones'] ? json_decode($this->attributes['milestones'], true) : [];
}

// ✅ Sécurisé
public function getMilestonesAttribute()
{
    $milestones = $this->getAttribute('milestones');
    return $milestones ? json_decode($milestones, true) : [];
}
```

### Outils de Débogage

#### 1. Vérifier les Slugs
```bash
# Vérifier les slugs manquants
php artisan tinker --execute="echo 'Projects without slug: ' . App\Models\Project::whereNull('slug')->count();"

# Vérifier un slug spécifique
php artisan tinker --execute="echo App\Models\Project::find(46)->slug;"
```

#### 2. Tester les Routes
```bash
# Lister les routes
php artisan route:list --name=projects

# Tester une route spécifique
php artisan route:list | grep projects.detail
```

#### 3. Vérifier les Relations
```bash
# Tester les relations
php artisan tinker --execute="$project = App\Models\Project::find(46); echo 'Client: ' . $project->client->name;"
```

### Bonnes Pratiques

#### 1. Validation des Données
```php
// Dans les composants
public function mount(Project $project): void
{
    if (!$project) {
        abort(404);
    }
    
    $this->project = $project->load(['client', 'developer.profile']);
}
```

#### 2. Gestion des Erreurs
```php
// Try-catch pour les opérations JSON
try {
    $milestones = json_decode($this->project->getAttribute('milestones'), true) ?? [];
} catch (\Exception $e) {
    $milestones = [];
}
```

#### 3. Optimisation des Requêtes
```php
// Eager loading
$this->project = $project->load(['client', 'developer.profile', 'reviews']);

// Pagination
$projects = Project::with(['client', 'developer'])
    ->where('status', 'published')
    ->paginate(12);
```

#### 4. Sécurité
```php
// Vérifier les permissions
public function mount(Project $project): void
{
    if ($project->status !== 'published' && !auth()->check()) {
        abort(403);
    }
}
```

---

## 📝 Checklist de Déploiement

### Avant la Mise en Production

- [ ] Tous les slugs sont générés
- [ ] Les routes utilisent le binding correct
- [ ] Les liens sont mis à jour
- [ ] Les accesseurs JSON sont sécurisés
- [ ] Les composants sont testés
- [ ] Les permissions sont configurées

### Après la Migration

- [ ] Vider le cache: `php artisan cache:clear`
- [ ] Optimiser: `php artisan optimize`
- [ ] Tester toutes les pages
- [ ] Vérifier les URLs SEO

---

## 🔗 Ressources Utiles

### Documentation Laravel
- [Laravel Livewire](https://laravel-livewire.com/)
- [Laravel Routing](https://laravel.com/docs/routing)
- [Eloquent Models](https://laravel.com/docs/eloquent)

### Commandes Utiles
```bash
# Créer un composant
php artisan make:livewire ComponentName

# Créer une migration
php artisan make:migration create_table_name

# Exécuter les seeders
php artisan db:seed --class=SeederName

# Vider les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🏆 Extraits de Code Propres et Bonnes Pratiques

### 📋 Accesseurs JSON Sécurisés

#### ❌ Problème: Boucles Infinies
```php
// DANS LE MODÈLE - ÉVITER
public function getMilestonesAttribute()
{
    return $this->attributes['milestones'] ? json_decode($this->attributes['milestones'], true) : [];
}

// DANS LE COMPOSANT - ÉVITER
$milestones = $this->project->milestones; // Déclenche l'accesseur
```

#### ✅ Solution: getAttribute() Sécurisé
```php
// DANS LE MODÈLE - CORRECT
public function getMilestonesAttribute()
{
    $milestones = $this->getAttribute('milestones');
    return $milestones ? json_decode($milestones, true) : [];
}

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

### 🗄️ Gestion des Slugs et Migration

#### ✅ Processus Complet de Migration des Slugs
```php
// 1. CRÉER LA MIGRATION
// database/migrations/2026_01_04_073505_add_slug_to_users_table.php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('slug')->nullable()->unique()->after('email');
    });
}

// 2. CRÉER LE SEEDER
// database/seeders/UserSlugSeeder.php
class UserSlugSeeder extends Seeder
{
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
}

// 3. CONFIGURER LE MODÈLE
// app/Models/User.php
protected $fillable = [
    'name', 'email', 'password', 'phone', 
    'avatar', 'user_type', 'status', 'slug', // ← Ajouté
];

public function getRouteKeyName(): string
{
    return 'id'; // Temporairement, puis 'slug'
}

// 4. EXÉCUTER LA MIGRATION
php artisan migrate
php artisan db:seed --class=UserSlugSeeder
```

### 🛣️ Routes et Binding Optimisé

#### ✅ Configuration Complète des Routes
```php
// routes/web.php

// IMPORTS NÉCESSAIRES
use App\Models\User;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Developer\DeveloperProfile;

// ROUTES PUBLIQUES
Route::get('projects', function() { return view('projects'); })->name('projects.list');
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');

// ROUTE DE REDIRECTION TEMPORAIRE (pour compatibilité)
Route::get('projects/by-id/{id}', function($id) { 
    $project = App\Models\Project::findOrFail($id); 
    return redirect()->route('projects.detail', $project->slug);
})->name('projects.detail.by-id');

// DÉVELOPPEURS
Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');

// PORTFOLIO
Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');
```

#### ✅ Configuration du Binding
```php
// app/Models/Project.php - Binding par slug
public function getRouteKeyName(): string
{
    return 'slug';
}

// app/Models/User.php - Binding par ID (temporaire)
public function getRouteKeyName(): string
{
    return 'id';
}
```

### 🔗 Liens Cohérents dans les Vues

#### ✅ Standardisation des Liens
```php
<!-- TOUS LES LIENS VERS LES PROJETS -->
<!-- portfolio-gallery.blade.php -->
<a href="{{ route('projects.detail', $project->slug) }}" 
   class="block w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200 text-center">
    Voir le projet
</a>

<!-- project-list.blade.php -->
<a href="{{ route('projects.detail', $project->slug) }}" 
   class="flex-1 bg-primary text-white text-center px-4 py-2 rounded-md hover:bg-primary/80 transition-colors duration-200">
    Voir le projet
</a>

<!-- project-progress.blade.php -->
<a href="{{ route('projects.detail', $project->slug) }}" 
   class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
    {{ $project->title }}
</a>

<!-- project-detail.blade.php -->
<a href="{{ route('projects.progress', $project->slug) }}" 
   class="block w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition-colors duration-200 text-center">
    Suivre la progression
</a>

<!-- TOUS LES LIENS VERS LES DÉVELOPPEURS -->
<!-- developer-list.blade.php -->
<a href="{{ route('developers.profile', $developer->id) }}" 
   class="flex-1 bg-primary text-white text-center px-4 py-2 rounded-md hover:bg-primary/70 transition-colors duration-200">
    Voir le profil
</a>
```

### 🎨 Dark Mode Implementation

#### ✅ Dark Mode Natif (sans Flux UI)
```php
<!-- resources/views/components/layouts/public/navbar.blade.php -->
<!-- Dark Mode Toggle Desktop -->
<div x-data="{ theme: localStorage.getItem('theme') || 'system' }" class="ml-4">
    <div class="flex rounded-lg bg-zinc-800/5 dark:bg-white/10 p-1">
        <button @click="theme = 'light'; localStorage.setItem('theme', 'light'); updateTheme()" 
                :class="theme === 'light' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                class="p-2 rounded-md transition-colors duration-200">
            <!-- SVG Light -->
        </button>
        <button @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); updateTheme()" 
                :class="theme === 'dark' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                class="p-2 rounded-md transition-colors duration-200">
            <!-- SVG Dark -->
        </button>
        <button @click="theme = 'system'; localStorage.setItem('theme', 'system'); updateTheme()" 
                :class="theme === 'system' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                class="p-2 rounded-md transition-colors duration-200">
            <!-- SVG System -->
        </button>
    </div>
</div>
```

```javascript
// resources/views/welcome.blade.php - JavaScript natif
<script>
function updateTheme() {
    const theme = localStorage.getItem('theme') || 'system';
    const html = document.documentElement;
    
    if (theme === 'dark') {
        html.classList.add('dark');
    } else if (theme === 'light') {
        html.classList.remove('dark');
    } else {
        // System preference
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }
    }
}

// Initialize theme on page load
updateTheme();

// Listen for system theme changes
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateTheme);
</script>
```

### ⚡ Composants Livewire Optimisés

#### ✅ ProjectDetail Complet et Optimisé
```php
<?php

namespace App\Livewire\Project;

class ProjectDetail extends Component
{
    public Project $project;
    public Collection $similarProjects;
    public Collection $teamMembers;
    
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

#### ✅ getSimilarProjects Optimisé
```php
// app/Models/Project.php
public function getSimilarProjects(int $limit = 6): Collection
{
    $technologies = $this->getAttribute('technologies') ?? [];
    if (is_string($technologies)) {
        $technologies = json_decode($technologies, true) ?? [];
    }
    
    $firstTech = is_array($technologies) && !empty($technologies) ? $technologies[0] : null;
    
    $query = Project::query()
        ->where('id', '!=', $this->id)
        ->where('status', 'published');
        
    if ($this->type && $firstTech) {
        $query->where(function ($q) use ($firstTech) {
            $q->where('type', $this->type)
              ->orWhereJsonContains('technologies', $firstTech);
        });
    } elseif ($this->type) {
        $query->where('type', $this->type);
    }
    
    return $query
        ->with(['client', 'developer.profile'])
        ->inRandomOrder()
        ->limit($limit)
        ->get();
}
```

### 🔧 Outils de Débogage et Commandes

#### ✅ Commandes Utiles
```bash
# VÉRIFIER LES SLUGS
php artisan tinker --execute="echo 'Projects without slug: ' . App\Models\Project::whereNull('slug')->count();"
php artisan tinker --execute="echo 'Project 46 slug: ' . App\Models\Project::find(46)->slug;"

# VÉRIFIER LES ROUTES
php artisan route:list --name=projects
php artisan route:list | grep projects.detail

# TESTER LES RELATIONS
php artisan tinker --execute="$project = App\Models\Project::find(46); echo 'Client: ' . $project->client->name;"

# GÉNÉRER LES SLUGS
php artisan db:seed --class=UserSlugSeeder
php artisan db:seed --class=ProjectSlugSeeder

# VIDER LES CACHES
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 📊 Bonnes Pratiques de Performance

#### ✅ Optimisation des Requêtes
```php
// TOUJOURS UTILISER EAGER LOADING
$this->project = $project->load(['client', 'developer.profile', 'reviews']);

// PAGINATION AU LIEU DE ALL()
$projects = Project::with(['client', 'developer'])
    ->where('status', 'published')
    ->paginate(12);

// ÉVITER N+1 PROBLÈMES
$developers = User::with('profile')
    ->where('user_type', 'developer')
    ->paginate(12);
```

#### ✅ Validation et Sécurité
```php
// VALIDER LES DONNÉES
public function mount(Project $project): void
{
    if (!$project || $project->status !== 'published') {
        abort(404);
    }
    
    $this->project = $project;
}

// GESTION DES ERREURS JSON
try {
    $milestones = json_decode($this->project->getAttribute('milestones'), true) ?? [];
} catch (\Exception $e) {
    $milestones = [];
}
```

---

## 📞 Support

Pour toute question ou problème, consulter:
1. Les logs Laravel: `storage/logs/laravel.log`
2. La documentation ci-dessus
3. Les outils de débogage intégrés

---

*Dernière mise à jour: Janvier 2026*
