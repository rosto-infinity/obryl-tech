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
    
    // Computed properties for Livewire 3
    public array $stats = [];
    public array $milestoneProgress = [];

    public function mount(Project $project): void
    {
        $this->project = $project->load(['client', 'developer.profile', 'reviews']);
        $this->similarProjects = $project->getSimilarProjects(6);
        
        // Initialize computed properties
        $this->stats = $this->getStatsProperty();
        $this->milestoneProgress = $this->getMilestoneProgressProperty();
        
        // Handle collaborators JSON field
        $collaborators = $project->collaborators ?? [];
        if (is_string($collaborators)) {
            $collaborators = json_decode($collaborators, true) ?? [];
        }
        $this->teamMembers = collect($collaborators);
    }

    /**
     * Get project statistics.
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
     * Get milestone progress.
     */
    public function getMilestoneProgressProperty(): array
    {
        $milestones = $this->project->milestones ?? [];
        
        // Handle JSON string
        if (is_string($milestones)) {
            $milestones = json_decode($milestones, true) ?? [];
        }
        
        $completed = collect($milestones)->where('status', 'completed')->count();
        $total = count($milestones);
        
        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? ($completed / $total) * 100 : 0,
        ];
    }

    /**
     * Like the project.
     */
    public function likeProject(): void
    {
        // Logic to toggle like
        $this->dispatch('projectLiked');
    }

    /**
     * Share the project.
     */
    public function shareProject(): void
    {
        $this->dispatch('projectShared');
    }

    public function render(): View
    {
        return view('livewire.project.project-detail');
    }
}
