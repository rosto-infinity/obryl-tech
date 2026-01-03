<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::factory()->completed()->create();
        
        return [
            'project_id' => $project->id,
            'client_id' => $project->client_id,
            'developer_id' => User::factory()->developer(),
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->paragraph(),
            'status' => 'approved',
            'criteria' => json_encode([
                'quality' => $this->faker->numberBetween(3, 5),
                'communication' => $this->faker->numberBetween(3, 5),
                'timeliness' => $this->faker->numberBetween(3, 5),
                'professionalism' => $this->faker->numberBetween(3, 5),
            ]),
        ];
    }

    public function excellent(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 5,
            'comment' => $this->faker->sentence() . ' Excellent travail !',
            'criteria' => json_encode([
                'quality' => 5,
                'communication' => 5,
                'timeliness' => 5,
                'professionalism' => 5,
            ]),
        ]);
    }

    public function good(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 4,
            'comment' => $this->faker->sentence() . ' Bon travail.',
            'criteria' => json_encode([
                'quality' => 4,
                'communication' => 4,
                'timeliness' => 4,
                'professionalism' => 4,
            ]),
        ]);
    }

    public function average(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 3,
            'comment' => $this->faker->sentence() . ' Travail acceptable.',
            'criteria' => json_encode([
                'quality' => 3,
                'communication' => 3,
                'timeliness' => 3,
                'professionalism' => 3,
            ]),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}
