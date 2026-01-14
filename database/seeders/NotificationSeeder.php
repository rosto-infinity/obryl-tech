<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        $this->command->info("🔔 Création des notifications...");

        // Créer 5-10 notifs par user
        foreach ($users as $user) {
            Notification::factory()
                ->count(rand(3, 8))
                ->create([
                    'user_id' => $user->id,
                ]);
        }
        
        $this->command->info('✅ ' . Notification::count() . ' Notifications créées !');
    }
}
