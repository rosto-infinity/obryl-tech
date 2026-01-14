<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\User;
use App\Models\Review;

$user = User::find(1); // Assuming ID 1 is the super admin/current user
$review = Review::find(30); // The review ID from the stack trace

echo "User: " . $user->name . " (ID: " . $user->id . ")\n";
echo "Roles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";
echo "Has Permission 'Update:Review': " . ($user->can('Update:Review') ? 'YES' : 'NO') . "\n";
echo "Is Super Admin: " . ($user->hasRole('super_admin') ? 'YES' : 'NO') . "\n";
echo "Policy Check (update): " . ($user->can('update', $review) ? 'YES' : 'NO') . "\n";
