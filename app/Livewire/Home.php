<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Article;
use App\Models\Project;
use App\Models\Review;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component
{
    #[Layout('components.layouts.public')]
    public function render()
    {
        $recentArticles = Article::published()->recent(3)->get();
        $latestProjects = Project::where('is_published', true)->latest()->take(3)->get();
        $featuredDevelopers = User::whereHas('profile')->take(4)->get();
        $topReviews = Review::where('status', 'approved')
            ->where('rating', '>=', 4)
            ->with(['client', 'project', 'developer'])
            ->orderByDesc('rating')
            ->take(3)
            ->get();

        return view('livewire.home', [
            'recentArticles' => $recentArticles,
            'latestProjects' => $latestProjects,
            'featuredDevelopers' => $featuredDevelopers,
            'topReviews' => $topReviews,
        ]);
    }
}
