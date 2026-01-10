<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Project;
use App\Models\Commission;
use App\Services\ProjectAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class WorkloadController extends Controller
{
    protected $assignmentService;

    public function __construct(ProjectAssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    /**
     * Display the workload dashboard.
     */
    public function dashboard()
    {
        return view('livewire.admin.workload-dashboard');
    }

    /**
     * Handle workload overload by redistributing projects.
     */
    public function handleOverload(Request $request): JsonResponse
    {
        try {
            $redistributedProjects = $this->assignmentService->handleOverload();
            
            return response()->json([
                'success' => true,
                'message' => count($redistributedProjects) . ' projet(s) réassigné(s) avec succès',
                'data' => $redistributedProjects,
                'statistics' => $this->assignmentService->getDevelopersByWorkloadStatus(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la gestion de la surcharge: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get workload statistics for API.
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $statistics = [
                'total_developers' => User::where('user_type', 'developer')->count(),
                'available' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'available'))->count(),
                'busy' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'busy'))->count(),
                'overloaded' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'overloaded'))->count(),
                'avg_workload' => \DB::table('workload_management')->avg('workload_percentage'),
                'total_projects' => Project::count(),
                'pending_assignments' => Project::whereNull('developer_id')->whereIn('status', ['pending', 'accepted'])->count(),
                'monthly_commissions' => Commission::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->where('status', 'paid')
                    ->sum('amount'),
            ];

            return response()->json([
                'success' => true,
                'data' => $statistics,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get available developers for project assignment.
     */
    public function getAvailableDevelopers(Request $request): JsonResponse
    {
        try {
            $projectType = $request->get('project_type');
            $limit = $request->get('limit', 10);
            
            $query = User::where('user_type', 'developer')
                ->whereHas('profile', function($query) use ($projectType) {
                    if ($projectType) {
                        $query->whereJsonContains('specializations', [$projectType]);
                    }
                })
                ->whereHas('workload', function($query) {
                    $query->where('availability_status', 'available');
                })
                ->with(['profile', 'workload']);

            $developers = $query->take($limit)->get();

            return response()->json([
                'success' => true,
                'data' => $developers->map(function ($developer) {
                    return [
                        'id' => $developer->id,
                        'name' => $developer->name,
                        'email' => $developer->email,
                        'specializations' => $developer->profile->specializations ?? [],
                        'skill_level' => $developer->profile->skill_level ?? 'unknown',
                        'workload' => $developer->getCurrentWorkload(),
                        'commission_rate' => $developer->getCommissionRate(),
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des développeurs: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Manually assign a project to a developer.
     */
    public function assignProject(Request $request, Project $project): JsonResponse
    {
        try {
            $developerId = $request->get('developer_id');
            $developer = User::find($developerId);

            if (!$developer || !$developer->isDeveloper()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Développeur non valide',
                ], 400);
            }

            // Assign project
            $project->update(['developer_id' => $developer->id]);
            
            // Update workload
            if ($developer->workload) {
                $developer->workload->calculateWorkload();
            }

            return response()->json([
                'success' => true,
                'message' => "Projet {$project->title} assigné à {$developer->name}",
                'data' => [
                    'project_id' => $project->id,
                    'developer_id' => $developer->id,
                    'developer_name' => $developer->name,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'assignation: ' . $e->getMessage(),
            ], 500);
        }
    }
}
