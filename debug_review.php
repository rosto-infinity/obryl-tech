<?php

use App\Models\User;
use App\Models\Project;
use App\Services\ReviewService;
use App\Enums\Project\ProjectStatus;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = new ReviewService();

// Find a project that should be reviewable (Published or Completed)
$project = Project::whereIn('status', [ProjectStatus::PUBLISHED, ProjectStatus::COMPLETED])
    ->whereDoesntHave('reviews') // No reviews yet
    ->first();

if (!$project) {
    echo "No suitable project found for testing.\n";
    exit;
}

echo "Testing Project: {$project->title} (ID: {$project->id}, Status: {$project->status->value})\n";
echo "Client ID needs to be: {$project->client_id}\n";

$client = User::find($project->client_id);
if (!$client) {
    echo "Client not found.\n";
    exit;
}

echo "Testing with User: {$client->name} (ID: {$client->id})\n";
echo "User Roles: " . implode(', ', $client->getRoleNames()->toArray()) . "\n";
echo "User isClient(): " . ($client->isClient() ? 'YES' : 'NO') . "\n";

$canReview = $service->canUserReviewProject($client, $project);

echo "Can Review? " . ($canReview ? "YES" : "NO") . "\n";

if (!$canReview) {
    echo "--- Debugging Failure ---\n";
    if (!$client->isClient()) echo "- User is not Client type.\n";
    if ($project->client_id !== $client->id) echo "- User is not project owner.\n";
    if (!in_array($project->status, [ProjectStatus::COMPLETED, ProjectStatus::PUBLISHED])) echo "- Project status invalid.\n";
    
    $existing = \App\Models\Review::where('project_id', $project->id)->where('client_id', $client->id)->first();
    if ($existing) echo "- Review already exists (ID: {$existing->id}).\n";
}
