<?php

declare(strict_types=1);

namespace App\Livewire\Review;

use App\Enums\ReviewStatus;
use App\Models\Review;
use App\Services\ReviewService;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = 'all';

    public string $ratingFilter = 'all';

    public string $sortBy = 'created_at';

    public string $sortDirection = 'desc';

    public int $perPage = 12;

    protected ReviewService $reviewService;

    public function boot(ReviewService $reviewService): void
    {
        $this->reviewService = $reviewService;
    }

    public function mount(): void
    {
        // Permission check can be added here if needed
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingRatingFilter(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function getReviewsProperty()
    {
        $user = auth()->user();
        $query = Review::query()
            ->with(['project', 'client', 'developer']);

        // Role-based Scoping
        if ($user->isClient()) {
            $query->where('client_id', $user->id);
        } elseif ($user->isDeveloper()) {
            $query->where('developer_id', $user->id);
        }
        // Admins see everything by default

        $query->when($this->search, function ($query): void {
            $query->where(function ($q): void {
                $q->where('comment', 'like', '%'.$this->search.'%')
                    ->orWhereHas('project', function ($pq): void {
                        $pq->where('title', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('client', function ($cq): void {
                        $cq->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('developer', function ($dq): void {
                        $dq->where('name', 'like', '%'.$this->search.'%');
                    });
            });
        })
            ->when($this->statusFilter !== 'all', function ($query): void {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->ratingFilter !== 'all', function ($query): void {
                $query->where('rating', '>=', (int) $this->ratingFilter)
                    ->where('rating', '<', (int) $this->ratingFilter + 1);
            });

        // Apply sorting
        match ($this->sortBy) {
            'rating' => $query->orderBy('rating', $this->sortDirection),
            'created_at' => $query->orderBy('created_at', $this->sortDirection),
            'updated_at' => $query->orderBy('updated_at', $this->sortDirection),
            default => $query->orderBy('created_at', 'desc'),
        };

        return $query->paginate($this->perPage);
    }

    public function approveReview(int $reviewId): void
    {
        $review = Review::findOrFail($reviewId);

        if (! auth()->user()->can('updateReview')) {
            abort(403, 'Vous n\'avez pas la permission d\'approuver les avis.');
        }

        $this->reviewService->updateReviewStatus($review, ReviewStatus::APPROVED);

        $this->dispatch('reviewApproved', reviewId: $reviewId);
        $this->dispatch('notify', message: 'Avis approuvé avec succès', type: 'success');
    }

    public function rejectReview(int $reviewId): void
    {
        $review = Review::findOrFail($reviewId);

        if (! auth()->user()->can('updateReview')) {
            abort(403, 'Vous n\'avez pas la permission de rejeter les avis.');
        }

        $this->reviewService->updateReviewStatus($review, ReviewStatus::REJECTED);

        $this->dispatch('reviewRejected', reviewId: $reviewId);
        $this->dispatch('notify', message: 'Avis rejeté', type: 'warning');
    }

    public function deleteReview(int $reviewId): void
    {
        $review = Review::findOrFail($reviewId);

        if (! auth()->user()->can('deleteReview')) {
            abort(403, 'Vous n\'avez pas la permission de supprimer les avis.');
        }

        // Check ownership
        if (auth()->user()->isClient() && $review->client_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres avis.');
        }

        $review->delete();

        $this->dispatch('reviewDeleted', reviewId: $reviewId);
        $this->dispatch('notify', message: 'Avis supprimé avec succès', type: 'success');
    }

    public function getReviewStatsProperty(): array
    {
        $reviews = Review::all();

        return [
            'total' => $reviews->count(),
            'approved' => $reviews->filter(fn ($r) => $r->status === ReviewStatus::APPROVED)->count(),
            'pending' => $reviews->filter(fn ($r) => $r->status === ReviewStatus::PENDING)->count(),
            'rejected' => $reviews->filter(fn ($r) => $r->status === ReviewStatus::REJECTED)->count(),
            'average_rating' => $reviews->filter(fn ($r) => $r->status === ReviewStatus::APPROVED)->avg('rating'),
        ];
    }

    public function getRatingDistributionProperty(): array
    {
        $approvedReviews = Review::where('status', ReviewStatus::APPROVED)->get();

        return [
            5 => $approvedReviews->where('rating', '>=', 4.5)->count(),
            4 => $approvedReviews->where('rating', '>=', 3.5)->where('rating', '<', 4.5)->count(),
            3 => $approvedReviews->where('rating', '>=', 2.5)->where('rating', '<', 3.5)->count(),
            2 => $approvedReviews->where('rating', '>=', 1.5)->where('rating', '<', 2.5)->count(),
            1 => $approvedReviews->where('rating', '<', 1.5)->count(),
        ];
    }

    public function render()
    {
        return view('livewire.review.review-list', [
            'reviews' => $this->reviews,
            'stats' => $this->reviewStats,
            'ratingDistribution' => $this->ratingDistribution,
        ]);
    }
}
