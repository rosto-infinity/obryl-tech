<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkloadAlert extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $developer,
        public array $workload
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
        return (new MailMessage)
            ->subject('Alerte de Charge de Travail - Obryl Tech')
            ->markdown('emails.workload-alert', [
                'developer' => $this->developer,
                'workload' => $this->workload,
                'notifiable' => $notifiable,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Alerte de Charge de Travail',
            'message' => "{$this->developer->name} est surchargé ({$this->workload['workload_percentage']}%)",
            'developer_id' => $this->developer->id,
            'developer_name' => $this->developer->name,
            'workload_percentage' => $this->workload['workload_percentage'],
            'active_projects' => $this->workload['active_projects'],
            'max_capacity' => $this->workload['max_capacity'],
            'availability_status' => $this->workload['availability_status'],
            'type' => 'workload_alert',
            'priority' => 'high',
        ];
    }
}
