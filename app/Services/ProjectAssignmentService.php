<?php

namespace App\Services;

use App\Models\User;
use App\Models\Project;
use App\Models\WorkloadManagement;
use App\Notifications\ProjectReassigned;
use App\Notifications\WorkloadAlert;

class ProjectAssignmentService
{
    /**
     * Assign a project to the best available developer.
     */
    public function assignProject(Project $project): ?User
    {
        // 1. Get available developers with their specializations
        $availableDevelopers = User::where('user_type', 'developer')
            ->whereHas('profile', function($query) {
                $query->where('availability', 'available');
            })
            ->with(['profile', 'workload'])
            ->get();

        if ($availableDevelopers->isEmpty()) {
            return null;
        }

        // 2. Filter by project type specialization
        $specializedDevelopers = $availableDevelopers
            ->filter(function($developer) use ($project) {
                if (!$developer->profile) return false;
                
                $specializations = $developer->profile->specializations ?? [];
                return in_array($project->type, $specializations);
            });

        // If no specialized developers, use all available
        $candidateDevelopers = $specializedDevelopers->isNotEmpty() 
            ? $specializedDevelopers 
            : $availableDevelopers;

        // 3. Sort by skill level and workload
        $sortedDevelopers = $candidateDevelopers
            ->sortByDesc(function($developer) {
                $skillScore = $this->getSkillScore($developer);
                $workloadScore = $this->getWorkloadScore($developer);
                return $skillScore - $workloadScore; // Higher skill, lower workload is better
            });

        return $sortedDevelopers->first();
    }

    /**
     * Handle overloaded developers by redistributing their projects.
     */
    public function handleOverload(): array
    {
        // Find overloaded developers
        $overloadedDevelopers = User::where('user_type', 'developer')
            ->whereHas('workload', function($query) {
                $query->where('availability_status', 'overloaded');
            })
            ->with(['projects', 'workload'])
            ->get();

        $redistributedProjects = [];

        foreach ($overloadedDevelopers as $developer) {
            $projectsToReassign = $this->getProjectsToReassign($developer);
            
            foreach ($projectsToReassign as $project) {
                $newDeveloper = $this->assignProject($project);
                
                if ($newDeveloper) {
                    // Reassign the project
                    $project->update(['developer_id' => $newDeveloper->id]);
                    
                    // Update workloads
                    $developer->workload->calculateWorkload();
                    $newDeveloper->workload->calculateWorkload();
                    
                    // Notify both developers
                    $this->notifyReassignment($project, $developer, $newDeveloper);
                    
                    $redistributedProjects[] = [
                        'project' => $project,
                        'from_developer' => $developer,
                        'to_developer' => $newDeveloper,
                    ];
                }
            }
        }

        return $redistributedProjects;
    }

    /**
     * Get projects that can be reassigned from an overloaded developer.
     */
    private function getProjectsToReassign(User $developer): \Illuminate\Support\Collection
    {
        return $developer->projects()
            ->whereIn('status', ['pending', 'accepted'])
            ->orderBy('priority', 'desc') // Reassign high priority projects first
            ->limit(2) // Maximum 2 projects to reassign
            ->get();
    }

    /**
     * Calculate skill score based on developer's level.
     */
    private function getSkillScore(User $developer): int
    {
        if (!$developer->profile) return 0;
        
        return match($developer->profile->skill_level) {
            'expert' => 100,
            'senior' => 80,
            'intermediate' => 60,
            'junior' => 40,
            default => 20
        };
    }

    /**
     * Calculate workload score (lower is better).
     */
    private function getWorkloadScore(User $developer): int
    {
        if (!$developer->workload) return 0;
        
        return (int) $developer->workload->workload_percentage;
    }

    /**
     * Send notifications about project reassignment.
     */
    private function notifyReassignment(Project $project, User $previousDeveloper, User $newDeveloper): void
    {
        // Notify previous developer
        $previousDeveloper->notify(new ProjectReassigned($project, $previousDeveloper, $newDeveloper));
        
        // Notify new developer
        $newDeveloper->notify(new ProjectReassigned($project, $previousDeveloper, $newDeveloper));
        
        // Notify admin
        $admins = User::where('user_type', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ProjectReassigned($project, $previousDeveloper, $newDeveloper));
        }
    }

    /**
     * Get developers by workload status.
     */
    public function getDevelopersByWorkloadStatus(): array
    {
        return [
            'available' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'available'))->count(),
            'busy' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'busy'))->count(),
            'overloaded' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'overloaded'))->count(),
        ];
    }

    /**
     * Update all developers' workload.
     */
    public function updateAllWorkloads(): void
    {
        User::where('user_type', 'developer')
            ->with('workload')
            ->chunk(100, function($developers) {
                foreach ($developers as $developer) {
                    if ($developer->workload) {
                        $developer->workload->calculateWorkload();
                    }
                }
            });
    }
}
