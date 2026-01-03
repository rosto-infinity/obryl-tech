<?php

declare(strict_types=1);

namespace App\Livewire\Portfolio;

use App\Models\Project;
use Illuminate\View\View;
use Livewire\Component;

class ProjectLike extends Component
{
    public Project $project;
    public bool $isLiked = false;
    public int $likeCount = 0;

    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->likeCount = $project->likes_count ?? 0;
        $this->isLiked = $this->checkIfLiked();
    }

    /**
     * Toggle like status.
     */
    public function toggleLike(): void
    {
        $this->isLiked = !$this->isLiked;
        
        if ($this->isLiked) {
            $this->project->increment('likes_count');
            $this->likeCount++;
        } else {
            $this->project->decrement('likes_count');
            $this->likeCount--;
        }
        
        $this->dispatch('projectLiked', [
            'projectId' => $this->project->id,
            'isLiked' => $this->isLiked,
            'likeCount' => $this->likeCount,
        ]);
    }

    /**
     * Check if project is liked by current user.
     */
    private function checkIfLiked(): bool
    {
        // Simulated logic - replace with actual user like check
        return false;
    }

    public function render(): View
    {
        return view('livewire.portfolio.project-like');
    }
}
