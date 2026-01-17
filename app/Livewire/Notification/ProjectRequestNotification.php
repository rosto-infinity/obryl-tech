<?php

namespace App\Livewire\Notification;

use Livewire\Component;
use App\Models\Project;
use App\Enums\Project\ProjectStatus;

class ProjectRequestNotification extends Component
{
    public $count;
    
    protected $listeners = [
        'refreshProjectRequests' => '$refresh',
        'projectAccepted' => '$refresh',
        'projectRejected' => '$refresh',
    ];
    
    public function mount()
    {
        $this->refresh();
    }
    
    public function refresh()
    {
        $this->count = Project::where('status', ProjectStatus::REQUESTED->value)->count();
    }
    
    public function render()
    {
        return view('livewire.notification.project-request-notification');
    }
}
