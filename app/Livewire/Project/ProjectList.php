<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\User;
use App\Enums\Project\ProjectStatus;
use App\Enums\Project\ProjectType;
use App\Enums\Project\ProjectPriority;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all';
    public string $typeFilter = 'all';
    public string $priorityFilter = 'all';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 12;
    public bool $showFeaturedOnly = false;
    public bool $showPublishedOnly = true;

    /**
     * Reset pagination when filters change.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatedPriorityFilter(): void
    {
        $this->resetPage();
    }

    public function updatedShowFeaturedOnly(): void
    {
        $this->resetPage();
    }

    public function updatedShowPublishedOnly(): void
    {
        $this->resetPage();
    }

    /**
     * Sort the results.
     */
    public function sortBy(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'desc';
        }
        
        $this->resetPage();
    }

    /**
     * Get filtered projects.
     */
    public function getProjectsProperty(): LengthAwarePaginator
    {
        $query = Project::query()
            ->with(['client', 'reviews', 'commissions'])
            ->when($this->showPublishedOnly, fn($q) => $q->where('is_published', true))
            ->when($this->showFeaturedOnly, fn($q) => $q->where('is_featured', true))
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('code', 'like', '%' . $search . '%');
                });
            })
            ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->typeFilter !== 'all', fn($q) => $q->where('type', $this->typeFilter))
            ->when($this->priorityFilter !== 'all', fn($q) => $q->where('priority', $this->priorityFilter));

        // Apply sorting
        match ($this->sortBy) {
            'title' => $query->orderBy('title', $this->sortDirection),
            'budget' => $query->orderBy('budget', $this->sortDirection),
            'deadline' => $query->orderBy('deadline', $this->sortDirection),
            'created_at' => $query->orderBy('created_at', $this->sortDirection),
            'updated_at' => $query->orderBy('updated_at', $this->sortDirection),
            default => $query->orderBy('created_at', 'desc')
        };

        return $query->paginate($this->perPage);
    }

    /**
     * Get project types for filter.
     */
    public function getProjectTypesProperty(): array
    {
        return collect(ProjectType::cases())
            ->map(fn($case) => ['value' => $case->value, 'label' => $case->label()])
            ->toArray();
    }

    /**
     * Get project statuses for filter.
     */
    public function getProjectStatusesProperty(): array
    {
        return collect(ProjectStatus::cases())
            ->map(fn($case) => ['value' => $case->value, 'label' => $case->label()])
            ->toArray();
    }

    /**
     * Get priorities for filter.
     */
    public function getPrioritiesProperty(): array
    {
        return collect(ProjectPriority::cases())
            ->map(fn($case) => ['value' => $case->value, 'label' => $case->label()])
            ->toArray();
    }

    /**
     * Get statistics.
     */
    public function getStatsProperty(): array
    {
        return [
            'total' => Project::count(),
            'published' => Project::where('is_published', true)->count(),
            'featured' => Project::where('is_featured', true)->count(),
            'completed' => Project::where('status', ProjectStatus::COMPLETED->value)->count(),
            'in_progress' => Project::where('status', ProjectStatus::IN_PROGRESS->value)->count(),
        ];
    }
    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.project.project-list', [
            'projects' => $this->projects,
            'projectTypes' => $this->projectTypes,
            'projectStatuses' => $this->projectStatuses,
            'priorities' => $this->priorities,
            'stats' => $this->stats,
        ]);
    }
}
