<?php

declare(strict_types=1);

namespace App\Livewire\Developer;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class DeveloperProfile extends Component
{
    public User $developer;
    public Collection $projects;
    public Collection $reviews;

    public function mount(User $developer): void
    {
        $this->developer = $developer->load(['profile']);
        $this->projects = $developer->projects()->with('client')->latest()->limit(6)->get();
        $this->reviews = $developer->reviews()->with('client')->latest()->limit(5)->get();
    }

    /**
     * Get developer statistics.
     */
    public function getStatsProperty(): array
    {
        return [
            'completed_projects' => $this->developer->projects()->where('status', 'completed')->count(),
            'total_earnings' => $this->developer->commissions()->where('status', 'paid')->sum('amount'),
            'average_rating' => $this->developer->reviews()->avg('rating') ?: 0,
            'total_reviews' => $this->developer->reviews()->count(),
        ];
    }

    /**
     * Get skills with levels.
     */
    public function getSkillsWithLevelsProperty(): array
    {
        $skills = $this->developer->profile?->skills ?? '[]';
        
        // Handle JSON string
        if (is_string($skills)) {
            $skills = json_decode($skills, true) ?? [];
        }
        
        // Ensure it's an array
        if (!is_array($skills)) {
            $skills = [];
        }
        
        $skillLevels = [];
        
        foreach ($skills as $skill) {
            // Ensure skill name is a string
            $skillName = is_array($skill) ? json_encode($skill) : (string) $skill;
            
            $skillLevels[] = [
                'name' => $skillName,
                'level' => rand(3, 5), // Simulated skill level
            ];
        }
        
        return $skillLevels;
    }

    public function render(): View
    {
        return view('livewire.developer.developer-profile', [
            'stats' => $this->stats,
            'skillsWithLevels' => $this->skillsWithLevels,
        ]);
    }
}
