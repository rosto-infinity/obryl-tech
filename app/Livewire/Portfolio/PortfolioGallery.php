<?php

declare(strict_types=1);

namespace App\Livewire\Portfolio;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class PortfolioGallery extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = 'all';
    public string $techFilter = 'all';
    public string $sortBy = 'created_at';
    public int $perPage = 12;

    /**
     * Get projects for gallery.
     */
    public function getProjectsProperty(): LengthAwarePaginator
    {
        $query = Project::query()
            ->with(['client', 'reviews'])
            ->where('status', 'published')
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%'))
            ->when($this->categoryFilter !== 'all', fn($q) => $q->where('type', $this->categoryFilter))
            ->when($this->techFilter !== 'all', fn($q) => $q->whereJsonContains('technologies', $this->techFilter))
            ->orderByDesc($this->sortBy);

        return $query->paginate($this->perPage);
    }

    /**
     * Get statistics.
     */
    public function getStatsProperty(): array
    {
        return [
            'total_projects' => Project::where('status', 'published')->count(),
            'developers' => User::where('user_type', 'developer')->count(),
            'total_likes' => Project::sum('likes_count'),
            'categories' => Project::distinct('type')->count('type'),
        ];
    }

    /**
     * Get categories for filter.
     */
    public function getCategoriesProperty(): array
    {
        return [
            ['value' => 'web', 'label' => 'Web'],
            ['value' => 'mobile', 'label' => 'Mobile'],
            ['value' => 'desktop', 'label' => 'Desktop'],
            ['value' => 'api', 'label' => 'API'],
            ['value' => 'consulting', 'label' => 'Consulting'],
            ['value' => 'other', 'label' => 'Autre'],
        ];
    }

    /**
     * Get technologies for filter.
     */
    public function getTechnologiesProperty(): array
    {
        $technologies = Project::whereNotNull('technologies')
            ->get()
            ->flatMap(fn($project) => $project->technologies ?? [])
            ->unique()
            ->sort()
            ->values();

        return $technologies->toArray();
    }

    /**
     * Like a project.
     */
    public function likeProject(int $projectId): void
    {
        $project = Project::findOrFail($projectId);
        // Logic to toggle like would go here
        $this->dispatch('projectLiked', projectId: $projectId);
    }

    /**
     * Reset pagination when filters change.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTechFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        return view('livewire.portfolio.portfolio-gallery', [
            'stats' => $this->stats,
            'projects' => $this->projects,
            'categories' => $this->categories,
            'technologies' => $this->technologies,
        ]);
    }
}
