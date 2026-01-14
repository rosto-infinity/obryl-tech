<?php

namespace App\Livewire\Notification;

use Livewire\Component;

use Livewire\WithPagination;

class NotificationCenter extends Component
{
    use WithPagination;

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->update(['read_at' => now()]);
            $this->dispatch('notifications-read');
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        $this->dispatch('notifications-read');
    }

    public function deleteNotification($id)
    {
        auth()->user()->notifications()->find($id)?->delete();
    }

    public function render()
    {
        return view('livewire.notification.notification-center', [
            'notifications' => auth()->user()->notifications()
                ->latest()
                ->paginate(15)
        ]);
    }
}
