<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Seeder;

class SupportTicketSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $admins = User::where('user_type', 'admin')->get();
        $projects = Project::all();

        if ($users->isEmpty()) {
            $this->command->info('⚠️ Aucun utilisateur trouvé, skipping tickets...');

            return;
        }

        $this->command->info('🎫 Création des tickets de support...');

        // Créer 20 tickets
        foreach (range(1, 20) as $i) {
            $user = $users->random();
            $project = $projects->isNotEmpty() && fake()->boolean(70) ? $projects->random() : null;
            $assigned = $admins->isNotEmpty() && fake()->boolean(60) ? $admins->random() : null;

            SupportTicket::factory()->create([
                'user_id' => $user->id,
                'project_id' => $project?->id,
                'assigned_to' => $assigned?->id,
            ]);
        }

        $this->command->info('✅ 20 Tickets créés !');
    }
}
