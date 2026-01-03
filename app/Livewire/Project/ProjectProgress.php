<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ProjectProgress extends Component
{
    public Project $project;
    public array $milestoneProgress = [];
    public array $stats = [];
    public Collection $teamMembers;

    public function mount(Project $project): void
    {
        $this->project = $project->load(['client', 'developer.profile']);
        
        // Initialize computed properties
        $this->stats = $this->getStatsProperty();
        $this->milestoneProgress = $this->getMilestoneProgressProperty();
        
        // Initialize team members
        $collaborators = $this->project->collaborators ?? [];
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
     * Mark project as completed.
     */
    public function markAsCompleted(): void
    {
        $this->project->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100
        ]);

        $this->dispatch('projectCompleted', [
            'project' => $this->project
        ]);

        // Redirect to project detail
        $this->redirect(route('projects.detail', $this->project->id));
    }

    /**
     * Export project progress.
     */
    public function exportProgress(): void
    {
        $progressData = [
            'project' => [
                'id' => $this->project->id,
                'title' => $this->project->title,
                'code' => $this->project->code,
                'status' => $this->project->status,
                'progress_percentage' => $this->project->progress_percentage,
                'started_at' => $this->project->started_at,
                'deadline' => $this->project->deadline,
                'budget' => $this->project->budget,
                'final_cost' => $this->project->final_cost,
            ],
            'milestones' => $this->milestoneProgress,
            'stats' => $this->stats,
            'exported_at' => now()->toDateTimeString(),
        ];

        $this->dispatch('progressExported', $progressData);
    }

    public function render(): View
    {
        return view('livewire.project.project-progress');
    }
}
