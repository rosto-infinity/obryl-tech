<?php

use App\Models\User;
use App\Models\Project;
use Laravel\Fortify\Features;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Project\ProjectList;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Portfolio\ProjectCard;
use App\Livewire\Portfolio\ProjectLike;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Project\ProjectFilter;
use App\Livewire\Developer\DeveloperList;
use App\Livewire\Project\ProjectProgress;
use App\Livewire\Developer\DeveloperFilter;
use App\Livewire\Developer\DeveloperSearch;
use App\Livewire\Developer\DeveloperProfile;
use App\Livewire\Portfolio\PortfolioGallery;
use App\Livewire\Commission\CommissionHistory;
use App\Livewire\Commission\CommissionDashboard;

// Routes publiques (sans authentification)
Route::get('/', function () {
    return view('home');
})->name('home');

// Routes publiques pour consultation (visiteurs)
Route::get('projects', function() { return view('projects'); })->name('projects.list');
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');
Route::get('projects/by-id/{id}', function($id) { 
    $project = App\Models\Project::findOrFail($id); 
    return redirect()->route('projects.detail', $project->slug);
})->name('projects.detail.by-id');
Route::get('projects/filter', ProjectFilter::class)->name('projects.filter');

Route::get('developers', function() { return view('developers'); })->name('developers.list');
Route::get('developers/search', DeveloperSearch::class)->name('developers.search');
Route::get('developers/filter', DeveloperFilter::class)->name('developers.filter');
Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');

Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');
Route::get('portfolio/project-card', ProjectCard::class)->name('portfolio.project-card');
Route::get('portfolio/project-like', ProjectLike::class)->name('portfolio.project-like');

// Routes légales (publiques)
Route::view('legal/mentions-legales', 'legal.mentions-legales')->name('legal.mentions');
Route::view('legal/politique-confidentialite', 'legal.politique-confidentialite')->name('legal.privacy');
Route::view('legal/cgu', 'legal.cgu')->name('legal.cgu');

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
// Route pour servir les images privées
Route::get('/storage/private/{path}', function ($path) {
    $fullPath = storage_path('app/private/' . $path);

    if (!file_exists($fullPath)) {
        abort(404, 'Image non trouvée');
    }

    return response()->file($fullPath, [
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.private');

    //  Route::get('projects/{project}/upload-images', function (Project $project) {
    //     return view('livewire/project.upload-images', ['project' => $project]);
    // })->name('projects.upload-images');



    // Routes des commissions (nécessitent authentification)
    Route::get('commissions', CommissionDashboard::class)->name('commissions.dashboard');
    Route::get('commissions/history', CommissionHistory::class)->name('commissions.history');
});
