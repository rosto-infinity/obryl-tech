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

// Routes publiques (sans authentification)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes publiques pour consultation (visiteurs)
Route::get('projects', function() { return view('projects'); })->name('projects.list');
// Route::get('projects/{project}', function() { return view('project-detail'); })->name('projects.detail');
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');
Route::get('projects/filter', ProjectFilter::class)->name('projects.filter');

Route::get('developers', function() { return view('developers'); })->name('developers.list');
Route::get('developers/search', DeveloperSearch::class)->name('developers.search');
Route::get('developers/filter', DeveloperFilter::class)->name('developers.filter');
Route::get('developers/{developer}', function() { return view('developer-profile'); })->name('developers.profile');

Route::get('portfolio', function() { return view('portfolio'); })->name('portfolio.gallery');
Route::get('portfolio/project-card', ProjectCard::class)->name('portfolio.project-card');
Route::get('portfolio/project-like', ProjectLike::class)->name('portfolio.project-like');

// Routes protégées (nécessitent une authentification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
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
    
    // Routes de progression (nécessitent authentification)
    Route::get('projects/{project}/progress', ProjectProgress::class)->name('projects.progress');
    
    // Routes des commissions (nécessitent authentification)
    Route::get('commissions', CommissionDashboard::class)->name('commissions.dashboard');
    Route::get('commissions/history', CommissionHistory::class)->name('commissions.history');
});
