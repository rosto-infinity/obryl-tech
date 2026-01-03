<?php

namespace Database\Factories;

use App\Enums\Commission\CommissionStatus;
use App\Enums\Commission\CommissionType;
use App\Models\Commission;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommissionFactory extends Factory
{
    protected $model = Commission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::factory()->completed()->create();
        $amount = $this->faker->numberBetween(10000, 100000);
        
        return [
            'project_id' => $project->id,
            'developer_id' => User::factory()->developer(),
            'amount' => $amount,
            'currency' => 'XAF',
            'percentage' => $this->faker->numberBetween(10, 50),
            'status' => CommissionStatus::PENDING->value,
            'type' => $this->faker->randomElement(CommissionType::cases())->value,
            'description' => $this->faker->sentence(),
            'breakdown' => json_encode([
                'base' => $amount * 0.8,
                'bonus' => $amount * 0.15,
                'tax' => $amount * 0.05,
            ]),
            'approved_at' => null,
            'paid_at' => null,
            'approved_by' => null,
            'payment_details' => json_encode([
                'method' => 'bank_transfer',
                'account' => '****' . $this->faker->numerify('####'),
            ]),
        ];
    }

    /**
     * Créer une commission approuvée
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => CommissionStatus::APPROVED->value,
            'approved_at' => now()->subDays(5),
            'approved_by' => User::factory()->admin(),
        ]);
    }

    /**
     * Créer une commission payée
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => CommissionStatus::PAID->value,
            'approved_at' => now()->subDays(10),
            'paid_at' => now()->subDays(3),
            'approved_by' => User::factory()->admin(),
        ]);
    }

    /**
     * Créer une commission annulée
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => CommissionStatus::CANCELLED->value,
        ]);
    }

    /**
     * Créer une commission remboursée
     */
    public function refunded(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => CommissionStatus::REFUNDED->value,
            'paid_at' => now()->subDays(20),
        ]);
    }

    /**
     * Créer une commission de complément de projet
     */
    public function projectCompletion(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => CommissionType::PROJECT_COMPLETION->value,
        ]);
    }

    /**
     * Créer une commission de jalon
     */
    public function milestone(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => CommissionType::MILESTONE->value,
        ]);
    }

    /**
     * Créer une commission de parrainage
     */
    public function referral(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => CommissionType::REFERRAL->value,
            'amount' => $this->faker->numberBetween(5000, 20000),
        ]);
    }

    /**
     * Créer une commission bonus
     */
    public function bonus(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => CommissionType::BONUS->value,
            'amount' => $this->faker->numberBetween(10000, 50000),
        ]);
    }
}
