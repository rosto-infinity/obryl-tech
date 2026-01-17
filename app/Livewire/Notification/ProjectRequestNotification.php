<?php

declare(strict_types=1);

namespace App\Livewire\Notification;

use App\Enums\Project\ProjectStatus;
use App\Models\Project;
use Livewire\Component;

class ProjectRequestNotification extends Component
{
    public $count;

    protected $listeners = [
        'refreshProjectRequests' => '$refresh',
        'projectAccepted' => '$refresh',
        'projectRejected' => '$refresh',
    ];

    public function mount(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->count = Project::where('status', ProjectStatus::REQUESTED->value)->count();
    }

    public function render()
    {
        return view('livewire.notification.project-request-notification');
    }
}
