<?php

declare(strict_types=1);

namespace App\Livewire\Project;

use App\Enums\ReviewStatus;
use App\Models\Project;
use App\Services\ReviewService;
use Livewire\Component;

class ReviewForm extends Component
{
    public Project $project;

    public int $rating = 5;

    public string $comment = '';

    public array $criteria = [
        'communication' => 5,
        'qualité' => 5,
        'délais' => 5,
        'expertise' => 5,
    ];

    public bool $canReview = false;

    public bool $reviewSubmitted = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:10|max:1000',
        'criteria.*' => 'required|integer|min:1|max:5',
    ];

    public function mount(Project $project, ReviewService $reviewService): void
    {
        $this->project = $project;

        if (auth()->check()) {
            $this->canReview = $reviewService->canUserReviewProject(auth()->user(), $project);
        }
    }

    public function submit(ReviewService $reviewService): void
    {
        if (! $this->canReview) {
            return;
        }

        $this->validate();

        $reviewService->createReview([
            'project_id' => $this->project->id,
            'client_id' => auth()->id(),
            'developer_id' => $this->project->developer_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'criteria' => $this->criteria,
            'status' => ReviewStatus::PENDING->value,
        ]);

        $this->reviewSubmitted = true;
        $this->canReview = false;

        $this->dispatch('notify', message: 'Votre avis a été soumis et sera visible après modération.', type: 'success');
    }

    public function render()
    {
        return view('livewire.project.review-form');
    }
}
