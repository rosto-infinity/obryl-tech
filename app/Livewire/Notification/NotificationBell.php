<?php

namespace App\Livewire\Notification;

use Livewire\Component;

class NotificationBell extends Component
{
    public int $unreadCount = 0;
    public $notifications = [];

    protected $listeners = ['notification-received' => 'loadUnreadCount', 'notifications-read' => 'loadUnreadCount'];

    public function mount()
    {
        $this->loadUnreadCount();
    }

    public function loadUnreadCount()
    {
        $this->unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
        $this->notifications = auth()->user()->notifications()->latest()->take(5)->get();
    }

    public function markAsRead($id)
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
