<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use App\Models\ProjectReference;
use App\Enums\Project\ProjectStatus;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectRequests extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $typeFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'typeFilter' => ['except' => 'all'],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    

    protected function getProjects()
    {
        return Project::with(['client', 'references'])
            ->where('status', ProjectStatus::REQUESTED->value)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter !== 'all', function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    protected function getStats()
    {
        return [
            'total' => Project::where('status', ProjectStatus::REQUESTED->value)->count(),
            'today' => Project::where('status', ProjectStatus::REQUESTED->value)
                           ->whereDate('created_at', today())->count(),
            'this_week' => Project::where('status', ProjectStatus::REQUESTED->value)
                               ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'with_references' => Project::where('status', ProjectStatus::REQUESTED->value)
                                       ->whereHas('references')->count(),
        ];
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function acceptProject($projectId)
    {
        $project = Project::find($projectId);
        if ($project) {
            $project->update(['status' => ProjectStatus::ACCEPTED->value]);
            $this->dispatch('projectAccepted', $projectId);
            $this->dispatch('refreshProjectRequests');
        }
    }

    public function rejectProject($projectId)
    {
        $project = Project::find($projectId);
        if ($project) {
            $project->update(['status' => ProjectStatus::CANCELLED->value]);
            $this->dispatch('projectRejected', $projectId);
            $this->dispatch('refreshProjectRequests');
        }
    }


    public function render()
    {
        $projects = $this->getProjects();
        
        return view('livewire.admin.project-requests', [
            'projects' => $projects,
            'stats' => $this->getStats()
        ]);
    }
}
