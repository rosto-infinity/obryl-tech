<?php

declare(strict_types=1);

namespace App\Livewire\Developer;

use App\Models\User;
use App\Models\Profile;
use App\Enums\Developer\Specialization;
use App\Enums\Developer\Availability;
use App\Enums\Developer\SkillLevel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DeveloperList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $specializationFilter = 'all';
    public string $availabilityFilter = 'all';
    public string $skillLevelFilter = 'all';
    public string $sortBy = 'name';
    public string $sortDirection = 'asc';
    public int $perPage = 12;
    public bool $showVerifiedOnly = false;

    /**
     * Reset pagination when filters change.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSpecializationFilter(): void
    {
        $this->resetPage();
    }

    public function updatedAvailabilityFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSkillLevelFilter(): void
    {
        $this->resetPage();
    }

    public function updatedShowVerifiedOnly(): void
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
            $this->sortDirection = 'asc';
        }
        
        $this->resetPage();
    }

    /**
     * Get filtered developers.
     */
    public function getDevelopersProperty(): LengthAwarePaginator
    {
        $query = User::query()
            ->where('user_type', 'developer')
            ->where('status', 'active')
            ->with(['profile'])
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhereHas('profile', function ($profileQuery) use ($search) {
                          $profileQuery->where('bio', 'like', '%' . $search . '%');
                      });
                });
            })
            ->when($this->specializationFilter !== 'all', function ($query) {
                $query->whereHas('profile', function ($profileQuery) {
                    $profileQuery->where('specialization', $this->specializationFilter);
                });
            })
            ->when($this->availabilityFilter !== 'all', function ($query) {
                $query->whereHas('profile', function ($profileQuery) {
                    $profileQuery->where('availability', $this->availabilityFilter);
                });
            })
            ->when($this->skillLevelFilter !== 'all', function ($query) {
                // This would need to be implemented based on how skill level is determined
                // For now, we'll skip this filter
            })
            ->when($this->showVerifiedOnly, function ($query) {
                $query->whereHas('profile', function ($profileQuery) {
                    $profileQuery->where('is_verified', true);
                });
            });

        // Apply sorting
        match ($this->sortBy) {
            'name' => $query->orderBy('name', $this->sortDirection),
            'rating' => $query->orderByDesc('profile.average_rating'),
            'experience' => $query->orderByDesc('profile.years_experience'),
            'projects' => $query->orderByDesc('profile.completed_projects_count'),
            'created_at' => $query->orderBy('created_at', $this->sortDirection),
            default => $query->orderBy('name', 'asc')
        };

        return $query->paginate($this->perPage);
    }

    /**
     * Get specializations for filter.
     */
    public function getSpecializationsProperty(): array
    {
        return collect(Specialization::cases())
            ->map(fn($case) => ['value' => $case->value, 'label' => $case->label()])
            ->toArray();
    }

    /**
     * Get availability options for filter.
     */
    public function getAvailabilityOptionsProperty(): array
    {
        return collect(Availability::cases())
            ->map(fn($case) => ['value' => $case->value, 'label' => $case->label()])
            ->toArray();
    }

    /**
     * Get statistics.
     */
    public function getStatsProperty(): array
    {
        return [
            'total' => User::where('user_type', 'developer')->where('status', 'active')->count(),
            'verified' => User::where('user_type', 'developer')
                ->where('status', 'active')
                ->whereHas('profile', fn($q) => $q->where('is_verified', true))
                ->count(),
            'available' => User::where('user_type', 'developer')
                ->where('status', 'active')
                ->whereHas('profile', fn($q) => $q->where('availability', 'available'))
                ->count(),
        ];
    }
    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.developer.developer-list', [
            'developers' => $this->developers,
            'specializations' => $this->specializations,
            'availabilityOptions' => $this->availabilityOptions,
            'stats' => $this->stats,
        ])->extends('components.layouts.public')->section('content');
    }
}
