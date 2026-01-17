<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Support\TicketCategory;
use App\Enums\Support\TicketPriority;
use App\Enums\Support\TicketSeverity;
use App\Enums\Support\TicketStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'assigned_to' => User::factory(),
            'project_id' => Project::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(TicketStatus::cases()),
            'priority' => fake()->randomElement(TicketPriority::cases()),
            'category' => fake()->randomElement(TicketCategory::cases()),
            'severity' => fake()->randomElement(TicketSeverity::cases()),
            'messages' => [],
            'attachments' => [],
            'resolved_at' => fake()->boolean(30) ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }
}
