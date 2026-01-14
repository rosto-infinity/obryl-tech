<?php

namespace App\Livewire\Public;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Avis Clients - Témoignages')]
class Reviews extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.public.reviews', [
            'reviews' => Review::approved()->latest()->paginate(9),
            'stats' => [
                'count' => Review::approved()->count(),
                'avg' => Review::approved()->avg('rating'),
            ]
        ])->layout('components.layouts.public');
    }
}
