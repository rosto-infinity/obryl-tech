<?php

declare(strict_types=1);

namespace App\Livewire\Support;

use App\Models\SupportTicket;
use Livewire\Component;

class TicketChat extends Component
{
    public SupportTicket $ticket;

    public $message = '';

    protected $rules = [
        'message' => 'required|string|min:1',
    ];

    public function mount(SupportTicket $ticket): void
    {
        $this->ticket = $ticket;
    }

    public function sendMessage(): void
    {
        $this->validate();

        $messages = $this->ticket->messages ?? [];
        $messages[] = [
            'id' => uniqid(),
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'message' => $this->message,
            'created_at' => now()->toIso8601String(),
            'is_admin' => auth()->user()->isAdmin(),
        ];

        $this->ticket->update(['messages' => $messages]);
        $this->message = '';

        $this->dispatch('message-sent');
    }

    public function render()
    {
        return view('livewire.support.ticket-chat');
    }
}
