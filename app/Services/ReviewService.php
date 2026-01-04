<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Review;
use App\Models\User;
use App\Enums\ReviewStatus;

class ReviewService
{
    /**
     * Create a new review.
     */
    public function createReview(array $data): Review
    {
        $review = Review::create([
            'project_id' => $data['project_id'],
            'client_id' => $data['client_id'],
            'developer_id' => $data['developer_id'],
            'rating' => $data['rating'] ?? 5,
            'comment' => $data['comment'] ?? null,
            'criteria' => $data['criteria'] ?? null,
            'status' => $data['status'] ?? ReviewStatus::APPROVED->value,
        ]);

        // Update developer's average rating
        $this->updateDeveloperRating($review->developer_id);

        return $review;
    }

    /**
     * Update an existing review.
     */
    public function updateReview(Review $review, array $data): Review
    {
        $review->update($data);

        // Update developer's average rating
        $this->updateDeveloperRating($review->developer_id);

        return $review;
    }

    /**
     * Update developer's average rating.
     */
    public function updateDeveloperRating(int $developerId): void
    {
        $developer = User::find($developerId);
        if (!$developer || !$developer->profile) {
            return;
        }

        $approvedReviews = Review::where('developer_id', $developerId)
            ->where('status', ReviewStatus::APPROVED->value)
            ->get();

        if ($approvedReviews->isEmpty()) {
            $developer->profile->update(['average_rating' => null]);
            return;
        }

        $averageRating = $approvedReviews->avg('rating');
        $developer->profile->update(['average_rating' => round($averageRating, 2)]);
    }

    /**
     * Get review statistics for a developer.
     */
    public function getDeveloperStats(int $developerId): array
    {
        $reviews = Review::where('developer_id', $developerId)->get();

        return [
            'total_reviews' => $reviews->count(),
            'approved_reviews' => $reviews->where('status', ReviewStatus::APPROVED->value)->count(),
            'pending_reviews' => $reviews->where('status', ReviewStatus::PENDING->value)->count(),
            'rejected_reviews' => $reviews->where('status', ReviewStatus::REJECTED->value)->count(),
            'average_rating' => $reviews->where('status', ReviewStatus::APPROVED->value)->avg('rating'),
        ];
    }

    /**
     * Check if user can review a project.
     */
    public function canUserReviewProject(User $user, $project): bool
    {
        // Only clients can review projects
        if (!$user->isClient()) {
            return false;
        }

        // User must be the project client
        if ($project->client_id !== $user->id) {
            return false;
        }

        // Project must be completed
        if ($project->status !== 'completed') {
            return false;
        }

        // Check if user hasn't already reviewed this project
        $existingReview = Review::where('project_id', $project->id)
            ->where('client_id', $user->id)
            ->first();

        return $existingReview === null;
    }

    /**
     * Get pending reviews for admin approval.
     */
    public function getPendingReviews()
    {
        return Review::where('status', ReviewStatus::PENDING->value)
            ->with(['project', 'client', 'developer'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Approve or reject a review.
     */
    public function updateReviewStatus(Review $review, ReviewStatus $status): Review
    {
        $review->update(['status' => $status->value]);

        // Update developer rating if status changed to/from approved
        if ($status === ReviewStatus::APPROVED || $review->status === ReviewStatus::APPROVED->value) {
            $this->updateDeveloperRating($review->developer_id);
        }

        return $review;
    }
}
