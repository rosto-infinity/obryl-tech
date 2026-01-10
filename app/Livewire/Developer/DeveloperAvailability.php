<?php

namespace App\Livewire\Developer;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class DeveloperAvailability extends Component
{
    use WithPagination;

    public $search = '';
    public $specialization = '';
    public $skillLevel = '';
    public $availability = '';

    protected $queryString = [
        'search',
        'specialization',
        'skillLevel',
        'availability',
    ];

    public function render()
    {
        $developers = User::where('user_type', 'developer')
            ->whereHas('profile', function($query) {
                $query->where('availability', 'available');
            })
            ->when($this->search, function($query) {
                $query->where(function($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->specialization, function($query) {
                $query->whereHas('profile', function($subQuery) {
                    $subQuery->whereJsonContains('specializations', [$this->specialization]);
                });
            })
            ->when($this->skillLevel, function($query) {
                $query->whereHas('profile', function($subQuery) {
                    $subQuery->where('skill_level', $this->skillLevel);
                });
            })
            ->with(['profile', 'workload'])
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.developer.developer-availability', [
            'developers' => $developers,
            'specializations' => $this->getSpecializations(),
            'skillLevels' => $this->getSkillLevels(),
        ]);
    }

    private function getSpecializations(): array
    {
        return [
            'web' => 'Développement Web',
            'mobile' => 'Développement Mobile',
            'desktop' => 'Développement Desktop',
            'api' => 'Développement API',
            'consulting' => 'Consulting',
            'fullstack' => 'Full Stack',
            'backend' => 'Backend',
            'frontend' => 'Frontend',
            'devops' => 'DevOps',
        ];
    }

    private function getSkillLevels(): array
    {
        return [
            'junior' => 'Junior',
            'intermediate' => 'Intermédiaire',
            'senior' => 'Senior',
            'expert' => 'Expert',
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSpecialization(): void
    {
        $this->resetPage();
    }

    public function updatedSkillLevel(): void
    {
        $this->resetPage();
    }

    public function updatedAvailability(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'specialization', 'skillLevel', 'availability']);
        $this->resetPage();
    }
}
