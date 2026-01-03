<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ProjectDetail extends Component
{
    public Project $project;
    public Collection $similarProjects;
    public Collection $teamMembers;

    public function mount(Project $project): void
    {
        $this->project = $project->load(['client', 'developer.profile', 'reviews']);
        $this->similarProjects = $project->getSimilarProjects(6);
        $this->teamMembers = $project->collaborators ?? new Collection();
    }

    /**
     * Get project statistics.
     */
    public function getStatsProperty(): array
    {
        return [
            'views' => $this->project->views_count ?? 0,
            'likes' => $this->project->likes_count ?? 0,
            'comments' => $this->project->comments_count ?? 0,
            'shares' => $this->project->shares_count ?? 0,
        ];
    }

    /**
     * Get milestone progress.
     */
    public function getMilestoneProgressProperty(): array
    {
        $milestones = $this->project->milestones ?? [];
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
