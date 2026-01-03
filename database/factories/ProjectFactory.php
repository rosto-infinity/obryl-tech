<?php

namespace Database\Factories;

use App\Enums\Project\MilestoneStatus;
use App\Enums\Project\ProjectPriority;
use App\Enums\Project\ProjectStatus;
use App\Enums\Project\ProjectType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        
        return [
            'code' => 'PRJ-' . $this->faker->unique()->numerify('######'),
            'title' => $title,
            'description' => $this->faker->paragraph(5),
            'slug' => Str::slug($title),
            'client_id' => User::factory()->client(),
            'type' => $this->faker->randomElement(ProjectType::cases())->value,
            'status' => ProjectStatus::PENDING->value,
            'priority' => $this->faker->randomElement(ProjectPriority::cases())->value,
            'budget' => $this->faker->numberBetween(50000, 500000),
            'final_cost' => null,
            'currency' => 'XAF',
            'deadline' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
            'started_at' => null,
            'completed_at' => null,
            'progress_percentage' => 0,
            'technologies' => json_encode([
                'Laravel',
                'Vue.js',
                'MySQL',
                'Docker',
                'Redis',
            ]),
            'attachments' => json_encode([]),
            'milestones' => json_encode([
                [
                    'id' => 1,
                    'title' => 'Design & Architecture',
                    'due_date' => now()->addDays(15)->format('Y-m-d'),
                    'status' => MilestoneStatus::PENDING->value,
                    'percentage_weight' => 20,
                ],
                [
                    'id' => 2,
                    'title' => 'Développement Backend',
                    'due_date' => now()->addDays(45)->format('Y-m-d'),
                    'status' => MilestoneStatus::PENDING->value,
                    'percentage_weight' => 40,
                ],
                [
                    'id' => 3,
                    'title' => 'Développement Frontend',
                    'due_date' => now()->addDays(60)->format('Y-m-d'),
                    'status' => MilestoneStatus::PENDING->value,
                    'percentage_weight' => 30,
                ],
                [
                    'id' => 4,
                    'title' => 'Tests & Déploiement',
                    'due_date' => now()->addDays(75)->format('Y-m-d'),
                    'status' => MilestoneStatus::PENDING->value,
                    'percentage_weight' => 10,
                ],
            ]),
            'tasks' => json_encode([]),
            'collaborators' => json_encode([]),
            'is_published' => false,
            'is_featured' => false,
            'likes_count' => 0,
            'views_count' => 0,
            'reviews_count' => 0,
            'average_rating' => 0,
            'admin_notes' => null,
            'cancellation_reason' => null,
            'featured_image' => $this->faker->optional()->imageUrl(800, 400, 'business'),
            'gallery_images' => json_encode([]),
        ];
    }

    /**
     * Créer un projet en cours
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProjectStatus::IN_PROGRESS->value,
            'started_at' => now()->subDays(15),
            'progress_percentage' => $this->faker->numberBetween(20, 80),
        ]);
    }

    /**
     * Créer un projet complété
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProjectStatus::COMPLETED->value,
            'started_at' => now()->subDays(90),
            'completed_at' => now()->subDays(5),
            'progress_percentage' => 100,
            'final_cost' => $this->faker->numberBetween(50000, 500000),
        ]);
    }

    /**
     * Créer un projet publié
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProjectStatus::PUBLISHED->value,
            'is_published' => true,
            'started_at' => now()->subDays(90),
            'completed_at' => now()->subDays(5),
            'progress_percentage' => 100,
            'likes_count' => $this->faker->numberBetween(0, 100),
            'views_count' => $this->faker->numberBetween(0, 1000),
            'reviews_count' => $this->faker->numberBetween(0, 20),
            'average_rating' => $this->faker->randomFloat(2, 3.5, 5),
        ]);
    }

    /**
     * Créer un projet en vedette
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_published' => true,
        ]);
    }

    /**
     * Créer un projet web
     */
    public function web(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => ProjectType::WEB->value,
        ]);
    }

    /**
     * Créer un projet mobile
     */
    public function mobile(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => ProjectType::MOBILE->value,
        ]);
    }

    /**
     * Créer un projet avec collaborateurs
     */
    public function withCollaborators(): static
    {
        return $this->state(fn (array $attributes) => [
            'collaborators' => json_encode([
                [
                    'user_id' => User::factory()->developer()->create()->id,
                    'role' => 'lead',
                    'percentage' => 50,
                    'status' => 'accepted',
                ],
                [
                    'user_id' => User::factory()->developer()->create()->id,
                    'role' => 'developer',
                    'percentage' => 30,
                    'status' => 'accepted',
                ],
                [
                    'user_id' => User::factory()->developer()->create()->id,
                    'role' => 'designer',
                    'percentage' => 20,
                    'status' => 'accepted',
                ],
            ]),
        ]);
    }
}
