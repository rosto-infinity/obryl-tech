<?php

declare(strict_types=1);

namespace App\Livewire\Notification;

use Livewire\Component;

class NotificationBell extends Component
{
    public int $unreadCount = 0;

    public $notifications = [];

    public string $mode = 'dropdown'; // 'dropdown' or 'link'

    protected $listeners = ['notification-received' => 'loadUnreadCount', 'notifications-read' => 'loadUnreadCount'];

    public function mount(): void
    {
        $this->loadUnreadCount();
    }

    public function loadUnreadCount(): void
    {
        $this->unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
        $this->notifications = auth()->user()->notifications()->latest()->take(5)->get();
    }

    public function markAsRead($id): void
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->update(['read_at' => now()]);
            $this->loadUnreadCount();
            $this->dispatch('notifications-read');
        }
    }

    public function render()
    {
        return view('livewire.notification.notification-bell');
    }
}
