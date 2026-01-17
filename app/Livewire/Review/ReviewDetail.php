<?php

declare(strict_types=1);

namespace App\Livewire\Review;

use App\Models\Review;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Détail de l\'avis')]
class ReviewDetail extends Component
{
    public Review $review;

    public function mount(Review $review): void
    {
        $this->review = $review;

        // Authorization check
        $user = auth()->user();
        if ($user->isClient() && $review->client_id !== $user->id) {
            abort(403);
        }
        if ($user->isDeveloper() && $review->developer_id !== $user->id) {
            abort(403);
        }
    }

    public function approve(): void
    {
        $this->authorize('update', $this->review);
        $this->review->approve(auth()->id());
        $this->dispatch('review-updated');
    }

    public function reject(): void
    {
        $this->authorize('update', $this->review);
        $this->review->reject(auth()->id());
        $this->dispatch('review-updated');
    }

    public function render()
    {
        return view('livewire.review.review-detail');
    }
}
