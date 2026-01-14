<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Project;
use App\Models\Commission;
use App\Services\ProjectAssignmentService;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WorkloadDashboard extends Component
{
    public $totalProjects;
    public $activeDevelopers;
    public $overloadedDevelopers;
    public $pendingAssignments;
    public $monthlyCommissions;
    public $workloadStats;
    public $recentReassignments;

    protected $listeners = ['refresh-dashboard' => '$refresh'];

    public function mount(): void
    {
        $this->loadStatistics();
    }

    public function loadStatistics(): void
    {
        $this->totalProjects = Project::count();
        
        $this->activeDevelopers = User::where('user_type', 'developer')
            ->whereHas('profile', fn($q) => $q->where('availability', 'available'))
            ->count();
            
        $this->overloadedDevelopers = User::whereHas('workload', 
            fn($q) => $q->where('availability_status', 'overloaded'))
            ->with(['workload', 'profile'])
            ->count();
            
        $this->pendingAssignments = Project::whereNull('developer_id')
            ->whereIn('status', ['pending', 'accepted'])
            ->count();
            
        $this->monthlyCommissions = Commission::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'paid')
            ->sum('amount');

        // Statistiques de charge
        $this->workloadStats = $this->getWorkloadStatistics();
        
        // Réassignations récentes
        $this->recentReassignments = $this->getRecentReassignments();
    }

    public function handleOverload(): void
    {
        try {
            $assignmentService = app(ProjectAssignmentService::class);
            $redistributedProjects = $assignmentService->handleOverload();
            
            if (!empty($redistributedProjects)) {
                Notification::make()
                    ->title('Gestion de la surcharge')
                    ->body(count($redistributedProjects) . ' projet(s) réassigné(s) avec succès')
                    ->success()
                    ->send();
                
                session()->flash('notification', [
                    'type' => 'success',
                    'message' => count($redistributedProjects) . ' projet(s) réassigné(s) avec succès'
                ]);

                $this->dispatch('notification', [
                    'type' => 'success',
                    'message' => count($redistributedProjects) . ' projet(s) réassigné(s) avec succès'
                ]);
                
                $this->loadStatistics();
            } else {
                Notification::make()
                    ->title('Gestion de la surcharge')
                    ->body('Aucun développeur surchargé trouvé')
                    ->info()
                    ->send();
                
                session()->flash('notification', [
                    'type' => 'info',
                    'message' => 'Aucun développeur surchargé trouvé'
                ]);

                $this->dispatch('notification', [
                    'type' => 'info',
                    'message' => 'Aucun développeur surchargé trouvé'
                ]);
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Erreur lors de la gestion de la surcharge')
                ->body($e->getMessage())
                ->danger()
                ->send();
                
            session()->flash('notification', [
                'type' => 'error',
                'message' => 'Erreur lors de la gestion de la surcharge: ' . $e->getMessage()
            ]);

            $this->dispatch('notification', [
                'type' => 'error',
                'message' => 'Erreur lors de la gestion de la surcharge: ' . $e->getMessage()
            ]);
        }
    }

    private function getWorkloadStatistics(): array
    {
        return [
            'total_developers' => User::where('user_type', 'developer')->count(),
            'available' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'available'))->count(),
            'busy' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'busy'))->count(),
            'overloaded' => User::whereHas('workload', fn($q) => $q->where('availability_status', 'overloaded'))->count(),
            'avg_workload' => DB::table('workload_management')->avg('workload_percentage'),
        ];
    }

    private function getRecentReassignments(): array
    {
        return DB::table('notifications')
            ->where('type', 'project_reassignment')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                $data = json_decode($notification->data, true);
                return [
                    'project_title' => $data['project_title'] ?? 'N/A',
                    'previous_developer' => $data['previous_developer_name'] ?? 'N/A',
                    'new_developer' => $data['new_developer_name'] ?? 'N/A',
                    'created_at' => $notification->created_at,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.workload-dashboard', [
            'totalProjects' => $this->totalProjects,
            'activeDevelopers' => $this->activeDevelopers,
            'overloadedDevelopers' => $this->overloadedDevelopers,
            'pendingAssignments' => $this->pendingAssignments,
            'monthlyCommissions' => $this->monthlyCommissions,
            'workloadStats' => $this->workloadStats,
            'recentReassignments' => $this->recentReassignments,
        ]);
    }
}
