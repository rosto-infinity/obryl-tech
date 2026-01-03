<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Commission\CommissionDashboard;
use App\Livewire\Commission\CommissionHistory;
use App\Livewire\Developer\DeveloperList;
use App\Livewire\Developer\DeveloperProfile;
use App\Livewire\Developer\DeveloperSearch;
use App\Livewire\Developer\DeveloperFilter;
use App\Livewire\Project\ProjectList;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Project\ProjectFilter;
use App\Livewire\Project\ProjectProgress;
use App\Livewire\Portfolio\PortfolioGallery;
use App\Livewire\Portfolio\ProjectCard;
use App\Livewire\Portfolio\ProjectLike;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    // Portfolio routes
    Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');
    Route::get('portfolio/project-card', ProjectCard::class)->name('portfolio.project-card');
    Route::get('portfolio/project-like', ProjectLike::class)->name('portfolio.project-like');

    // Project routes
    Route::get('projects', ProjectList::class)->name('projects.list');
    Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');
    Route::get('projects/filter', ProjectFilter::class)->name('projects.filter');
    Route::get('projects/{project}/progress', ProjectProgress::class)->name('projects.progress');

    // Commission routes
    Route::get('commissions', CommissionDashboard::class)->name('commissions.dashboard');
    Route::get('commissions/history', CommissionHistory::class)->name('commissions.history');

    // Developer routes  
    Route::get('developers', DeveloperList::class)->name('developers.list');
    Route::get('developers/search', DeveloperSearch::class)->name('developers.search');
    Route::get('developers/filter', DeveloperFilter::class)->name('developers.filter');
    Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');

    // Project routes
    Route::get('projects', ProjectList::class)->name('projects.list');
    Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');
    Route::get('projects/filter', ProjectFilter::class)->name('projects.filter');
    Route::get('projects/{project}/progress', ProjectProgress::class)->name('projects.progress');

    // Portfolio routes
    Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');
    Route::get('portfolio/project-card', ProjectCard::class)->name('portfolio.project-card');
    Route::get('portfolio/project-like', ProjectLike::class)->name('portfolio.project-like');
});
