<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProjectReassigned extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Project $project,
        public User $previousDeveloper,
        public User $newDeveloper
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = match($notifiable->user_type) {
            'admin' => "Le projet {$this->project->title} a été réassigné de {$this->previousDeveloper->name} à {$this->newDeveloper->name}",
            'developer' => $notifiable->id === $this->previousDeveloper->id 
                ? "Le projet {$this->project->title} vous a été retiré et réassigné à {$this->newDeveloper->name}"
                : "Le projet {$this->project->title} vous a été assigné",
            default => "Le projet {$this->project->title} a été réassigné"
        };

        return (new MailMessage)
            ->subject('Réassignation de Projet - Obryl Tech')
            ->markdown('emails.project-reassigned', [
                'project' => $this->project,
                'previousDeveloper' => $this->previousDeveloper,
                'newDeveloper' => $this->newDeveloper,
                'notifiable' => $notifiable,
                'message' => $message,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = match($notifiable->user_type) {
            'admin' => "Le projet {$this->project->title} a été réassigné de {$this->previousDeveloper->name} à {$this->newDeveloper->name}",
            'developer' => $notifiable->id === $this->previousDeveloper->id 
                ? "Le projet {$this->project->title} vous a été retiré et réassigné à {$this->newDeveloper->name}"
                : "Le projet {$this->project->title} vous a été assigné",
            default => "Le projet {$this->project->title} a été réassigné"
        };

        return [
            'title' => 'Réassignation de Projet',
            'message' => $message,
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'previous_developer_id' => $this->previousDeveloper->id,
            'previous_developer_name' => $this->previousDeveloper->name,
            'new_developer_id' => $this->newDeveloper->id,
            'new_developer_name' => $this->newDeveloper->name,
            'type' => 'project_reassignment',
            'priority' => 'high',
        ];
    }
}
