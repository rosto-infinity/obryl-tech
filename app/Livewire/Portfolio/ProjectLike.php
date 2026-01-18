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
        $sessionKey = 'liked_projects';
        $likedProjects = session()->get($sessionKey, []);

        if ($this->isLiked) {
            // Remove like
            $this->project->decrement('likes_count');
            $this->likeCount--;
            $this->isLiked = false;
            
            if (($key = array_search($this->project->id, $likedProjects)) !== false) {
                unset($likedProjects[$key]);
            }
        } else {
            // Add like
            $this->project->increment('likes_count');
            $this->likeCount++;
            $this->isLiked = true;
            
            if (!in_array($this->project->id, $likedProjects)) {
                $likedProjects[] = $this->project->id;
            }
        }

        session()->put($sessionKey, array_values($likedProjects));

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
        $likedProjects = session()->get('liked_projects', []);
        
        return in_array($this->project->id, $likedProjects);
    }

    public function render(): View
    {
        return view('livewire.portfolio.project-like');
    }
}
