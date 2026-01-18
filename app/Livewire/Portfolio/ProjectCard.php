<?php

declare(strict_types=1);

namespace App\Livewire\Portfolio;

use App\Models\Project;
use Illuminate\View\View;
use Livewire\Component;

class ProjectCard extends Component
{
    public Project $project;

    public bool $showDetails = false;

    public bool $isLiked = false;

    public function mount(Project $project): void
    {
        $this->project = $project->load(['client', 'developer.profile', 'reviews']);
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
            $this->isLiked = false;
            
            if (($key = array_search($this->project->id, $likedProjects)) !== false) {
                unset($likedProjects[$key]);
            }
        } else {
            // Add like
            $this->project->increment('likes_count');
            $this->isLiked = true;
            
            if (!in_array($this->project->id, $likedProjects)) {
                $likedProjects[] = $this->project->id;
            }
        }

        session()->put($sessionKey, array_values($likedProjects));

        $this->dispatch('projectLiked', [
            'projectId' => $this->project->id,
            'isLiked' => $this->isLiked,
        ]);
    }

    /**
     * Toggle details view.
     */
    public function toggleDetails(): void
    {
        $this->showDetails = ! $this->showDetails;
    }

    /**
     * Check if project is liked by current user.
     */
    private function checkIfLiked(): bool
    {
        $likedProjects = session()->get('liked_projects', []);
        
        return in_array($this->project->id, $likedProjects);
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

    public function render(): View
    {
        return view('livewire.portfolio.project-card', [
            'stats' => $this->stats,
        ])->extends('components.layouts.public');
    }
}
