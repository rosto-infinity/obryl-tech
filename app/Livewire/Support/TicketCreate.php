<?php

declare(strict_types=1);

namespace App\Livewire\Support;

use App\Enums\Support\TicketPriority;
use App\Enums\Support\TicketStatus;
use App\Models\SupportTicket;
use Livewire\Component;

class TicketCreate extends Component
{
    public $title = '';

    public $description = '';

    public $project_id = null;

    public $category = 'general';

    public $severity = 'minor';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|min:20',
        'project_id' => 'nullable|exists:projects,id',
        'category' => 'required|string',
        'severity' => 'required|string',
    ];

    public function save()
    {
        $this->validate();

        $ticket = SupportTicket::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'project_id' => $this->project_id ?: null,
            'category' => $this->category,
            'severity' => $this->severity,
            'status' => TicketStatus::OPEN,
            'priority' => TicketPriority::MEDIUM,
        ]);

        session()->flash('success', 'Votre ticket a été créé avec succès.');

        return redirect()->route('support.chat', $ticket->id);
    }

    public function render()
    {
        return view('livewire.support.ticket-create', [
            'projects' => auth()->user()->projects()->get(),
        ]);
    }
}
