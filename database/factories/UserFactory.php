<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Auth\UserStatus;
use App\Enums\Auth\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'avatar' => $this->faker->optional()->imageUrl(200, 200, 'people'),
            'user_type' => $this->faker->randomElement([
                UserType::CLIENT->value,
                UserType::DEVELOPER->value,
            ]),
            'status' => UserStatus::ACTIVE->value,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,  // ✅ FIXÉ : null au lieu de Str::random
            'two_factor_recovery_codes' => null,  // ✅ FIXÉ : null au lieu de Str::random
            'two_factor_confirmed_at' => null,  // ✅ FIXÉ : null au lieu de now()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model does not have two-factor authentication configured.
     */
    public function withoutTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
    }

    /**
     * Créer un utilisateur client
     */
    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_type' => UserType::CLIENT->value,
        ]);
    }

    /**
     * Créer un utilisateur développeur
     */
    public function developer(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_type' => UserType::DEVELOPER->value,
        ]);
    }

    /**
     * Créer un administrateur
     * ✅ FIXÉ : Génère un email unique au lieu de forcer 'adminrosto@gmail.com'
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_type' => UserType::ADMIN->value,
            'email' => fake()->unique()->safeEmail(),  // ✅ Email unique généré
        ]);
    }

    /**
     * Créer un utilisateur actif
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::ACTIVE->value,
        ]);
    }

    /**
     * Créer un utilisateur inactif
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::INACTIVE->value,
        ]);
    }

    /**
     * Créer un utilisateur suspendu
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::SUSPENDED->value,
        ]);
    }
}
