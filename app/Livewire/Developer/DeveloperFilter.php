<?php

declare(strict_types=1);

namespace App\Livewire\Developer;

use App\Enums\Developer\Availability;
use App\Enums\Developer\Specialization;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;

class DeveloperFilter extends Component
{
    use WithPagination;

    public $search = '';

    public $specialization = '';

    public $availability = '';

    public $minHourlyRate = '';

    public $maxHourlyRate = '';

    public $minExperience = '';

    public $skills = '';

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'specialization' => ['except' => ''],
        'availability' => ['except' => ''],
        'minHourlyRate' => ['except' => ''],
        'maxHourlyRate' => ['except' => ''],
        'minExperience' => ['except' => ''],
        'skills' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 12],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSpecialization(): void
    {
        $this->resetPage();
    }

    public function updatingAvailability(): void
    {
        $this->resetPage();
    }

    public function updatingMinHourlyRate(): void
    {
        $this->resetPage();
    }

    public function updatingMaxHourlyRate(): void
    {
        $this->resetPage();
    }

    public function updatingMinExperience(): void
    {
        $this->resetPage();
    }

    public function updatingSkills(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'specialization',
            'availability',
            'minHourlyRate',
            'maxHourlyRate',
            'minExperience',
            'skills',
            'sortBy',
            'sortDirection',
            'perPage',
        ]);
        $this->resetPage();
    }

    public function getFilteredDevelopers()
    {
        return Profile::with('user')
            ->whereHas('user', function ($query): void {
                $query->where('user_type', 'developer');
            })
            ->when($this->search, function ($query): void {
                $query->where(function ($q): void {
                    $q->where('bio', 'like', '%'.$this->search.'%')
                        ->orWhere('company', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', function ($userQuery): void {
                            $userQuery->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->when($this->specialization, function ($query): void {
                $query->where('specialization', $this->specialization);
            })
            ->when($this->availability, function ($query): void {
                $query->where('availability', $this->availability);
            })
            ->when($this->minHourlyRate, function ($query): void {
                $query->where('hourly_rate', '>=', $this->minHourlyRate);
            })
            ->when($this->maxHourlyRate, function ($query): void {
                $query->where('hourly_rate', '<=', $this->maxHourlyRate);
            })
            ->when($this->minExperience, function ($query): void {
                $query->where('years_experience', '>=', $this->minExperience);
            })
            ->when($this->skills, function ($query): void {
                $skills = array_map('trim', explode(',', $this->skills));
                foreach ($skills as $skill) {
                    if (! empty($skill)) {
                        $query->whereJsonContains('skills', $skill);
                    }
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.developer.developer-filter', [
            'developers' => $this->getFilteredDevelopers(),
            'specializations' => Specialization::cases(),
            'availabilities' => Availability::cases(),
        ]);
    }
}
