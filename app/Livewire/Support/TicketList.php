<?php

namespace App\Livewire\Support;

use Livewire\Component;

use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    protected $queryString = ['search', 'status'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = auth()->user()->tickets()
            ->with(['project'])
            ->latest();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return view('livewire.support.ticket-list', [
            'tickets' => $query->paginate(10)
        ]);
    }
}
