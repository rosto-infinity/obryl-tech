<?php

use App\Models\User;

use App\Livewire\Home;
use App\Models\Project;
use Laravel\Fortify\Features;
use App\Livewire\Blog\ArticleList;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Blog\ArticleDetail;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Portfolio\ProjectCard;
use App\Livewire\Portfolio\ProjectLike;
use App\Livewire\Project\ProjectList;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Project\ProjectFilter;
use App\Livewire\Project\ProjectProgress;
use App\Livewire\Admin\WorkloadDashboard;
use App\Livewire\Developer\DeveloperList;
use App\Livewire\Developer\DeveloperFilter;
use App\Livewire\Developer\DeveloperSearch;
use App\Livewire\Developer\DeveloperProfile;
use App\Livewire\Portfolio\PortfolioGallery;
use App\Livewire\Commission\CommissionHistory;
use App\Livewire\Commission\CommissionDashboard;
use App\Http\Controllers\Admin\WorkloadController;
use App\Livewire\Admin\WorkloadDashboardWrapper;

// Routes publiques (sans authentification)
Route::get('/', Home::class)->name('home');

// Routes publiques pour consultation (visiteurs)
Route::get('projects', ProjectList::class)->name('projects.list');
Route::get('projects/{project}', ProjectDetail::class)->name('projects.detail');
Route::get('projects/by-id/{id}', function($id) { 
    $project = App\Models\Project::findOrFail($id); 
    return redirect()->route('projects.detail', $project->slug);
})->name('projects.detail.by-id');
Route::get('projects/filter', ProjectFilter::class)->name('projects.filter');

Route::get('developers', DeveloperList::class)->name('developers.list');
Route::get('developers/search', DeveloperSearch::class)->name('developers.search');
Route::get('developers/filter', DeveloperFilter::class)->name('developers.filter');
Route::get('developers/{developer}', DeveloperProfile::class)->name('developers.profile');

Route::get('portfolio', PortfolioGallery::class)->name('portfolio.gallery');
Route::get('portfolio/project-card', ProjectCard::class)->name('portfolio.project-card');
Route::get('portfolio/project-like', ProjectLike::class)->name('portfolio.project-like');

// Routes du Blog
Route::get('blog', ArticleList::class)->name('blog.index');
Route::get('blog/{article:slug}', ArticleDetail::class)->name('blog.show');

// Routes légales (publiques)
Route::view('legal/mentions-legales', 'legal.mentions-legales')->name('legal.mentions');
Route::view('legal/politique-confidentialite', 'legal.politique-confidentialite')->name('legal.privacy');
Route::view('legal/cgu', 'legal.cgu')->name('legal.cgu');

// Routes Publiques "Avis/Témoignages"
Route::get('avis', \App\Livewire\Public\Reviews::class)->name('reviews.public');

// Routes protégées (nécessitent une authentification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('notifications', \App\Livewire\Notification\NotificationCenter::class)->name('notifications');
    
    // Routes de Support
    Route::get('support', \App\Livewire\Support\TicketList::class)->name('support.list');
    Route::get('support/create', \App\Livewire\Support\TicketCreate::class)->name('support.create');
    Route::get('support/{ticket}', \App\Livewire\Support\TicketChat::class)->name('support.chat');
    
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
    
    // Avis (Dashboard) - Scoped pour Client/Dev/Admin
    Route::get('reviews', \App\Livewire\Review\ReviewList::class)->name('reviews.index');
    // Détail d'un avis (si existant)
    Route::get('reviews/{review}', \App\Livewire\Review\ReviewDetail::class)->name('reviews.show');
    
 
Route::middleware(['auth'])->prefix('workload')->group(function () {
    Route::get('/', WorkloadDashboardWrapper::class)->name('workload.dashboard');
    Route::post('/handle-overload', [WorkloadController::class, 'handleOverload'])->name('workload.handle-overload');
    Route::get('/statistics', [WorkloadController::class, 'getStatistics'])->name('workload.statistics');
    Route::get('/available-developers', [WorkloadController::class, 'getAvailableDevelopers'])->name('workload.available-developers');
    Route::post('/assign-project/{project}', [WorkloadController::class, 'assignProject'])->name('workload.assign-project');
});
});
