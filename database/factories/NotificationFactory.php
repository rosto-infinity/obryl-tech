<?php

namespace Database\Factories;

use App\Enums\Notification\NotificationChannel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['project_assigned', 'milestone_completed', 'commission_paid', 'message_received']),
            'title' => fake()->sentence(),
            'message' => fake()->paragraph(),
            'data' => json_encode(['url' => fake()->url()]),
            'channel' => fake()->randomElement(NotificationChannel::cases()),
            'read_at' => fake()->boolean(50) ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'sent_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
