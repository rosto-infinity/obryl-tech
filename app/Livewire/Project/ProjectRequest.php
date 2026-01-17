<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use App\Enums\Project\ProjectStatus;
use App\Models\Project;
use App\Models\ProjectReference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectRequest extends Component
{
    use WithFileUploads;

    // Informations du projet
    public $title = '';

    public $description = '';

    public $type = 'web';

    public $budget = '';

    public $deadline = '';

    public $technologies = [];

    public $priority = 'medium';

    public $attachments = [];

    // Références de plateformes
    public $references = [];

    public $newReference = [
        'platform_name' => '',
        'platform_url' => '',
        'platform_type' => 'reference',
        'description' => '',
    ];

    // État du formulaire
    public $step = 1;

    public $showReferenceForm = false;

    // Messages
    public $successMessage = '';

    public $errorMessage = '';

    protected $rules = [
        'title' => 'required|string|min:5|max:255',
        'description' => 'required|string|min:20|max:2000',
        'type' => 'required|string|in:web,mobile,desktop,api,consulting',
        'budget' => 'required|numeric|min:10000',
        'deadline' => 'required|date|after:today',
        'technologies' => 'required|array|min:1',
        'technologies.*' => 'string|max:50',
        'priority' => 'required|in:low,medium,high,critical',
        'attachments.*' => 'file|max:10240', // 10MB max
    ];

    protected $messages = [
        'title.required' => 'Le titre du projet est obligatoire',
        'title.min' => 'Le titre doit contenir au moins 5 caractères',
        'description.required' => 'La description est obligatoire',
        'description.min' => 'La description doit contenir au moins 20 caractères',
        'budget.min' => 'Le budget minimum est de 10 000 FCFA',
        'deadline.after' => 'La date limite doit être dans le futur',
        'technologies.required' => 'Veuillez spécifier au moins une technologie',
    ];

    public function mount(): void
    {
        $this->technologies = ['Laravel', 'Vue.js']; // Valeurs par défaut
    }

    /**
     * Passer à l'étape suivante
     */
    public function nextStep(): void
    {
        $this->validateStep();
        $this->step++;
    }

    /**
     * Revenir à l'étape précédente
     */
    public function previousStep(): void
    {
        $this->step--;
    }

    /**
     * Valider l'étape actuelle
     */
    public function validateStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'title' => 'required|string|min:5|max:255',
                'description' => 'required|string|min:20|max:2000',
                'type' => 'required',
                'budget' => 'required|numeric|min:10000',
                'deadline' => 'required|date|after:today',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'technologies' => 'required|array|min:1',
                'technologies.*' => 'string|max:50',
                'priority' => 'required|in:low,medium,high,critical',
            ]);
        }
    }

    /**
     * Ajouter une technologie
     */
    public function addTechnology($technology): void
    {
        if (! in_array($technology, $this->technologies) && ! empty($technology)) {
            $this->technologies[] = $technology;
        }
    }

    /**
     * Supprimer une technologie
     */
    public function removeTechnology($key): void
    {
        unset($this->technologies[$key]);
        $this->technologies = array_values($this->technologies);
    }

    /**
     * Ajouter une référence de plateforme
     */
    public function addReference(): void
    {
        $this->validate([
            'newReference.platform_name' => 'required|string|max:255',
            'newReference.platform_url' => 'nullable|url',
            'newReference.description' => 'nullable|string|max:500',
        ]);

        $this->references[] = [
            'platform_name' => $this->newReference['platform_name'],
            'platform_url' => $this->newReference['platform_url'],
            'platform_type' => $this->newReference['platform_type'],
            'description' => $this->newReference['description'],
            'similarity_score' => $this->calculateSimilarity($this->newReference['platform_name']),
        ];

        // Réinitialiser le formulaire de référence
        $this->newReference = [
            'platform_name' => '',
            'platform_url' => '',
            'platform_type' => 'reference',
            'description' => '',
        ];

        $this->showReferenceForm = false;
    }

    /**
     * Supprimer une référence
     */
    public function removeReference($key): void
    {
        unset($this->references[$key]);
        $this->references = array_values($this->references);
    }

    /**
     * Calculer le score de similarité (simplifié)
     */
    public function calculateSimilarity($platformName)
    {
        $keywords = strtolower($this->title.' '.$this->description);
        $platformKeywords = strtolower($platformName);

        similar_text($keywords, $platformKeywords, $percent);

        return min(100, max(0, (int) $percent));
    }

    /**
     * Soumettre le projet
     */
    public function submitProject(): void
    {
        $this->validate();

        try {
            // Créer le projet
            $project = Project::create([
                'code' => 'PRJ-'.strtoupper(Str::random(6)),
                'title' => $this->title,
                'description' => $this->description,
                'slug' => Str::slug($this->title).'-'.Str::random(4),
                'client_id' => Auth::id(),
                'type' => $this->type,
                'status' => ProjectStatus::REQUESTED,
                'priority' => $this->priority,
                'budget' => $this->budget,
                'deadline' => $this->deadline,
                'technologies' => $this->technologies,
                'is_published' => false,
            ]);

            // Ajouter les références
            foreach ($this->references as $reference) {
                ProjectReference::create([
                    'project_id' => $project->id,
                    'platform_name' => $reference['platform_name'],
                    'platform_url' => $reference['platform_url'],
                    'description' => $reference['description'],
                    'similarity_score' => $reference['similarity_score'] ?? 0,
                ]);
            }

            // Émettre un événement pour rafraîchir les notifications
            $this->dispatch('refreshProjectRequests');

            // Traiter les pièces jointes
            if ($this->attachments) {
                foreach ($this->attachments as $attachment) {
                    $path = $attachment->store('project-attachments', 'public');
                    // Ajouter à la table des pièces jointes si nécessaire
                }
            }

            $this->successMessage = 'Votre projet a été soumis avec succès ! Notre équipe vous contactera dans les 24h.';

            // Réinitialiser le formulaire
            $this->reset(['title', 'description', 'type', 'budget', 'deadline', 'technologies', 'priority', 'references', 'attachments']);
            $this->step = 1;

        } catch (\Exception $e) {
            $this->errorMessage = 'Une erreur est survenue : '.$e->getMessage();
        }
    }

    /**
     * Obtenir les suggestions de plateformes
     */
    public function getSuggestedPlatforms()
    {
        $suggestions = [];

        // Basé sur le type de projet
        if ($this->type === 'web') {
            $suggestions = [
                ['name' => 'Shopify', 'url' => 'shopify.com', 'description' => 'Plateforme e-commerce complète'],
                ['name' => 'WooCommerce', 'url' => 'woocommerce.com', 'description' => 'Solution e-commerce WordPress'],
                ['name' => 'Squarespace', 'url' => 'squarespace.com', 'description' => 'Créateur de sites web'],
            ];
        } elseif ($this->type === 'mobile') {
            $suggestions = [
                ['name' => 'Uber', 'url' => 'uber.com', 'description' => 'Application de transport'],
                ['name' => 'Airbnb', 'url' => 'airbnb.com', 'description' => 'Application de location'],
                ['name' => 'Instagram', 'url' => 'instagram.com', 'description' => 'Application de partage photo'],
            ];
        }

        return $suggestions;
    }

    public function render()
    {
        return view('livewire.project.project-request');
    }
}
