<?php

declare(strict_types=1);

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
        // 1. Charger les relations
        $this->project = $project->load(['client', 'developer', 'reviews']);
        
        // 2. Récupérer les projets similaires
        $this->similarProjects = $project->getSimilarProjects(6);
        
        // --- CORRECTION : NORMALISATION DES CHAMPS JSON ---
        // On s'assure que Milestones, Technologies et Collaborators sont des tableaux PHP
        // Cela résout l'erreur "count(): Argument must be... string given" dans la Vue
        
        $this->project->milestones = $this->toArray($this->project->milestones);
        $this->project->technologies = $this->toArray($this->project->technologies);
        $this->project->collaborators = $this->toArray($this->project->collaborators);
        // -----------------------------------------------

        // 3. Initialiser les stats (ces méthodes recevront désormais de vrais tableaux)
        $this->stats = $this->getStatsProperty();
        $this->milestoneProgress = $this->getMilestoneProgressProperty();
        
        // 4. Gérer les membres de l'équipe
        $collaborators = $this->project->collaborators; // Maintenant garanti être un tableau
        
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

    public function getStatsProperty(): array
    {
        return [
            'views' => $this->project->views_count ?? 0,
            'likes' => $this->project->likes_count ?? 0,
            'reviews' => $this->project->reviews_count ?? 0,
            'rating' => $this->project->average_rating ?? 0,
        ];
    }

    public function getMilestoneProgressProperty(): array
    {
        // Maintenant $this->project->milestones est garanti être un tableau grâce au mount()
        $milestones = $this->project->milestones ?? [];
        
        $completed = collect($milestones)->where('status', 'completed')->count();
        $total = count($milestones);
        
        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
        ];
    }

    public function likeProject(): void
    {
        $this->dispatch('projectLiked');
    }

    public function shareProject(): void
    {
        $this->dispatch('projectShared');
    }

    public function render(): View
    {
        return view('livewire.project.project-detail');
    }
}