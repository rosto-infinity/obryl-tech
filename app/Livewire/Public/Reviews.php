<?php

declare(strict_types=1);

namespace App\Livewire\Public;

use App\Models\Review;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

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
            ],
        ])->layout('components.layouts.public');
    }
}
