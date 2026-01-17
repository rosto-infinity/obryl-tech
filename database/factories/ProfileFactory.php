<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Developer\Availability;
use App\Enums\Developer\Specialization;
use App\Enums\Developer\VerificationLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company' => $this->faker->optional()->company(),
            'country' => $this->faker->countryCode(),
            'bio' => $this->faker->paragraph(),
            'specialization' => $this->faker->randomElement(Specialization::cases())->value,
            'years_experience' => $this->faker->numberBetween(0, 20),
            'hourly_rate' => $this->faker->numberBetween(5000, 50000),
            'availability' => Availability::AVAILABLE->value,
            'github_url' => $this->faker->optional()->url(),
            'linkedin_url' => $this->faker->optional()->url(),
            'cv_path' => $this->faker->optional()->filePath(),
            'is_verified' => false,
            'verification_level' => VerificationLevel::UNVERIFIED->value,
            'verified_at' => null,
            'verified_by' => null,
            'total_earned' => 0,
            'completed_projects_count' => 0,
            'average_rating' => 0,
            'total_reviews_count' => 0,
            'skills' => json_encode([
                ['name' => 'Laravel', 'level' => 'expert'],
                ['name' => 'Vue.js', 'level' => 'senior'],
                ['name' => 'MySQL', 'level' => 'senior'],
                ['name' => 'Docker', 'level' => 'intermediate'],
            ]),
            'certifications' => json_encode([
                ['title' => 'Laravel Certified Developer', 'year' => 2024],
                ['title' => 'AWS Solutions Architect', 'year' => 2023],
            ]),
            'experiences' => json_encode([
                [
                    'company' => 'Tech Company',
                    'position' => 'Senior Developer',
                    'years' => '2020-2024',
                    'description' => 'Développement web full-stack',
                ],
            ]),
            'social_links' => json_encode([
                'twitter' => 'https://twitter.com/user',
                'portfolio' => 'https://portfolio.com',
            ]),
        ];
    }

    /**
     * Créer un profil de développeur vérifié
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => true,
            'verification_level' => VerificationLevel::CERTIFIED->value,
            'verified_at' => now(),
            'verified_by' => User::factory()->admin(),
        ]);
    }

    /**
     * Créer un profil avec expérience
     */
    public function experienced(): static
    {
        return $this->state(fn (array $attributes) => [
            'years_experience' => $this->faker->numberBetween(10, 20),
            'average_rating' => $this->faker->randomFloat(2, 4, 5),
            'total_reviews_count' => $this->faker->numberBetween(10, 50),
            'completed_projects_count' => $this->faker->numberBetween(20, 100),
        ]);
    }

    /**
     * Créer un profil junior
     */
    public function junior(): static
    {
        return $this->state(fn (array $attributes) => [
            'years_experience' => $this->faker->numberBetween(0, 2),
            'hourly_rate' => $this->faker->numberBetween(2000, 10000),
        ]);
    }

    /**
     * Créer un profil senior
     */
    public function senior(): static
    {
        return $this->state(fn (array $attributes) => [
            'years_experience' => $this->faker->numberBetween(8, 15),
            'hourly_rate' => $this->faker->numberBetween(20000, 50000),
            'average_rating' => $this->faker->randomFloat(2, 4.5, 5),
        ]);
    }

    /**
     * Créer un profil disponible
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'availability' => Availability::AVAILABLE->value,
        ]);
    }

    /**
     * Créer un profil occupé
     */
    public function busy(): static
    {
        return $this->state(fn (array $attributes) => [
            'availability' => Availability::BUSY->value,
        ]);
    }
}
