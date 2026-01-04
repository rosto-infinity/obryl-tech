# Documentation Projet - Portfolio Développeurs
## Version Annotée avec Explications Détaillées

---

## 📋 Table des Matières

1. [Architecture Générale](#architecture-générale)
2. [Modèles de Données](#modèles-de-données)
3. [Composants Livewire](#composants-livewire)
4. [Routes et Binding](#routes-et-binding)
5. [Vues et Layouts](#vues-et-layouts)
6. [Processus de Migration](#processus-de-migration)
7. [Dépannage et Solutions](#dépannage-et-solutions)
8. [Guide d'Explications Détaillées](#guide-explications-détaillées)

---

## 🗃️ Architecture Générale

### Stack Technique

```plaintext
PHP: 8.4.16
Laravel: 12.44.0
Livewire: 3.x
Frontend: Blade + Alpine.js + TailwindCSS
Base de données: MySQL
```

**💡 Explications:**

- **PHP 8.4.16**: Version récente avec typage fort, énumérations natives, et performances optimisées
- **Laravel 12**: Framework moderne avec Livewire 3 intégré, supportant les composants réactifs
- **Livewire 3.x**: Permet de créer des interfaces réactives sans écrire de JavaScript complexe
- **Alpine.js**: Framework JavaScript léger (15KB) pour les interactions client-side
- **TailwindCSS**: Framework CSS utility-first pour un styling rapide et cohérent
- **MySQL**: Base de données relationnelle robuste et performante

---

## 📊 Modèles de Données

### Modèle User - Explications Détaillées

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant un utilisateur du système
 * Peut être un client ou un développeur selon user_type
 */
class User extends Authenticatable
{
    /**
     * Attributs assignables en masse
     * 
     * @var array<string>
     * 
     * EXPLICATION:
     * - $fillable protège contre les assignations en masse non autorisées
     * - Seuls ces champs peuvent être remplis via User::create() ou $user->fill()
     * - 'name': Nom complet de l'utilisateur
     * - 'email': Adresse email unique
     * - 'password': Mot de passe hashé (jamais en clair)
     * - 'phone': Numéro de téléphone optionnel
     * - 'avatar': URL ou chemin vers la photo de profil
     * - 'user_type': 'client' ou 'developer' (enum)
     * - 'status': 'active', 'inactive', 'suspended' (enum)
     * - 'slug': Identifiant unique SEO-friendly pour les URLs
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'user_type',
        'status',
        'slug'
    ];

    /**
     * Attributs cachés dans les réponses JSON
     * 
     * @var array<string>
     * 
     * EXPLICATION:
     * - Ces attributs ne seront jamais inclus dans les réponses API
     * - Sécurise les données sensibles comme le mot de passe
     * - 'remember_token': Token de session "se souvenir de moi"
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relations Eloquent
     */

    /**
     * Relation One-to-One: Un utilisateur a un profil
     * 
     * @return HasOne
     * 
     * EXPLICATION:
     * - HasOne signifie qu'un User possède exactement un Profile
     * - La clé étrangère 'user_id' est dans la table 'profiles'
     * - Permet d'accéder au profil via $user->profile
     * - Séparation des données: User = authentification, Profile = métadonnées
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Relation One-to-Many: Un utilisateur a plusieurs projets
     * 
     * @return HasMany
     * 
     * EXPLICATION:
     * - HasMany signifie qu'un User peut avoir plusieurs Projects
     * - Pour un développeur: projets qu'il développe (developer_id)
     * - Pour un client: projets qu'il commande (client_id)
     * - Permet d'accéder aux projets via $user->projects
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'developer_id');
    }

    /**
     * Relation One-to-Many: Un utilisateur a plusieurs avis
     * 
     * @return HasMany
     * 
     * EXPLICATION:
     * - Un client peut laisser plusieurs avis sur différents projets
     * - Un développeur peut recevoir plusieurs avis de différents clients
     * - Utile pour calculer la note moyenne d'un développeur
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relation One-to-Many: Un utilisateur a plusieurs commissions
     * 
     * @return HasMany
     * 
     * EXPLICATION:
     * - Commission = paiement/rémunération pour un projet
     * - Un développeur reçoit des commissions pour ses projets complétés
     * - Permet de calculer les gains totaux d'un développeur
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    /**
     * Route Model Binding: Définit la clé pour résoudre le modèle dans les routes
     * 
     * @return string
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * Route Model Binding permet à Laravel de résoudre automatiquement
     * les modèles dans les paramètres de route.
     * 
     * COMMENT ÇA FONCTIONNE:
     * 
     * 1. AVEC 'id' (actuel):
     *    Route: /developers/{developer}
     *    URL: /developers/123
     *    Laravel exécute: User::where('id', 123)->firstOrFail()
     * 
     * 2. AVEC 'slug' (production):
     *    Route: /developers/{developer}
     *    URL: /developers/jean-dupont-123
     *    Laravel exécute: User::where('slug', 'jean-dupont-123')->firstOrFail()
     * 
     * AVANTAGES DU SLUG:
     * - URLs plus lisibles: /developers/jean-dupont au lieu de /developers/123
     * - Meilleur SEO: Google comprend mieux le contenu de la page
     * - Pas d'exposition des IDs internes
     * 
     * TRANSITION PROGRESSIVE:
     * - Actuellement en 'id' pour assurer la compatibilité
     * - Passer à 'slug' une fois tous les slugs générés
     * - Route de redirection temporaire pour maintenir les anciens liens
     */
    public function getRouteKeyName(): string
    {
        return 'id'; // TODO: Changer en 'slug' après génération complète
    }
}
```

---

### Modèle Project - Explications Détaillées

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Modèle représentant un projet de développement
 */
class Project extends Model
{
    /**
     * Attributs assignables en masse
     * 
     * @var array<string>
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * - 'title': Titre du projet (string, max 255 caractères)
     * - 'description': Description détaillée (text, illimité)
     * - 'slug': Identifiant URL unique (ex: 'site-e-commerce-php')
     * - 'client_id': ID du client qui commande le projet (foreign key)
     * - 'developer_id': ID du développeur assigné (foreign key, nullable)
     * - 'type': Type de projet (enum: 'web', 'mobile', 'desktop', etc.)
     * - 'status': État du projet (enum: 'draft', 'published', 'in_progress', etc.)
     * - 'priority': Niveau de priorité (enum: 'low', 'medium', 'high', 'urgent')
     * - 'budget': Budget alloué en devise (decimal)
     * - 'technologies': Liste des technologies (JSON array)
     * - 'milestones': Jalons du projet (JSON array d'objets)
     * - 'tasks': Tâches à accomplir (JSON array d'objets)
     */
    protected $fillable = [
        'title',
        'description',
        'slug',
        'client_id',
        'developer_id',
        'type',
        'status',
        'priority',
        'budget',
        'technologies',
        'milestones',
        'tasks'
    ];

    /**
     * Conversion automatique des types d'attributs
     * 
     * @var array<string, string>
     * 
     * EXPLICATION DÉTAILLÉE DU CASTING:
     * 
     * Laravel convertit automatiquement les attributs selon ces règles:
     * 
     * 'technologies' => 'json':
     * - STOCKAGE DB: '["PHP", "Laravel", "Vue.js"]' (string JSON)
     * - LECTURE PHP: ['PHP', 'Laravel', 'Vue.js'] (array PHP)
     * - ÉCRITURE PHP: ['React', 'Node.js'] → '["React", "Node.js"]' (auto)
     * 
     * 'milestones' => 'json':
     * - EXEMPLE STRUCTURE:
     *   [
     *     {
     *       "id": 1,
     *       "title": "Conception",
     *       "status": "completed",
     *       "due_date": "2026-01-15"
     *     },
     *     {
     *       "id": 2,
     *       "title": "Développement",
     *       "status": "in_progress",
     *       "due_date": "2026-02-28"
     *     }
     *   ]
     * - Laravel gère la sérialisation/désérialisation automatiquement
     * 
     * 'tasks' => 'json':
     * - EXEMPLE STRUCTURE:
     *   [
     *     {
     *       "id": 1,
     *       "title": "Créer la base de données",
     *       "status": "done",
     *       "assigned_to": 5
     *     }
     *   ]
     * 
     * 'collaborators' => 'json':
     * - EXEMPLE: [5, 12, 23] (IDs des utilisateurs collaborateurs)
     * - Permet de récupérer facilement l'équipe du projet
     * 
     * AVANTAGES DU CASTING:
     * - Pas besoin de json_encode/json_decode manuel
     * - Type-safe: toujours un array, jamais une string
     * - Erreurs évitées lors de l'accès aux données
     */
    protected $casts = [
        'technologies' => 'json',
        'milestones' => 'json',
        'tasks' => 'json',
        'collaborators' => 'json',
    ];

    /**
     * Relations Eloquent
     */

    /**
     * Relation Many-to-One: Un projet appartient à un client
     * 
     * @return BelongsTo
     * 
     * EXPLICATION:
     * - BelongsTo signifie que Project possède une clé étrangère 'client_id'
     * - Cette clé référence un User avec user_type = 'client'
     * - Permet d'accéder au client via $project->client
     * - Retourne un objet User ou null si aucun client assigné
     * 
     * EXEMPLE D'UTILISATION:
     * $project = Project::find(1);
     * $clientName = $project->client->name; // "Jean Dupont"
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relation Many-to-One: Un projet appartient à un développeur
     * 
     * @return BelongsTo
     * 
     * EXPLICATION:
     * - Similaire à la relation client mais pour le développeur
     * - La clé étrangère est 'developer_id'
     * - Peut être null si le projet n'est pas encore assigné
     * - Référence un User avec user_type = 'developer'
     * 
     * EXEMPLE D'UTILISATION:
     * $project = Project::find(1);
     * if ($project->developer) {
     *     $devName = $project->developer->name;
     *     $devSkills = $project->developer->profile->skills;
     * }
     */
    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    /**
     * Relation One-to-Many: Un projet a plusieurs avis
     * 
     * @return HasMany
     * 
     * EXPLICATION:
     * - Un projet peut recevoir plusieurs reviews de différents clients
     * - Utile pour calculer la note moyenne du projet
     * - Permet d'afficher les témoignages clients
     * 
     * EXEMPLE D'UTILISATION:
     * $project = Project::find(1);
     * $averageRating = $project->reviews()->avg('rating');
     * $reviewCount = $project->reviews()->count();
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Route Model Binding par slug
     * 
     * @return string
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * Pour les projets, on utilise TOUJOURS le slug car:
     * 1. Les URLs de projets sont partagées publiquement
     * 2. Le SEO est crucial pour la visibilité
     * 3. Les slugs sont descriptifs du contenu
     * 
     * FONCTIONNEMENT:
     * - Route: /projects/{project}
     * - URL: /projects/site-ecommerce-laravel
     * - Laravel exécute: Project::where('slug', 'site-ecommerce-laravel')->firstOrFail()
     * - Si non trouvé: Erreur 404 automatique
     * 
     * AVANTAGES:
     * - URL descriptive: /projects/site-ecommerce-laravel
     * - SEO optimisé: Google indexe mieux
     * - Partage social: aperçu plus clair du contenu
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Méthode personnalisée: Récupérer les projets similaires
     * 
     * @param int $limit Nombre de projets à retourner
     * @return Collection
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * Cette méthode trouve des projets similaires basés sur:
     * 1. Le même type de projet (web, mobile, etc.)
     * 2. Les technologies communes
     * 3. Ordre aléatoire pour varier les suggestions
     * 
     * ALGORITHME:
     * 1. Récupérer les technologies du projet actuel
     * 2. Chercher d'autres projets avec:
     *    - Même type OU première technologie en commun
     *    - Status = 'published' (visible publiquement)
     *    - ID différent du projet actuel
     * 3. Charger les relations nécessaires (client, developer, profile)
     * 4. Ordre aléatoire pour chaque chargement
     * 5. Limiter aux N premiers résultats
     */
    public function getSimilarProjects(int $limit = 6): Collection
    {
        // 1. Récupération sécurisée des technologies
        // getAttribute() évite les boucles infinies avec les accesseurs
        $technologies = $this->getAttribute('technologies') ?? [];
        
        // 2. Validation: s'assurer que c'est un array
        if (is_string($technologies)) {
            $technologies = json_decode($technologies, true) ?? [];
        }
        
        // 3. Extraire la première technologie (la plus importante généralement)
        $firstTech = is_array($technologies) && !empty($technologies) 
            ? $technologies[0] 
            : null;
        
        // 4. Construire la requête de base
        $query = Project::query()
            ->where('id', '!=', $this->id)          // Exclure le projet actuel
            ->where('status', 'published');          // Seulement les projets publiés
            
        // 5. Appliquer les filtres de similarité
        if ($this->type && $firstTech) {
            // Si on a le type ET une technologie, chercher l'un OU l'autre
            $query->where(function ($q) use ($firstTech) {
                $q->where('type', $this->type)
                  ->orWhereJsonContains('technologies', $firstTech);
            });
        } elseif ($this->type) {
            // Sinon, juste le même type
            $query->where('type', $this->type);
        }
        
        // 6. Charger les relations et retourner
        return $query
            ->with(['client', 'developer.profile'])  // Eager loading
            ->inRandomOrder()                         // Ordre aléatoire
            ->limit($limit)                          // Limiter les résultats
            ->get();
    }
}
```

---

### Modèle Profile - Explications Détaillées

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle représentant le profil détaillé d'un utilisateur
 * Séparé de User pour mieux organiser les données
 */
class Profile extends Model
{
    /**
     * Attributs assignables en masse
     * 
     * @var array<string>
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * - 'user_id': Clé étrangère vers la table users (relation 1:1)
     * - 'bio': Biographie/présentation de l'utilisateur (text)
     * - 'skills': Compétences techniques (JSON array)
     *   Exemple: ["PHP", "Laravel", "Vue.js", "MySQL"]
     * - 'experience': Années d'expérience ou description détaillée
     * - 'education': Formation académique (JSON array d'objets)
     *   Exemple: [{"degree": "Master", "school": "MIT", "year": 2020}]
     * - 'certifications': Certifications professionnelles (JSON array)
     *   Exemple: ["AWS Certified", "Laravel Certified"]
     * - 'availability': Disponibilité (enum: 'available', 'busy', 'unavailable')
     * - 'hourly_rate': Taux horaire en devise (decimal)
     * - 'portfolio_url': Lien vers le portfolio externe
     * - 'github_url': Profil GitHub
     * - 'linkedin_url': Profil LinkedIn
     * - 'is_verified': Badge de vérification (boolean)
     */
    protected $fillable = [
        'user_id',
        'bio',
        'skills',
        'experience',
        'education',
        'certifications',
        'availability',
        'hourly_rate',
        'portfolio_url',
        'github_url',
        'linkedin_url',
        'is_verified'
    ];

    /**
     * Conversion automatique des types
     * 
     * @var array<string, string>
     * 
     * EXPLICATION DU CASTING:
     * 
     * 'skills' => 'json':
     * - Stockage: '["PHP", "Laravel"]'
     * - Lecture: ['PHP', 'Laravel']
     * - Facilite l'affichage des badges de compétences
     * 
     * 'education' => 'json':
     * - Stockage: '[{"degree": "Master", "school": "MIT"}]'
     * - Lecture: [['degree' => 'Master', 'school' => 'MIT']]
     * - Permet de boucler sur les diplômes facilement
     * 
     * 'certifications' => 'json':
     * - Similaire à skills mais pour les certifications
     * - Séparé pour mieux organiser les données
     */
    protected $casts = [
        'skills' => 'json',
        'education' => 'json',
        'certifications' => 'json',
    ];

    /**
     * Relation Many-to-One: Un profil appartient à un utilisateur
     * 
     * @return BelongsTo
     * 
     * EXPLICATION:
     * - Chaque profil est lié à exactement un utilisateur
     * - Permet d'accéder à l'utilisateur via $profile->user
     * - Clé étrangère: 'user_id'
     * 
     * EXEMPLE D'UTILISATION:
     * $profile = Profile::find(1);
     * $userName = $profile->user->name;
     * $userEmail = $profile->user->email;
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

---

## ⚡ Composants Livewire - Explications Détaillées

### Architecture Générale des Composants

**CONCEPT LIVEWIRE:**

Livewire permet de créer des interfaces réactives côté serveur:
- Pas de JavaScript complexe à écrire
- Les interactions utilisateur déclenchent des requêtes AJAX automatiques
- Le serveur retourne uniquement les parties modifiées du DOM
- Alpine.js gère les interactions simples côté client

**STRUCTURE TYPE D'UN COMPOSANT:**
```
ProjectList/
├── ProjectList.php      → Logique (classe PHP)
└── project-list.blade.php → Vue (template Blade)
```

---

## 🎨 Dark Mode Natif - Guide Complet d'Implémentation

### Configuration Tailwind CSS

```javascript
// tailwind.config.js

/**
 * CONFIGURATION DARK MODE
 * 
 * darkMode: 'class'
 * - Active le mode basé sur une classe CSS
 * - Ajouter 'dark' à <html> active tous les styles dark:
 * - Exemple: bg-white dark:bg-gray-900
 * 
 * ALTERNATIVES:
 * - 'media': Basé uniquement sur préférence système
 * - false: Désactive complètement
 */
module.exports = {
  darkMode: 'class',
  
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#3b82f6',
          dark: '#2563eb',
        }
      }
    }
  }
}
```

### Structure HTML

```blade
{{-- resources/views/components/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="fr" class="h-full">
{{--
    IMPORTANTE: La classe 'dark' sera ajoutée dynamiquement
    par JavaScript selon les préférences utilisateur
--}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    {{--
        CLASSES DARK MODE:
        - bg-gray-50: Fond clair en mode normal
        - dark:bg-gray-900: Fond sombre en mode dark
        - text-gray-900: Texte foncé en mode normal
        - dark:text-gray-100: Texte clair en mode dark
    --}}
    
    <x-components.layouts.public.navbar />
    
    <main>
        @yield('content')
    </main>
    
    <x-components.layouts.public.footer />
    
    {{-- Script Dark Mode --}}
    <script>
        /**
         * FONCTION updateTheme()
         * 
         * OBJECTIF:
         * - Appliquer le thème selon les préférences utilisateur
         * - Gérer 3 modes: light, dark, system
         * 
         * ALGORITHME:
         * 1. Récupérer le thème depuis localStorage
         * 2. Si 'dark': ajouter classe 'dark' à <html>
         * 3. Si 'light': supprimer classe 'dark'
         * 4. Si 'system': détecter préférence OS
         */
        function updateTheme() {
            // Récupération du thème sauvegardé (défaut: 'system')
            const theme = localStorage.getItem('theme') || 'system';
            
            // Référence à la balise <html>
            const html = document.documentElement;
            
            if (theme === 'dark') {
                // Mode sombre forcé
                html.classList.add('dark');
            } else if (theme === 'light') {
                // Mode clair forcé
                html.classList.remove('dark');
            } else {
                // Mode système: détection automatique
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            }
        }
        
        // Initialiser le thème au chargement de la page
        updateTheme();
        
        /**
         * ÉCOUTER LES CHANGEMENTS SYSTÈME
         * 
         * EXPLICATION:
         * - window.matchMedia(): API pour détecter les media queries
         * - '(prefers-color-scheme: dark)': Préférence OS
         * - addEventListener('change'): Réagit aux changements
         * 
         * EXEMPLE:
         * - Utilisateur change son OS de clair à sombre
         * - Si thème = 'system', le site suit automatiquement
         */
        window.matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', updateTheme);
    </script>
</body>
</html>
```

### Composant Toggle Alpine.js

```blade
{{-- resources/views/components/layouts/public/navbar.blade.php --}}

<nav class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo et navigation --}}
            <div class="flex">
                {{-- ... menu items ... --}}
            </div>
            
            {{-- Dark Mode Toggle --}}
            <div x-data="{ theme: localStorage.getItem('theme') || 'system' }" 
                 class="ml-4">
                {{--
                    ALPINE.JS x-data:
                    - Initialise un composant Alpine.js
                    - theme: État réactif local
                    - Lit depuis localStorage au chargement
                --}}
                
                <div class="flex rounded-lg bg-zinc-800/5 dark:bg-white/10 p-1">
                    {{--
                        BOUTON LIGHT MODE
                        
                        @click:
                        - Événement Alpine.js
                        - Met à jour theme
                        - Sauvegarde dans localStorage
                        - Appelle updateTheme() global
                        
                        :class:
                        - Binding dynamique de classes
                        - Active si theme === 'light'
                        - Ajoute bg-white et shadow
                    --}}
                    <button 
                        @click="theme = 'light'; localStorage.setItem('theme', 'light'); updateTheme()" 
                        :class="theme === 'light' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                        class="p-2 rounded-md transition-colors duration-200"
                        aria-label="Mode clair">
                        {{-- Icône Soleil --}}
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                        </svg>
                    </button>
                    
                    {{-- BOUTON DARK MODE --}}
                    <button 
                        @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); updateTheme()" 
                        :class="theme === 'dark' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                        class="p-2 rounded-md transition-colors duration-200"
                        aria-label="Mode sombre">
                        {{-- Icône Lune --}}
                        <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                        </svg>
                    </button>
                    
                    {{-- BOUTON SYSTEM MODE --}}
                    <button 
                        @click="theme = 'system'; localStorage.setItem('theme', 'system'); updateTheme()" 
                        :class="theme === 'system' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                        class="p-2 rounded-md transition-colors duration-200"
                        aria-label="Mode système">
                        {{-- Icône Ordinateur --}}
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>
```

### Styles CSS Personnalisés

```css
/* resources/css/app.css */

/**
 * IMPORTS TAILWIND
 */
@tailwind base;
@tailwind components;
@tailwind utilities;

/**
 * TRANSITION SMOOTH DARK MODE
 * 
 * EXPLICATION:
 * - Applique une transition douce aux changements de couleur
 * - 200ms: Durée de la transition
 * - ease-in-out: Courbe d'animation fluide
 * 
 * EFFET:
 * - Passage smooth entre clair et sombre
 * - Évite le "flash" brutal
 */
@layer base {
  html {
    @apply transition-colors duration-200 ease-in-out;
  }
}

/**
 * PERSONNALISATION SCROLLBAR DARK MODE
 */
@layer utilities {
  /* Scrollbar en mode clair */
  ::-webkit-scrollbar {
    width: 12px;
  }
  
  ::-webkit-scrollbar-track {
    @apply bg-gray-100;
  }
  
  ::-webkit-scrollbar-thumb {
    @apply bg-gray-400 rounded-lg hover:bg-gray-500;
  }
  
  /* Scrollbar en mode sombre */
  .dark ::-webkit-scrollbar-track {
    @apply bg-gray-900;
  }
  
  .dark ::-webkit-scrollbar-thumb {
    @apply bg-gray-600 hover:bg-gray-500;
  }
}
```

---

## 📦 Gestion du Stockage - Explications Détaillées

### LocalStorage vs État Réactif

```javascript
/**
 * LOCALSTORAGE: GUIDE COMPLET
 * 
 * ========================================
 * QU'EST-CE QUE LOCALSTORAGE?
 * ========================================
 * 
 * - API du navigateur pour stocker des données
 * - Persistance entre les sessions
 * - Limite: ~5-10MB selon le navigateur
 * - Stockage key-value (clé-valeur)
 * - Synchrone (bloquant)
 */

/**
 * MÉTHODES PRINCIPALES
 */

// Sauvegarder une valeur
localStorage.setItem('theme', 'dark');
// Stocke: { theme: 'dark' }

// Récupérer une valeur
const theme = localStorage.getItem('theme');
// Retourne: 'dark' ou null si inexistant

// Supprimer une valeur
localStorage.removeItem('theme');

// Tout supprimer
localStorage.clear();

/**
 * STOCKAGE D'OBJETS COMPLEXES
 * 
 * PROBLÈME:
 * localStorage ne stocke que des strings
 * 
 * SOLUTION:
 * JSON.stringify() et JSON.parse()
 */

// Sauvegarder un objet
const user = { id: 1, name: 'Jean' };
localStorage.setItem('user', JSON.stringify(user));

// Récupérer l'objet
const storedUser = JSON.parse(localStorage.getItem('user'));
// storedUser = { id: 1, name: 'Jean' }

/**
 * ========================================
 * BONNES PRATIQUES
 * ========================================
 */

/**
 * 1. TOUJOURS VALIDER LES DONNÉES
 */
function getTheme() {
    const theme = localStorage.getItem('theme');
    
    // Validation: seulement 'light', 'dark', ou 'system'
    const validThemes = ['light', 'dark', 'system'];
    
    if (theme && validThemes.includes(theme)) {
        return theme;
    }
    
    // Valeur par défaut
    return 'system';
}

/**
 * 2. GÉRER LES ERREURS
 * 
 * POURQUOI:
 * - localStorage peut être désactivé
 * - Quota peut être dépassé
 * - Mode navigation privée peut bloquer
 */
function safeSetItem(key, value) {
    try {
        localStorage.setItem(key, value);
        return true;
    } catch (error) {
        console.error('Erreur localStorage:', error);
        
        if (error.name === 'QuotaExceededError') {
            // Quota dépassé: nettoyer les anciennes données
            localStorage.clear();
        }
        
        return false;
    }
}

/**
 * 3. ÉVITER LES DONNÉES SENSIBLES
 * 
 * ❌ NE JAMAIS STOCKER:
 * - Mots de passe
 * - Tokens d'authentification (sauf cas spécifiques)
 * - Informations personnelles sensibles
 * - Numéros de carte bancaire
 * 
 * POURQUOI:
 * - Accessible via JavaScript (XSS)
 * - Visible dans les DevTools
 * - Pas de chiffrement automatique
 * 
 * ✅ STOCKER:
 * - Préférences UI (thème, langue)
 * - États temporaires (filtres, pagination)
 * - Cache de données publiques
 */

/**
 * 4. NETTOYER LES DONNÉES OBSOLÈTES
 */
function cleanOldData() {
    const keys = Object.keys(localStorage);
    
    keys.forEach(key => {
        // Supprimer les données de plus de 30 jours
        const item = localStorage.getItem(key);
        try {
            const data = JSON.parse(item);
            if (data.timestamp) {
                const age = Date.now() - data.timestamp;
                const thirtyDays = 30 * 24 * 60 * 60 * 1000;
                
                if (age > thirtyDays) {
                    localStorage.removeItem(key);
                }
            }
        } catch (e) {
            // Pas un JSON valide, ignorer
        }
    });
}

/**
 * ========================================
 * ALTERNATIVE: SESSIONSTORAGE
 * ========================================
 * 
 * DIFFÉRENCES:
 * - localStorage: Persiste indéfiniment
 * - sessionStorage: Effacé à la fermeture du navigateur
 * 
 * UTILISATION:
 * Identique à localStorage mais avec sessionStorage
 */

// Sauvegarder
sessionStorage.setItem('tempData', 'value');

// Récupérer
const tempData = sessionStorage.getItem('tempData');

/**
 * ========================================
 * INTÉGRATION AVEC LIVEWIRE
 * ========================================
 */

// Dans un composant Livewire
class ProjectList extends Component
{
    public string $search = '';
    
    /**
     * Sauvegarder la recherche dans localStorage
     * pour la restaurer au prochain chargement
     */
    public function updatedSearch($value)
    {
        // Déclencher un événement JavaScript
        $this->dispatch('search-updated', search: $value);
    }
    
    public function render()
    {
        return view('livewire.project.project-list');
    }
}
```

```blade
{{-- Dans la vue Livewire --}}
<div>
    <input 
        type="text" 
        wire:model.live="search"
        x-data
        x-init="
            // Restaurer la recherche au chargement
            $wire.search = localStorage.getItem('project-search') || '';
        "
    >
    
    <script>
        // Écouter l'événement Livewire
        Livewire.on('search-updated', (data) => {
            // Sauvegarder dans localStorage
            localStorage.setItem('project-search', data.search);
        });
    </script>
</div>
```

---

## 🔧 Outils de Débogage - Guide Complet

### Commandes Artisan Essentielles

```bash
###############################################
# VÉRIFICATION DES SLUGS
###############################################

# Compter les projets sans slug
php artisan tinker --execute="echo 'Projects sans slug: ' . App\Models\Project::whereNull('slug')->count();"

# Vérifier un slug spécifique
php artisan tinker --execute="
    \$project = App\Models\Project::find(46);
    echo 'Projet #46:';
    echo '  - Titre: ' . \$project->title;
    echo '  - Slug: ' . \$project->slug;
"

# Lister tous les projets avec leurs slugs
php artisan tinker --execute="
    App\Models\Project::all()->each(function(\$p) {
        echo \$p->id . ': ' . \$p->slug . PHP_EOL;
    });
"

###############################################
# VÉRIFICATION DES ROUTES
###############################################

# Lister toutes les routes
php artisan route:list

# Filtrer par nom
php artisan route:list --name=projects

# Filtrer par méthode
php artisan route:list --method=GET

# Rechercher une route spécifique
php artisan route:list | grep projects.detail

# Afficher en format compact
php artisan route:list --compact

###############################################
# VÉRIFICATION DES RELATIONS
###############################################

# Tester une relation
php artisan tinker --execute="
    \$project = App\Models\Project::with('client')->find(46);
    echo 'Client: ' . \$project->client->name;
"

# Vérifier N+1 problem
php artisan tinker --execute="
    DB::enableQueryLog();
    \$projects = App\Models\Project::limit(10)->get();
    \$projects->each(fn(\$p) => \$p->client->name);
    echo 'Requêtes: ' . count(DB::getQueryLog());
"

###############################################
# GÉNÉRATION DE SLUGS
###############################################

# Exécuter un seeder spécifique
php artisan db:seed --class=UserSlugSeeder
php artisan db:seed --class=ProjectSlugSeeder

# Exécuter tous les seeders
php artisan db:seed

# Refresh + seed (attention: efface les données!)
php artisan migrate:fresh --seed

###############################################
# CACHE ET OPTIMISATION
###############################################

# Vider tous les caches
php artisan optimize:clear

# Vider un cache spécifique
php artisan cache:clear      # Cache applicatif
php artisan config:clear     # Cache config
php artisan route:clear      # Cache routes
php artisan view:clear       # Cache vues

# Optimiser pour la production
php artisan optimize         # Compile tout

# Cache des routes (production)
php artisan route:cache

# Cache de la config (production)
php artisan config:cache

###############################################
# DEBUGGING LIVEWIRE
###############################################

# Lister les composants Livewire
php artisan livewire:list

# Créer un composant
php artisan make:livewire ProjectCard

# Supprimer un composant
php artisan livewire:delete ProjectCard

###############################################
# LOGS ET ERREURS
###############################################

# Suivre les logs en temps réel
tail -f storage/logs/laravel.log

# Vider les logs
echo "" > storage/logs/laravel.log

# Voir les dernières erreurs
tail -n 50 storage/logs/laravel.log

###############################################
# BASE DE DONNÉES
###############################################

# Connexion à la DB
php artisan db

# Afficher les migrations
php artisan migrate:status

# Rollback dernière migration
php artisan migrate:rollback

# Rollback toutes les migrations
php artisan migrate:reset

# Refresh (rollback + migrate)
php artisan migrate:refresh

###############################################
# TINKER - CONSOLE INTERACTIVE
###############################################

# Lancer tinker
php artisan tinker

# Dans tinker:
>>> $project = Project::find(46);
>>> $project->title;
>>> $project->client->name;
>>> $project->update(['status' => 'published']);

# Exécuter du code directement
php artisan tinker --execute="
    \$count = App\Models\Project::where('status', 'published')->count();
    echo 'Projets publiés: ' . \$count;
"

###############################################
# PERMISSIONS ET PROPRIÉTAIRE
###############################################

# Réparer les permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Ou pour le développement
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Debugging avec dd() et dump()

```php
/**
 * OUTILS DE DEBUGGING PHP
 * 
 * ========================================
 * dd() - DIE AND DUMP
 * ========================================
 * 
 * Affiche une variable et arrête l'exécution
 */

// Dans un contrôleur ou composant
public function mount(Project $project)
{
    // Debug: voir ce que contient $project
    dd($project);
    // Tout s'arrête ici, rien après n'est exécuté
    
    $this->project = $project; // Jamais atteint
}

// Debug multiple variables
dd($project, $project->client, $project->technologies);

/**
 * ========================================
 * dump() - DUMP SANS ARRÊTER
 * ========================================
 * 
 * Affiche une variable SANS arrêter l'exécution
 */

public function mount(Project $project)
{
    dump('Début mount()');
    dump($project->title);
    
    $this->project = $project;
    
    dump('Fin mount()'); // Cette ligne s'exécute
}

/**
 * ========================================
 * ddd() - DUMP, DIE AND DEBUG
 * ========================================
 * 
 * Comme dd() mais avec plus de détails
 */

ddd($project);

/**
 * ========================================
 * ray() - DEBUGGING AVANCÉ (Package)
 * ========================================
 * 
 * Installation: composer require spatie/laravel-ray
 * 
 * AVANTAGES:
 * - N'arrête pas l'exécution
 * - Interface dédiée
 * - Timeline des appels
 * - Filtres et recherche
 */

// Debug simple
ray($project);

// Debug nommé
ray($project)->label('Projet actuel');

// Debug conditionnel
ray($project)->if($project->status === 'draft');

// Mesurer le temps
ray()->measure();
// ... code ...
ray()->measure(); // Affiche le temps écoulé

// Compter les appels
ray()->count('loop');

/**
 * ========================================
 * Log::debug() - LOGGING
 * ========================================
 * 
 * Écrit dans storage/logs/laravel.log
 * N'arrête pas l'exécution
 */

use Illuminate\Support\Facades\Log;

// Log simple
Log::debug('Project chargé', ['id' => $project->id]);

// Log avec contexte
Log::info('Utilisateur connecté', [
    'user_id' => auth()->id(),
    'ip' => request()->ip(),
]);

// Différents niveaux
Log::emergency($message);
Log::alert($message);
Log::critical($message);
Log::error($message);
Log::warning($message);
Log::notice($message);
Log::info($message);
Log::debug($message);

/**
 * ========================================
 * DB::listen() - DEBUG REQUÊTES SQL
 * ========================================
 * 
 * Affiche toutes les requêtes SQL exécutées
 */

// Dans AppServiceProvider::boot()
use Illuminate\Support\Facades\DB;

public function boot()
{
    if (app()->environment('local')) {
        DB::listen(function ($query) {
            dump([
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time . 'ms',
            ]);
        });
    }
}

/**
 * ========================================
 * Laravel Debugbar (Package)
 * ========================================
 * 
 * Installation: composer require barryvdh/laravel-debugbar --dev
 * 
 * FONCTIONNALITÉS:
 * - Barre de debug en bas de page
 * - Liste des requêtes SQL
 * - Temps d'exécution
 * - Variables de session
 * - Routes et paramètres
 * - Logs

---

### Composant ProjectList - Explications Détaillées

```php
<?php

namespace App\Livewire\Project;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Composant pour afficher la liste des projets avec filtres
 * 
 * FONCTIONNALITÉS:
 * - Recherche textuelle
 * - Filtrage par catégorie
 * - Filtrage par technologie
 * - Pagination automatique
 */
class ProjectList extends Component
{
    /**
     * Trait Livewire pour la pagination
     * 
     * EXPLICATION:
     * - Ajoute automatiquement les méthodes de pagination
     * - Gère le numéro de page dans l'URL (?page=2)
     * - Reset automatique à la page 1 lors des recherches/filtres
     */
    use WithPagination;
    
    /**
     * Propriétés publiques réactives
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * Dans Livewire, les propriétés publiques sont:
     * 1. Automatiquement synchronisées avec le frontend
     * 2. Persistées entre les requêtes via JavaScript
     * 3. Déclenchent un re-render quand elles changent
     * 
     * $search: Terme de recherche
     * - Type: string (jamais null grâce à l'initialisation)
     * - Binding: wire:model="search" dans la vue
     * - Effet: Filtre les projets dont le titre contient le terme
     * 
     * $categoryFilter: Catégorie sélectionnée
     * - Type: string
     * - Valeur par défaut: 'all' (pas de filtre)
     * - Valeurs possibles: 'all', 'web', 'mobile', 'desktop', etc.
     * - Binding: wire:model="categoryFilter"
     * 
     * $techFilter: Technologie sélectionnée
     * - Type: string
     * - Valeur par défaut: 'all'
     * - Valeurs possibles: 'all', 'PHP', 'Laravel', 'Vue.js', etc.
     * - Binding: wire:model="techFilter"
     */
    public string $search = '';
    public string $categoryFilter = 'all';
    public string $techFilter = 'all';
    
    /**
     * Computed Property: Récupère les projets filtrés et paginés
     * 
     * @return LengthAwarePaginator
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * COMPUTED PROPERTIES dans Livewire:
     * - Méthode nommée getXxxProperty()
     * - Accessible dans la vue via $this->xxx
     * - Recalculée automatiquement quand les dépendances changent
     * - Ne pas appeler directement getProjectsProperty()
     * 
     * FONCTIONNEMENT DE LA REQUÊTE:
     * 
     * 1. Project::query()
     *    - Démarre un query builder pour la table projects
     * 
     * 2. ->where('status', 'published')
     *    - Filtre de base: seulement les projets publiés
     *    - Évite d'afficher les brouillons ou projets en cours
     * 
     * 3. ->when($this->search, fn($q) => ...)
     *    - Applique conditionnellement un filtre
     *    - Si $this->search est vide: rien ne se passe
     *    - Si $this->search contient "laravel": ajoute WHERE title LIKE '%laravel%'
     *    - fn($q) => ... : fonction anonyme qui reçoit le query builder
     * 
     * 4. ->when($this->categoryFilter !== 'all', fn($q) => ...)
     *    - Applique le filtre de catégorie si différent de 'all'
     *    - Ajoute: WHERE type = 'web' (ou autre catégorie)
     * 
     * 5. ->when($this->techFilter !== 'all', fn($q) => ...)
     *    - Filtre par technologie dans le champ JSON
     *    - whereJsonContains: recherche dans un array JSON
     *    - Exemple: WHERE JSON_CONTAINS(technologies, '"Laravel"')
     * 
     * 6. ->latest()
     *    - Trie par created_at DESC (plus récents en premier)
     *    - Équivalent à: ->orderBy('created_at', 'desc')
     * 
     * 7. ->paginate(12)
     *    - Limite à 12 projets par page
     *    - Retourne un LengthAwarePaginator
     *    - Contient: les données + métadonnées de pagination
     * 
     * AVANTAGES DE CETTE APPROCHE:
     * - Une seule requête SQL, optimisée
     * - Filtres combinables (recherche + catégorie + tech)
     * - Pagination automatique
     * - Pas de N+1 problem
     */
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
    
    /**
     * Méthode render: Retourne la vue du composant
     * 
     * @return \Illuminate\View\View
     * 
     * EXPLICATION:
     * - Appelée automatiquement par Livewire à chaque requête
     * - Retourne la vue Blade associée
     * - Les propriétés publiques sont automatiquement passées à la vue
     * - La vue peut accéder à $this->search, $this->projects, etc.
     */
    public function render()
    {
        return view('livewire.project.project-list');
    }
}
```

**VUE ASSOCIÉE (project-list.blade.php):**
```blade
<div>
    {{-- Barre de recherche --}}
    <div class="mb-6">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Rechercher un projet..."
            class="w-full px-4 py-2 border rounded-lg"
        >
        {{-- 
            wire:model.live="search":
            - Synchronisation en temps réel avec $search
            - Déclenche getProjectsProperty() à chaque frappe
            - Alternative: wire:model.debounce.300ms pour optimiser
        --}}
    </div>

    {{-- Filtres --}}
    <div class="flex gap-4 mb-6">
        <select wire:model.live="categoryFilter">
            <option value="all">Toutes les catégories</option>
            <option value="web">Web</option>
            <option value="mobile">Mobile</option>
        </select>

        <select wire:model.live="techFilter">
            <option value="all">Toutes les technologies</option>
            <option value="PHP">PHP</option>
            <option value="Laravel">Laravel</option>
        </select>
    </div>

    {{-- Grille de projets --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($this->projects as $project)
            <div class="bg-white rounded-lg shadow p-4">
                <h3>{{ $project->title }}</h3>
                <p>{{ Str::limit($project->description, 100) }}</p>
                <a href="{{ route('projects.detail', $project->slug) }}">
                    Voir le projet
                </a>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $this->projects->links() }}
        {{-- 
            Affiche les liens de pagination automatiquement
            Génère: « Précédent 1 2 3 Suivant »
            Utilise le style Tailwind par défaut
        --}}
    </div>
</div>
```

---

### Composant ProjectDetail - Explications Détaillées

```php
<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * Composant pour afficher les détails complets d'un projet
 * 
 * FONCTIONNALITÉS:
 * - Affichage des informations du projet
 * - Liste des collaborateurs
 * - Progression des jalons
 * - Projets similaires
 * - Statistiques du projet
 */
class ProjectDetail extends Component
{
    /**
     * Propriétés publiques typées
     * 
     * EXPLICATION DU TYPAGE:
     * 
     * public Project $project:
     * - Type hint fort: doit être une instance de Project
     * - Livewire sait comment sérialiser/désérialiser les modèles Eloquent
     * - Accessible dans la vue: {{ $project->title }}
     * 
     * public Collection $similarProjects:
     * - Collection Eloquent contenant des instances de Project
     * - Méthodes disponibles: map(), filter(), count(), etc.
     * - Utilisé pour boucler: @foreach($similarProjects as $similar)
     * 
     * public Collection $teamMembers:
     * - Collection d'instances User
     * - Filtrée et validée dans mount()
     * - Affiche l'équipe du projet
     */
    public Project $project;
    public Collection $similarProjects;
    public Collection $teamMembers;
    
    /**
     * Propriétés pour les données calculées
     * 
     * POURQUOI DES ARRAYS:
     * - $stats et $milestoneProgress contiennent plusieurs valeurs
     * - Initialisés dans mount() pour éviter les calculs répétés
     * - Type array[] permet de documenter la structure
     */
    public array $stats = [];
    public array $milestoneProgress = [];

    /**
     * Méthode mount: Initialisation du composant
     * 
     * @param Project $project Instance du projet (route model binding)
     * @return void
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * ROUTE MODEL BINDING:
     * - URL: /projects/site-ecommerce-laravel
     * - Laravel cherche: Project::where('slug', 'site-ecommerce-laravel')->firstOrFail()
     * - Si trouvé: passe l'instance à mount()
     * - Si non trouvé: erreur 404 automatique
     * 
     * POURQUOI mount() ET PAS __construct():
     * - mount() est appelé après l'hydratation Livewire
     * - Reçoit les paramètres de route automatiquement
     * - Peut accéder aux propriétés Livewire
     * - __construct() ne doit jamais être utilisé avec Livewire
     */
    public function mount(Project $project): void
    {
        /**
         * 1. EAGER LOADING DES RELATIONS
         * 
         * PROBLÈME N+1:
         * Sans eager loading:
         * - 1 requête pour le projet
         * - 1 requête pour $project->client
         * - 1 requête pour $project->developer
         * - 1 requête pour $project->developer->profile
         * - X requêtes pour $project->reviews
         * = 4+ requêtes SQL
         * 
         * Avec eager loading:
         * - 1 requête pour le projet
         * - 1 requête pour toutes les relations (JOIN)
         * = 2 requêtes SQL
         * 
         * SYNTAXE load():
         * - 'client': charge la relation client
         * - 'developer.profile': charge developer ET son profile (nested)
         * - 'reviews': charge tous les avis
         */
        $this->project = $project->load(['client', 'developer.profile', 'reviews']);
        
        /**
         * 2. RÉCUPÉRATION DES PROJETS SIMILAIRES
         * 
         * Utilise la méthode personnalisée getSimilarProjects()
         * - Paramètre 6: limite à 6 projets similaires
         * - Algorithme basé sur type + technologies
         * - Ordre aléatoire pour varier les suggestions
         */
        $this->similarProjects = $project->getSimilarProjects(6);
        
        /**
         * 3. INITIALISATION DES PROPRIÉTÉS CALCULÉES
         * 
         * POURQUOI DANS mount():
         * - Calcul une seule fois au chargement
         * - Évite les recalculs à chaque render
         * - Stocké en mémoire pour la durée de vie du composant
         */
        $this->stats = $this->getStatsProperty();
        $this->milestoneProgress = $this->getMilestoneProgressProperty();
        
        /**
         * 4. GESTION SÉCURISÉE DES COLLABORATEURS JSON
         * 
         * PROBLÈME DES BOUCLES INFINIES:
         * - Si on utilise $project->collaborators directement
         * - Déclenche l'accesseur getCollaboratorsAttribute()
         * - Qui peut lui-même accéder à d'autres accesseurs
         * - Risque de récursion infinie
         * 
         * SOLUTION getAttribute():
         * - Accède directement à l'attribut brut
         * - Ne déclenche AUCUN accesseur
         * - Retourne la valeur telle quelle dans la DB
         * 
         * VALIDATION DES DONNÉES:
         * - getAttribute() peut retourner null
         * - On utilise ?? [] pour avoir un array par défaut
         * - is_string() vérifie si c'est encore du JSON
         * - json_decode() convertit en array si nécessaire
         */
        $collaborators = $project->getAttribute('collaborators') ?? [];
        if (is_string($collaborators)) {
            $collaborators = json_decode($collaborators, true) ?? [];
        }
        
        /**
         * 5. CONSTRUCTION DE LA COLLECTION D'ÉQUIPE
         * 
         * ÉTAPE PAR ÉTAPE:
         * 
         * collect($collaborators):
         * - Convertit l'array [5, 12, 23] en Collection
         * - Permet d'utiliser les méthodes de Collection
         * 
         * ->map(fn ($id) => User::find($id)):
         * - Transforme chaque ID en instance User
         * - Si l'utilisateur n'existe pas: retourne null
         * - Résultat: [User, null, User]
         * 
         * ->filter():
         * - Supprime les valeurs null
         * - Garde seulement les instances User valides
         * - Résultat: [User, User]
         * 
         * ->values():
         * - Réindexe la collection (0, 1, 2...)
         * - Après filter(), les index peuvent être non-contigus
         * - Important pour l'affichage frontend
         * 
         * OPTIMISATION POSSIBLE:
         * Pour de grandes équipes, utiliser:
         * User::whereIn('id', $collaborators)->get()
         * - Une seule requête SQL au lieu de N
         */
        $this->teamMembers = collect($collaborators)
            ->map(fn ($id) => User::find($id))
            ->filter()
            ->values();
    }

    /**
     * Computed Property: Progression des jalons
     * 
     * @return array{completed: int, total: int, percentage: float}
     * 
     * EXPLICATION DÉTAILLÉE:
     * 
     * STRUCTURE DES MILESTONES EN DB:
     * [
     *   {"id": 1, "title": "Conception", "status": "completed"},
     *   {"id": 2, "title": "Développement", "status": "in_progress"},
     *   {"id": 3, "title": "Tests", "status": "pending"}
     * ]
     * 
     * ALGORITHME:
     * 1. Récupération sécurisée via getAttribute()
     * 2. Validation du type (string JSON vs array)
     * 3. Conversion en Collection pour faciliter le comptage
     * 4. Comptage des jalons complétés
     * 5. Calcul du pourcentage
     * 6. Protection division par zéro
     */
    public function getMilestoneProgressProperty(): array
    {
        // Récupération sécurisée sans déclencher d'accesseur
        $milestones = $this->project->getAttribute('milestones') ?? [];
        
        // Validation et conversion si nécessaire
        if (is_string($milestones)) {
            $milestones = json_decode($milestones, true) ?? [];
        }
        
        // Comptage des jalons complétés
        $completed = collect($milestones)
            ->where('status', 'completed')
            ->count();
        
        // Nombre total de jalons
        $total = count($milestones);
        
        // Calcul du pourcentage avec protection division par zéro
        // round(..., 1) arrondit à 1 décimale (ex: 66.7%)
        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
        ];
    }

    /**
     * Computed Property: Statistiques du projet
     * 
     * @return array{views: int, likes: int, reviews: int, rating: float}
     * 
     * EXPLICATION:
     * 
     * Retourne les statistiques d'engagement du projet:
     * - views: Nombre de vues (compteur)
     * - likes: Nombre de likes/favoris
     * - reviews: Nombre d'avis
     * - rating: Note moyenne sur 5
     * 
     * UTILISATION DU ?? OPERATOR:
     * - Si la propriété n'existe pas: retourne 0
     * - Évite les erreurs "Undefined property"
     * - Fonctionne même si la colonne est nullable
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
     * Méthode render: Retourne la vue
     * 
     * @return View
     */
    public function render(): View
    {
        return view('livewire.project.project-detail');
    }
}
```

---

## 🛣️ Routes et Binding - Explications Détaillées

### Configuration Complète des Routes

```php
<?php

// routes/web.php

/**
 * IMPORTS NÉCESSAIRES
 * 
 * POURQUOI CES IMPORTS:
 * - Évite les erreurs "Class not found"
 * - Permet l'autocomplétion dans l'IDE
 * - Rend le code plus maintenable
 */
use App\Models\User;
use App\Models\Project;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Project\ProjectList;
use App\Livewire\Developer\DeveloperProfile;
use App\Livewire\Portfolio\PortfolioGallery;

/**
 * ROUTES PUBLIQUES (sans authentification)
 * 
 * Ces routes sont accessibles à tous les visiteurs
 */

/**
 * ROUTE: Page d'accueil
 * 
 * SYNTAXE:
 * Route::get($uri, $action)->name($name);
 * 
 * PARAMÈTRES:
 * - $uri: '/' (racine du site)
 * - $action: function() ou Controller@method ou View::class
 * - ->name(): Nom de la route pour route('home')
 * 
 * FONCTIONNEMENT:
 * - Requête GET sur /
 * - Retourne la vue resources/views/welcome.blade.php
 * - Pas de logique métier, juste l'affichage
 */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * ROUTES PROJETS
 */

/**
 * ROUTE: Liste des projets
 * 
 * URL: /projects
 * Vue: resources/views/projects.blade.php
 * 
 * POURQUOI UNE CLOSURE:
 * - Route simple sans logique métier
 * - Juste l'affichage d'une vue
 * - La logique est dans le composant Livewire
 * 
 * ALTERNATIVE:
 * Route::view('projects', 'projects')->name('projects.list');
 */
Route::get('projects', function() { 
    return view('projects'); 
})->name('projects.list');

/**
 * ROUTE: Détail d'un projet
 * 
 * URL: /projects/site-ecommerce-laravel
 * Composant: ProjectDetail
 * 
 * ROUTE MODEL BINDING EN DÉTAIL:
 * 
 * PARAMÈTRE {project}:
 * - Nom du paramètre dans l'URL
 * - Doit correspondre au nom du paramètre dans mount()
 * - Laravel cherche automatiquement dans la table projects
 * 
 * RÉSOLUTION AUTOMATIQUE:
 * 1. Laravel extrait 'site-ecommerce-laravel' de l'URL
 * 2. Appelle Project::getRouteKeyName() → retourne 'slug'
 * 3. Exécute: Project::where('slug', 'site-ecommerce-laravel')->firstOrFail()
 * 4. Si trouvé: passe l'instance à ProjectDetail::mount($project)
 * 5. Si non trouvé: lance une ModelNotFoundException → 404
 * 
 * AVANTAGES:
 * - Pas besoin de chercher manuellement le projet
 * - Erreur 404 automatique si non trouvé
 * - Code plus propre et lisible
 * - Type-safe: on reçoit toujours un Project, jamais null
 */
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');

/**
 * ROUTE: Redirection ID → Slug (temporaire)
 * 
 * URL: /projects/by-id/46
 * Redirige vers: /projects/site-ecommerce-laravel
 * 
 * POURQUOI CETTE ROUTE:
 * 
 * CONTEXTE:
 * - Anciennement: /projects/46 (par ID)
 * - Maintenant: /projects/site-ecommerce-laravel (par slug)
 * - Problème: les anciens liens sont cassés
 * 
 * SOLUTION DE TRANSITION:
 * - Route temporaire pour maintenir la compatibilité
 * - Trouve le projet par ID
 * - Redirige vers la nouvelle URL par slug
 * - Redirection 302 (temporaire) par défaut
 * 
 * ALGORITHME:
 * 1. Reçoit l'ID dans l'URL
 * 2. Project::findOrFail($id) → trouve ou 404
 * 3. redirect()->route() avec le slug
 * 4. Le navigateur reçoit une redirection HTTP
 * 5. Charge la nouvelle URL avec le slug
 * 
 * À SUPPRIMER:
 * - Une fois tous les liens migrés
 * - Quand aucun lien externe ne pointe vers /by-id/
 */
Route::get('projects/by-id/{id}', function($id) { 
    $project = Project::findOrFail($id); 
    return redirect()->route('projects.detail', $project->slug);
})->name('projects.detail.by-id');

/**
 * ROUTES DÉVELOPPEURS
 */

/**
 * ROUTE: Liste des développeurs
 * 
 * URL: /developers
 * Vue: resources/views/developers.blade.php
 * Composant: DeveloperList (inclus dans la vue)
 */
Route::get('developers', function() { 
    return view('developers'); 
})->name('developers.list');

/**
 * ROUTE: Profil d'un développeur
 * 
 * URL: /developers/123
 * Composant: DeveloperProfile
 * 
 * BINDING PAR ID (TEMPORAIRE):
 * - User::getRouteKeyName() retourne 'id'
 * - Laravel cherche: User::where('id', 123)->firstOrFail()
 * 
 * TRANSITION VERS SLUG:
 * - Actuellement en 'id' pour compatibilité
 * - Passer à 'slug' une fois tous les slugs générés
 * - URL future: /developers/jean-dupont-123
 * 
 * PARAMÈTRE {developer}:
 * - Nom générique pour le paramètre
 * - Correspond à mount(User $developer)
 * - Laravel sait que c'est un User grâce au type hint
 */
Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');

/**
 * ROUTES PORTFOLIO
 */

/**
 * ROUTE: Galerie portfolio
 * 
 * URL: /portfolio
 * Composant: PortfolioGallery
 * 
 * DIFFÉRENCE AVEC ProjectList:
 * - ProjectList: liste administrative/fonctionnelle
 * - PortfolioGallery: vue galerie/vitrineélégante
 * - Même données, présentation différente
 */
Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');

/**
 * ROUTES PROTÉGÉES (nécessitent authentification)
 * 
 * MIDDLEWARE:
 * - 'auth': Utilisateur doit être connecté
 * - 'verified': Email doit être vérifié
 * 
 * FONCTIONNEMENT:
 * - Si non authentifié: redirect vers /login
 * - Si email non vérifié: redirect vers /verify-email
 * - Si authentifié et vérifié: accès autorisé
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    /**
     * ROUTE: Tableau de bord
     * 
     * URL: /dashboard
     * Vue: resources/views/dashboard.blade.php
     * 
     * Route::view():
     * - Raccourci pour retourner une vue simple
     * - Équivalent à: Route::get('dashboard', fn() => view('dashboard'))
     */
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    /**
     * ROUTES PARAMÈTRES
     * 
     * STRUCTURE:
     * /settings/profile → Éditer le profil
     * /settings/password → Changer le mot de passe
     * /settings/appearance → Thème et apparence
     */
    
    // Redirection par défaut vers /settings/profile
    Route::redirect('settings', 'settings/profile');
    
    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
    
    /**
     * ROUTE: Progression d'un projet
     * 
     * URL: /projects/site-ecommerce-laravel/progress
     * Composant: ProjectProgress
     * 
     * ROUTE IMBRIQUÉE:
     * - Préfixe: projects/{project}
     * - Suffixe: /progress
     * - Binding automatique du projet
     * 
     * ACCÈS RESTREINT:
     * - Seulement pour les utilisateurs authentifiés
     * - Permet au client/dev de suivre la progression
     * - Affiche jalons, tâches, timeline
     */
    Route::get('projects/{project}/progress', ProjectProgress::class)->name('projects.progress');
    
    /**
     * ROUTE: Tableau de bord des commissions
     * 
     * URL: /commissions
     * Composant: CommissionDashboard
     * 
     * FONCTIONNALITÉ:
     * - Développeurs voient leurs gains
     * - Clients voient leurs paiements
     * - Historique des transactions
     */
    Route::get('commissions', CommissionDashboard::class)->name('commissions.dashboard');
});
```

---

### Route Model Binding - Concepts Avancés

```php
/**
 * ROUTE MODEL BINDING: GUIDE COMPLET
 * 
 * ========================================
 * CONCEPT DE BASE
 * ========================================
 * 
 * Le Route Model Binding permet de résoudre automatiquement
 * les modèles Eloquent à partir des paramètres de route.
 * 
 * Au lieu de:
 * Route::get('projects/{id}', function($id) {
 *     $project = Project::findOrFail($id);
 *     return view('project', compact('project'));
 * });
 * 
 * On fait:
 * Route::get('projects/{project}', function(Project $project) {
 *     return view('project', compact('project'));
 * });
 * 
 * Laravel résout automatiquement $project!
 */

/**
 * ========================================
 * TYPES DE BINDING
 * ========================================
 */

/**
 * 1. IMPLICIT BINDING (implicite)
 * 
 * CONFIGURATION:
 * - Rien à configurer!
 * - Laravel devine automatiquement
 * - Utilise la clé primaire (id) par défaut
 */
Route::get('users/{user}', function (User $user) {
    // Laravel exécute: User::where('id', $user)->firstOrFail()
    return $user;
});

/**
 * 2. CUSTOM KEY BINDING (clé personnalisée)
 * 
 * CONFIGURATION DANS LE MODÈLE:
 */
class Project extends Model
{
    /**
     * Définit la colonne utilisée pour le binding
     * 
     * @return string
     * 
     * Par défaut: 'id'
     * Ici: 'slug'
     * 
     * IMPACT:
     * - Route: /projects/{project}
     * - URL: /projects/site-ecommerce-laravel
     * - Laravel exécute: Project::where('slug', 'site-ecommerce-laravel')->firstOrFail()
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

/**
 * 3. EXPLICIT BINDING (explicite)
 * 
 * CONFIGURATION DANS RouteServiceProvider:
 */
public function boot()
{
    /**
     * Binding personnalisé pour 'user'
     * 
     * UTILISATION:
     * Route::get('users/{user}', ...)
     * 
     * LOGIQUE PERSONNALISÉE:
     * - Trouve par slug
     * - Si non trouvé par slug, cherche par ID
     * - Permet la transition slug/ID
     */
    Route::bind('user', function ($value) {
        return User::where('slug', $value)
            ->orWhere('id', $value)
            ->firstOrFail();
    });
}

/**
 * ========================================
 * BINDING AVEC LIVEWIRE
 * ========================================
 */

/**
 * ROUTE LIVEWIRE:
 */
Route::get('projects/{project}', ProjectDetail::class);

/**
 * COMPOSANT LIVEWIRE:
 */
class ProjectDetail extends Component
{
    public Project $project;
    
    /**
     * mount() reçoit le modèle résolu automatiquement
     * 
     * PROCESSUS:
     * 1. Laravel résout le paramètre {project}
     * 2. Exécute: Project::where('slug', $value)->firstOrFail()
     * 3. Passe l'instance à mount($project)
     * 4. On peut utiliser $project immédiatement
     * 
     * TYPE SAFETY:
     * - $project est toujours une instance de Project
     * - Jamais null (404 si non trouvé)
     * - Autocomplétion dans l'IDE
     */
    public function mount(Project $project): void
    {
        $this->project = $project;
    }
}

/**
 * ========================================
 * GESTION DES ERREURS
 * ========================================
 */

/**
 * ERREUR 404 AUTOMATIQUE:
 * 
 * Si le modèle n'est pas trouvé:
 * - firstOrFail() lance ModelNotFoundException
 * - Laravel convertit en réponse HTTP 404
 * - Affiche la page d'erreur 404
 * 
 * PAS BESOIN DE:
 * if (!$project) {
 *     abort(404);
 * }
 * 
 * C'EST AUTOMATIQUE!
 */

/**
 * PERSONNALISATION DE L'ERREUR:
 */
// app/Exceptions/Handler.php
public function render($request, Throwable $exception)
{
    if ($exception instanceof ModelNotFoundException) {
        return response()->view('errors.404-model', [], 404);
    }
    
    return parent::render($request, $exception);
}

/**
 * ========================================
 * BONNES PRATIQUES
 * ========================================
 */

/**
 * 1. NOMMAGE DES PARAMÈTRES:
 * 
 * ✅ BON:
 * Route::get('projects/{project}', ...) // Singulier, descriptif
 * Route::get('users/{user}/posts/{post}', ...) // Clair et cohérent
 * 
 * ❌ MAUVAIS:
 * Route::get('projects/{id}', ...) // Pas de binding automatique
 * Route::get('projects/{p}', ...) // Pas clair
 */

/**
 * 2. TYPE HINTS:
 * 
 * ✅ BON:
 * public function mount(Project $project): void
 * 
 * ❌ MAUVAIS:
 * public function mount($project): void // Pas de binding
 */

/**
 * 3. CHOIX DE LA CLÉ:
 * 
 * Utiliser 'slug' pour:
 * - URLs publiques (/projects/mon-projet)
 * - SEO important
 * - Partage sur réseaux sociaux
 * 
 * Utiliser 'id' pour:
 * - URLs admin (/admin/users/123)
 * - APIs
 * - Sécurité (ne pas exposer les slugs)
 */

/**
 * 4. EAGER LOADING:
 * 
 * ✅ BON:
 * public function mount(Project $project): void
 * {
 *     $this->project = $project->load(['client', 'developer']);
 * }
 * 
 * ❌ MAUVAIS:
 * public function mount(Project $project): void
 * {
 *     $this->project = $project;
 *     // N+1 problem dans la vue
 * }
 */
```

---

## 🎨 Dark Mode Natif - Guide Complet

### Implémentation sans Flux UI

```php
/**
 * DARK MODE NATIF: GUIDE COMPLET
 * 
 * ========================================
 * POURQUOI ÉVITER FLUX UI
 * ========================================
 * 
 * PROBLÈMES RENCONTRÉS:
 * - Erreur: "$flux is not defined"
 * - Dépendance externe non nécessaire
 * - Moins de contrôle sur l'implémentation
 * - Bugs potentiels avec les mises à jour
 * 
 * AVANTAGES DU NATIF:
 * - Contrôle total sur le code
 * - Pas de dépendance externe
 * - Plus léger et performant
 * - Facile à déboguer
 * - Personnalisable à l'infini
 */

/**
 * ========================================
 * CONFIGURATION TAILWIND
 * ========================================
 */

// tailwind.config.js
module.exports = {
  /**
   * darkMode: 'class'
   * 
   * EXPLICATION:
   * - Active le mode sombre basé sur une classe CSS
   * - La classe 'dark' sur <html> active tous les styles dark:
   * - Exemple: dark:bg-gray-900 appliqué seulement si .dark présent
   * 
   * ALTERNATIVES:
   * - darkMode: 'media' → Basé sur préférence système uniquement
   * - darkMode: false → Désactive le dark mode
   */
  darkMode: 'class',
  
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  
  theme: {
    extend: {
      /**
       * Couleurs personnalisées pour le dark mode
       * 
       * UTILISATION:
       * <div class="bg-primary dark:bg-primary-dark">
       */
      colors: {
        primary: {
          DEFAULT: '#3b82f6', // Bleu pour le mode clair
          dark: '#2563eb',    // Bleu plus foncé pour le dark mode
        }
      }
    }
  }
}

/**
 * ========================================
 * HTML ET STRUCTURE
 * ========================================
 */

// tailwind.config.js
module.exports = {
  darkMode: 'class',
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
}

/**
 * ========================================
 * LAYOUT PRINCIPAL
 * ========================================
 */
```

```blade
{{-- resources/views/components/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="fr" class="h-full">
{{--
    IMPORTANTE: La classe 'dark' sera ajoutée dynamiquement
    par JavaScript selon les préférences utilisateur
    
    MÉCANISME:
    1. Au chargement: JavaScript lit localStorage.getItem('theme')
    2. Si 'dark': ajoute la classe 'dark' à <html>
    3. Si 'light': supprime la classe 'dark'
    4. Si 'system': détecte la préférence OS
    
    RÉSULTAT:
    <html class="h-full dark"> → Active tous les styles dark:
--}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    
    {{-- 
        @vite: Charge les assets compilés par Vite
        - En dev: Hot Module Replacement (HMR)
        - En prod: Fichiers minifiés avec hash
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    {{--
        CLASSES TAILWIND DARK MODE:
        
        bg-gray-50: Fond gris très clair (mode normal)
        dark:bg-gray-900: Fond gris très foncé (mode dark)
        
        text-gray-900: Texte presque noir (mode normal)
        dark:text-gray-100: Texte presque blanc (mode dark)
        
        PRINCIPE:
        - Classes normales s'appliquent par défaut
        - Préfixe dark: s'applique SEULEMENT si .dark sur <html>
        - Transition CSS automatique (définie dans app.css)
    --}}
    
    {{-- Navigation --}}
    <x-components.layouts.public.navbar />
    
    {{-- Contenu principal --}}
    <main>
        @yield('content')
        {{--
            @yield: Directive Blade pour injecter du contenu
            Les vues enfants utilisent @section('content')
        --}}
    </main>
    
    {{-- Pied de page --}}
    <x-components.layouts.public.footer />
    
    {{-- ========================================
         SCRIPT DARK MODE
         ======================================== --}}
    <script>
        /**
         * FONCTION updateTheme()
         * 
         * OBJECTIF:
         * Appliquer le thème selon les préférences utilisateur
         * Gérer 3 modes: light, dark, system
         * 
         * APPELÉE:
         * - Au chargement de la page
         * - Quand l'utilisateur change de thème
         * - Quand la préférence système change
         * 
         * ALGORITHME:
         * 1. Récupérer le thème depuis localStorage
         * 2. Si 'dark': forcer le mode sombre
         * 3. Si 'light': forcer le mode clair
         * 4. Si 'system': suivre la préférence OS
         */
        function updateTheme() {
            /**
             * RÉCUPÉRATION DU THÈME
             * 
             * localStorage.getItem('theme'):
             * - Retourne la valeur sauvegardée
             * - null si jamais défini
             * 
             * || 'system':
             * - Valeur par défaut si rien dans localStorage
             * - Premier chargement = mode système
             */
            const theme = localStorage.getItem('theme') || 'system';
            
            /**
             * RÉFÉRENCE <HTML>
             * 
             * document.documentElement:
             * - Référence à la balise <html>
             * - Permet de manipuler ses classes
             * - Équivalent à document.querySelector('html')
             */
            const html = document.documentElement;
            
            /**
             * APPLICATION DU THÈME
             */
            if (theme === 'dark') {
                /**
                 * MODE SOMBRE FORCÉ
                 * 
                 * classList.add('dark'):
                 * - Ajoute la classe 'dark' à <html>
                 * - Active tous les styles dark: de Tailwind
                 * - Exemple: dark:bg-gray-900 devient actif
                 */
                html.classList.add('dark');
                
            } else if (theme === 'light') {
                /**
                 * MODE CLAIR FORCÉ
                 * 
                 * classList.remove('dark'):
                 * - Supprime la classe 'dark'
                 * - Désactive tous les styles dark:
                 * - Seules les classes normales s'appliquent
                 */
                html.classList.remove('dark');
                
            } else {
                /**
                 * MODE SYSTÈME
                 * 
                 * window.matchMedia():
                 * - API pour tester les media queries CSS
                 * - Retourne un MediaQueryList object
                 * 
                 * '(prefers-color-scheme: dark)':
                 * - Media query CSS standard
                 * - Détecte la préférence OS
                 * - true si l'OS est en mode sombre
                 * 
                 * .matches:
                 * - Booléen: true ou false
                 * - true = OS préfère le mode sombre
                 * - false = OS préfère le mode clair
                 * 
                 * EXEMPLES:
                 * - macOS en mode sombre → matches = true
                 * - Windows en mode clair → matches = false
                 * - Linux avec thème sombre → matches = true
                 */
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            }
        }
        
        /**
         * INITIALISATION AU CHARGEMENT
         * 
         * POURQUOI ICI:
         * - S'exécute avant le rendu complet
         * - Évite le "flash" de mauvais thème
         * - Plus rapide que DOMContentLoaded
         * 
         * ALTERNATIVE:
         * Mettre ce script dans <head> pour encore plus de rapidité
         */
        updateTheme();
        
        /**
         * ÉCOUTE DES CHANGEMENTS SYSTÈME
         * 
         * SCÉNARIO:
         * 1. Utilisateur a choisi mode 'system'
         * 2. Il change son OS de clair à sombre
         * 3. Le site doit suivre automatiquement
         * 
         * addEventListener('change', updateTheme):
         * - Écoute les changements de préférence OS
         * - Rappelle updateTheme() automatiquement
         * - Fonctionne en temps réel
         * 
         * EXEMPLE:
         * 1. Site en mode system (clair car OS clair)
         * 2. Utilisateur active le mode sombre sur son OS
         * 3. Event 'change' se déclenche
         * 4. updateTheme() détecte le changement
         * 5. Site passe en mode sombre automatiquement
         */
        window.matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', updateTheme);
    </script>
</body>
</html>
```

---

### Composant Toggle Alpine.js - Version Complète

```blade
{{-- resources/views/components/layouts/public/navbar.blade.php --}}

<nav class="bg-white dark:bg-gray-800 shadow">
    {{--
        STYLES NAVBAR DARK MODE:
        - bg-white: Fond blanc en mode normal
        - dark:bg-gray-800: Fond gris foncé en mode dark
        - shadow: Ombre portée (identique en normal et dark)
    --}}
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- Logo et navigation --}}
            <div class="flex">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                        Portfolio
                    </span>
                </a>
                
                {{-- Menu items --}}
                <div class="hidden md:flex md:ml-10 md:space-x-8">
                    <a href="{{ route('projects.list') }}" 
                       class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        Projets
                    </a>
                    <a href="{{ route('developers.list') }}" 
                       class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        Développeurs
                    </a>
                    <a href="{{ route('portfolio.gallery') }}" 
                       class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        Portfolio
                    </a>
                </div>
            </div>
            
            {{-- ========================================
                 DARK MODE TOGGLE - COMPOSANT ALPINE.JS
                 ======================================== --}}
            <div x-data="{ theme: localStorage.getItem('theme') || 'system' }" 
                 class="ml-4 flex items-center">
                {{--
                    ALPINE.JS x-data:
                    
                    SYNTAXE:
                    x-data="{ propriété: valeur }"
                    
                    FONCTIONNEMENT:
                    - Initialise un composant Alpine.js réactif
                    - theme: État local du composant
                    - Lit depuis localStorage au chargement
                    - Réactif: change automatiquement l'UI
                    
                    PORTÉE:
                    - Accessible dans cet élément et ses enfants
                    - Utilisable avec x-bind, @click, etc.
                    - Isolé des autres composants x-data
                    
                    EXEMPLE:
                    Si localStorage contient 'dark':
                    → theme = 'dark'
                    → Bouton dark sera mis en surbrillance
                --}}
                
                <div class="flex rounded-lg bg-zinc-800/5 dark:bg-white/10 p-1">
                    {{--
                        CONTENEUR DES BOUTONS:
                        
                        rounded-lg: Coins arrondis
                        bg-zinc-800/5: Fond gris transparent (5%) en mode clair
                        dark:bg-white/10: Fond blanc transparent (10%) en mode dark
                        p-1: Padding de 4px (0.25rem)
                        
                        RÉSULTAT VISUEL:
                        - Fond subtle qui change avec le thème
                        - Contient les 3 boutons de thème
                    --}}
                    
                    {{-- ========================================
                         BOUTON LIGHT MODE
                         ======================================== --}}
                    <button 
                        @click="theme = 'light'; localStorage.setItem('theme', 'light'); updateTheme()"
                        {{--
                            ALPINE.JS @click:
                            
                            SYNTAXE:
                            @click="expression1; expression2; expression3"
                            
                            ACTIONS SÉQUENTIELLES:
                            
                            1. theme = 'light'
                               - Met à jour la variable réactive Alpine.js
                               - Déclenche le re-render des :class
                               - Effet immédiat dans l'UI
                            
                            2. localStorage.setItem('theme', 'light')
                               - Sauvegarde la préférence
                               - Persiste entre les sessions
                               - Disponible au prochain chargement
                            
                            3. updateTheme()
                               - Appelle la fonction JavaScript globale
                               - Ajoute/supprime la classe 'dark' sur <html>
                               - Applique effectivement le thème
                            
                            POURQUOI CET ORDRE:
                            - Alpine.js d'abord pour l'UI réactive
                            - localStorage ensuite pour la persistance
                            - updateTheme() en dernier pour l'application
                        --}}
                        
                        :class="theme === 'light' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                        {{--
                            ALPINE.JS :class:
                            
                            SYNTAXE:
                            :class="condition ? 'classes-si-vrai' : 'classes-si-faux'"
                            
                            BINDING DYNAMIQUE:
                            - : = raccourci pour x-bind:class
                            - Évalue l'expression JavaScript
                            - Applique les classes conditionnellement
                            - Réactif: change automatiquement
                            
                            LOGIQUE:
                            Si theme === 'light':
                            → Ajoute 'bg-white dark:bg-zinc-800 shadow-sm'
                            → Bouton mis en surbrillance
                            
                            Sinon:
                            → Ajoute '' (rien)
                            → Bouton normal
                            
                            EFFET VISUEL:
                            - Bouton actif a un fond blanc + ombre
                            - Boutons inactifs sont transparents
                            - Indication visuelle claire du mode actif
                        --}}
                        
                        class="p-2 rounded-md transition-colors duration-200"
                        {{--
                            CLASSES STATIQUES:
                            
                            p-2: Padding de 8px
                            rounded-md: Coins arrondis moyens
                            transition-colors: Anime les changements de couleur
                            duration-200: Transition de 200ms
                            
                            EFFET:
                            - Changement de couleur fluide au clic
                            - Animation smooth de 200ms
                        --}}
                        
                        aria-label="Mode clair"
                        {{--
                            ACCESSIBILITÉ:
                            - Décrit le bouton pour les lecteurs d'écran
                            - Important car le bouton ne contient qu'une icône
                            - Norme WCAG 2.1
                        --}}
                    >
                        {{-- ICÔNE SOLEIL (mode clair) --}}
                        <svg class="w-5 h-5 text-yellow-500" 
                             {{--
                                w-5 h-5: Largeur et hauteur de 20px
                                text-yellow-500: Couleur jaune (comme le soleil)
                                fill="currentColor": Remplit avec la couleur du texte
                             --}}
                             fill="currentColor" 
                             viewBox="0 0 20 20">
                            {{-- Path SVG du soleil avec rayons --}}
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                        </svg>
                    </button>
                    
                    {{-- ========================================
                         BOUTON DARK MODE
                         ======================================== --}}
                    <button 
                        @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); updateTheme()"
                        {{--
                            IDENTIQUE AU BOUTON LIGHT:
                            - Change theme en 'dark'
                            - Sauvegarde 'dark' dans localStorage
                            - Applique le thème avec updateTheme()
                        --}}
                        
                        :class="theme === 'dark' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                        {{--
                            Bouton actif si theme === 'dark'
                            Même style que le bouton light
                        --}}
                        
                        class="p-2 rounded-md transition-colors duration-200"
                        aria-label="Mode sombre">
                        
                        {{-- ICÔNE LUNE (mode sombre) --}}
                        <svg class="w-5 h-5 text-purple-500"
                             {{--
                                text-purple-500: Couleur violette (nuit)
                                Distingue visuellement du soleil
                             --}}
                             fill="currentColor" 
                             viewBox="0 0 20 20">
                            {{-- Path SVG du croissant de lune --}}
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                        </svg>
                    </button>
                    
                    {{-- ========================================
                         BOUTON SYSTEM MODE
                         ======================================== --}}
                    <button 
                        @click="theme = 'system'; localStorage.setItem('theme', 'system'); updateTheme()"
                        {{--
                            MODE SYSTÈME:
                            - Suit automatiquement la préférence OS
                            - Pas de forçage manuel
                            - Change si l'OS change
                            
                            updateTheme() détectera:
                            - prefers-color-scheme: dark → mode sombre
                            - prefers-color-scheme: light → mode clair
                        --}}
                        
                        :class="theme === 'system' ? 'bg-white dark:bg-zinc-800 shadow-sm' : ''"
                        {{--
                            Actif par défaut si aucun choix
                            Mode recommandé pour la plupart des utilisateurs
                        --}}
                        
                        class="p-2 rounded-md transition-colors duration-200"
                        aria-label="Mode système">
                        
                        {{-- ICÔNE ORDINATEUR (système) --}}
                        <svg class="w-5 h-5 text-gray-500"
                             {{--
                                text-gray-500: Couleur neutre (système)
                                Ni jaune ni violet, mais gris
                             --}}
                             fill="currentColor" 
                             viewBox="0 0 20 20">
                            {{-- Path SVG d'un moniteur d'ordinateur --}}
                            <path fill-rule="evenodd" 
                                  d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" 
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>
```

---

### Version Mobile du Toggle

```blade
{{-- Toggle mobile dans le menu hamburger --}}
<div class="md:hidden" x-show="mobileMenuOpen">
    {{--
        VERSION MOBILE:
        - md:hidden: Caché sur desktop (≥768px)
        - x-show: Contrôlé par Alpine.js
        - mobileMenuOpen: Variable booléenne
    --}}
    
    <div class="px-2 pt-2 pb-3 space-y-1">
        {{-- Menu items mobiles... --}}
    </div>
    
    {{-- Dark Mode Toggle Mobile --}}
    <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
        <div class="px-4">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Thème
            </p>
            
            <div x-data="{ theme: localStorage.getItem('theme') || 'system' }" 
                 class="flex flex-col space-y-2">
                {{--
                    DIFFÉRENCE MOBILE:
                    - flex-col: Disposition verticale
                    - space-y-2: Espacement vertical
                    - Boutons pleine largeur
                --}}
                
                {{-- Bouton Light --}}
                <button 
                    @click="theme = 'light'; localStorage.setItem('theme', 'light'); updateTheme()"
                    :class="theme === 'light' ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-800'"
                    class="w-full flex items-center justify-center px-4 py-2 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                    </svg>
                    <span>Mode clair</span>
                </button>
                
                {{-- Boutons Dark et System similaires... --}}
            </div>
        </div>
    </div>
</div>
```

---

## 📱 Responsive Design - Explications

### Breakpoints Tailwind

```css
/**
 * BREAKPOINTS TAILWIND PAR DÉFAUT
 * 
 * Ces valeurs définissent les points de rupture responsive
 */

/* Mobile-first approach */
/* Par défaut: < 640px (mobile) */
.text-sm { font-size: 0.875rem; }

/* sm: Small devices (≥640px) */
@media (min-width: 640px) {
  .sm\:text-base { font-size: 1rem; }
}

/* md: Medium devices (≥768px - tablettes) */
@media (min-width: 768px) {
  .md\:text-lg { font-size: 1.125rem; }
  .md\:hidden { display: none; } /* Cache sur tablette/desktop */
  .md\:flex { display: flex; }   /* Affiche sur tablette/desktop */
}

/* lg: Large devices (≥1024px - petits desktops) */
@media (min-width: 1024px) {
  .lg\:text-xl { font-size: 1.25rem; }
  .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
}

/* xl: Extra large (≥1280px - grands desktops) */
@media (min-width: 1280px) {
  .xl\:text-2xl { font-size: 1.5rem; }
}

/* 2xl: 2X Extra large (≥1536px - très grands écrans) */
@media (min-width: 1536px) {
  .\32xl\:text-3xl { font-size: 1.875rem; }
}
```

### Exemples Pratiques Responsive

```blade
{{-- 
    GRILLE RESPONSIVE
    
    MOBILE (< 768px):
    - 1 colonne (grid-cols-1)
    - Cartes empilées verticalement
    
    TABLETTE (≥ 768px):
    - 2 colonnes (md:grid-cols-2)
    - Cartes côte à côte
    
    DESKTOP (≥ 1024px):
    - 3 colonnes (lg:grid-cols-3)
    - Affichage optimal
--}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($projects as $project)
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
            {{-- Contenu --}}
        </div>
    @endforeach
</div>

{{--
    NAVIGATION RESPONSIVE
    
    MOBILE:
    - Menu hamburger visible (md:hidden)
    - Navigation pleine largeur
    
    DESKTOP:
    - Menu hamburger caché (hidden md:flex)
    - Navigation horizontale
--}}
<nav>
    {{-- Bouton hamburger (mobile seulement) --}}
    <button class="md:hidden" @click="mobileMenuOpen = !mobileMenuOpen">
        <svg class="w-6 h-6">...</svg>
    </button>
    
    {{-- Menu desktop --}}
    <div class="hidden md:flex md:space-x-8">
        <a href="#">Projets</a>
        <a href="#">Développeurs</a>
    </div>
</nav>

{{--
    TEXTE RESPONSIVE
    
    Adapte la taille selon l'écran:
    - Mobile: text-sm (14px)
    - Tablette: md:text-base (16px)
    - Desktop: lg:text-lg (18px)
--}}
<p class="text-sm md:text-base lg:text-lg">
    Texte qui grandit avec l'écran
</p>

{{--
    PADDING RESPONSIVE
    
    Optimise l'espace selon l'écran:
    - Mobile: px-4 (16px)
    - Tablette: sm:px-6 (24px)
    - Desktop: lg:px-8 (32px)
--}}
<div class="px-4 sm:px-6 lg:px-8">
    Contenu avec padding adaptatif
</div>
```

---

## 🎯 Récapitulatif Final

### Points Clés de la Documentation

#### 1. **Accesseurs JSON Sécurisés**
```php
// ✅ TOUJOURS utiliser getAttribute()
$milestones = $project->getAttribute('milestones') ?? [];
if (is_string($milestones)) {
    $milestones = json_decode($milestones, true) ?? [];
}
```

#### 2. **Route Model Binding**
```php
// Dans le modèle
public function getRouteKeyName(): string
{
    return 'slug'; // ou 'id'
}

// Dans la route
Route::get('projects/{project}', ProjectDetail::class);

// Dans le composant
public function mount(Project $project): void
{
    $this->project = $project;
}
```

#### 3. **Dark Mode Natif**
```javascript
// JavaScript simple et efficace
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
        }
    }
}
```

#### 4. **Eager Loading Systématique**
```php
// ✅ Une seule requête pour tout
$project = Project::with([
    'client',
    'developer.profile',
    'reviews'
])->find($id);
```

#### 5. **Validation des Données**
```php
// ✅ Toujours valider
public function mount(Project $project)
{
    if ($project->status !== 'published' && !auth()->check()) {
        abort(403);
    }
    
    $this->project = $project;
}
```

---

### Commandes Essentielles à Retenir

```bash
# Génération de slugs
php artisan db:seed --class=UserSlugSeeder
php artisan db:seed --class=ProjectSlugSeeder

# Vérification
php artisan route:list --name=projects
php artisan tinker --execute="Project::whereNull('slug')->count()"

# Cache
php artisan optimize:clear
php artisan optimize

# Debugging
php artisan tinker
tail -f storage/logs/laravel.log
```

---

### Checklist Rapide Avant Déploiement

```markdown
✅ Tous les slugs générés
✅ Routes configurées correctement
✅ Liens mis à jour (slug au lieu de id)
✅ Accesseurs JSON sécurisés
✅ Eager loading partout
✅ Dark mode fonctionnel
✅ Tests passés
✅ Cache optimisé
✅ Logs propres
```

---

### Ressources et Liens Utiles

**Documentation Officielle:**
- Laravel: https://laravel.com/docs
- Livewire: https://livewire.laravel.com
- Alpine.js: https://alpinejs.dev
- Tailwind: https://tailwindcss.com

**Outils de Debug:**
- Laravel Debugbar: `composer require barryvdh/laravel-debugbar --dev`
- Laravel Telescope: `composer require laravel/telescope --dev`
- Ray: `composer require spatie/laravel-ray --dev`

**Communauté:**
- Laravel News: https://laravel-news.com
- Laracasts: https://laracasts.com
- Discord Laravel: https://discord.gg/laravel

---

## 🏆 Conclusion

Cette documentation complète couvre **tous les aspects techniques** du projet Portfolio Développeurs avec :

✅ **Explications ligne par ligne** de chaque portion de code
✅ **Justifications techniques** pour chaque décision d'architecture
✅ **Exemples concrets** de bonnes et mauvaises pratiques
✅ **Solutions détaillées** aux problèmes courants
✅ **Guide de déploiement** complet
✅ **Outils de debugging** et commandes utiles

### Prochaines Étapes Recommandées

1. **Court terme** (cette semaine)
   - Finaliser la génération des slugs utilisateurs
   - Tester toutes les routes en profondeur
   - Valider le dark mode sur tous les navigateurs

2. **Moyen terme** (ce mois)
   - Implémenter les tests automatisés
   - Optimiser les requêtes SQL avec les indexes
   - Ajouter le monitoring en production

3. **Long terme** (prochain trimestre)
   - Migration complète vers les slugs
   - Amélioration des performances
   - Ajout de nouvelles fonctionnalités

---

**🎉 Félicitations ! Vous avez maintenant une documentation complète et détaillée de votre projet.**

*Dernière mise à jour: Janvier 2026*  
*Version: 2.0 - Documentation Complète avec Explications Détaillées*  
*Auteur: Équipe Portfolio Développeurs*

---

## 📞 Support et Contribution

Pour toute question ou amélioration de cette documentation :

1. **Issues GitHub**: Créer une issue avec le tag `[DOC]`
2. **Pull Requests**: Proposer des améliorations
3. **Discussions**: Poser des questions dans les discussions

**N'hésitez pas à contribuer pour améliorer cette documentation !** 🚀