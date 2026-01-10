<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Home extends Component
{
    #[Layout('components.layouts.public')]
    public function render()
    {
        $recentArticles = Article::published()->recent(3)->get();
        $latestProjects = Project::where('is_published', true)->latest()->take(3)->get();
        $featuredDevelopers = User::whereHas('profile')->take(4)->get();

        return view('livewire.home', [
            'recentArticles' => $recentArticles,
            'latestProjects' => $latestProjects,
            'featuredDevelopers' => $featuredDevelopers,
        ]);
    }
}
