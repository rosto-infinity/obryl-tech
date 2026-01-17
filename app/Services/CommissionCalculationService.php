<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

class CommissionCalculationService
{
    /**
     * Calculate project commission for a developer.
     */
    public function calculateProjectCommission(Project $project, User $developer): array
    {
        $baseAmount = $project->final_cost ?? $project->budget ?? 0;

        if ($baseAmount <= 0) {
            return $this->getEmptyCommission();
        }

        // Get commission rate based on developer level
        $commissionRate = $this->getCommissionRate($developer);

        // Calculate bonuses
        $complexityBonus = $this->calculateComplexityBonus($project);
        $deliveryBonus = $this->calculateDeliveryBonus($project);

        // Calculate totals
        $commissionAmount = ($baseAmount * $commissionRate / 100) + $complexityBonus + $deliveryBonus;
        $netAmount = $baseAmount - $commissionAmount;

        return [
            'base_amount' => $baseAmount,
            'commission_rate' => $commissionRate,
            'complexity_bonus' => $complexityBonus,
            'delivery_bonus' => $deliveryBonus,
            'total_commission' => $commissionAmount,
            'net_amount' => $netAmount,
            'currency' => $project->currency,
            'breakdown' => [
                'base_commission' => ($baseAmount * $commissionRate / 100),
                'complexity_bonus' => $complexityBonus,
                'delivery_bonus' => $deliveryBonus,
            ],
        ];
    }

    /**
     * Get commission rate based on developer skill level.
     */
    private function getCommissionRate(User $developer): float
    {
        if (! $developer->profile) {
            return 10.0; // Default rate
        }

        return match ($developer->profile->skill_level) {
            'junior' => 8.0,
            'intermediate' => 10.0,
            'senior' => 12.0,
            'expert' => 15.0,
            default => 10.0
        };
    }

    /**
     * Calculate complexity bonus based on project type and priority.
     */
    private function calculateComplexityBonus(Project $project): float
    {
        $bonus = 0;

        // Bonus based on project type
        $bonus += match ($project->type) {
            'mobile' => 5000,
            'desktop' => 3000,
            'api' => 7000,
            'consulting' => 10000,
            'web' => 0,
            default => 0
        };

        // Bonus based on project priority
        $bonus += match ($project->priority) {
            'critical' => 15000,
            'high' => 8000,
            'medium' => 3000,
            'low' => 0,
            default => 0
        };

        return $bonus;
    }

    /**
     * Calculate delivery bonus for early completion.
     */
    private function calculateDeliveryBonus(Project $project): float
    {
        if (! $project->completed_at || ! $project->deadline) {
            return 0;
        }

        $deadline = Carbon::parse($project->deadline);
        $completion = Carbon::parse($project->completed_at);

        if ($completion->lte($deadline)) {
            $daysEarly = $deadline->diffInDays($completion);
            $bonusPerDay = 2000;
            $maxBonus = 10000;

            return min($daysEarly * $bonusPerDay, $maxBonus);
        }

        return 0;
    }

    /**
     * Get empty commission structure.
     */
    private function getEmptyCommission(): array
    {
        return [
            'base_amount' => 0,
            'commission_rate' => 10.0,
            'complexity_bonus' => 0,
            'delivery_bonus' => 0,
            'total_commission' => 0,
            'net_amount' => 0,
            'currency' => 'XAF',
            'breakdown' => [
                'base_commission' => 0,
                'complexity_bonus' => 0,
                'delivery_bonus' => 0,
            ],
        ];
    }

    /**
     * Calculate commission for external developer.
     */
    public function calculateExternalCommission(Project $project, User $externalDeveloper, ?float $customRate = null): array
    {
        $baseAmount = $project->final_cost ?? $project->budget ?? 0;

        if ($baseAmount <= 0) {
            return $this->getEmptyCommission();
        }

        // Use custom rate if provided, otherwise use standard rate
        $commissionRate = $customRate ?? $this->getCommissionRate($externalDeveloper);

        // For external developers, we might not include all bonuses
        $complexityBonus = $this->calculateComplexityBonus($project) * 0.5; // 50% of complexity bonus
        $deliveryBonus = $this->calculateDeliveryBonus($project) * 0.7; // 70% of delivery bonus

        $commissionAmount = ($baseAmount * $commissionRate / 100) + $complexityBonus + $deliveryBonus;

        return [
            'base_amount' => $baseAmount,
            'commission_rate' => $commissionRate,
            'complexity_bonus' => $complexityBonus,
            'delivery_bonus' => $deliveryBonus,
            'total_commission' => $commissionAmount,
            'net_amount' => $baseAmount - $commissionAmount,
            'currency' => $project->currency,
            'is_external' => true,
            'breakdown' => [
                'base_commission' => ($baseAmount * $commissionRate / 100),
                'complexity_bonus' => $complexityBonus,
                'delivery_bonus' => $deliveryBonus,
            ],
        ];
    }

    /**
     * Generate commission breakdown for display.
     */
    public function formatCommissionBreakdown(array $commission): array
    {
        return [
            [
                'label' => 'Commission de base',
                'amount' => $commission['breakdown']['base_commission'],
                'percentage' => $commission['commission_rate'],
                'formatted' => number_format($commission['breakdown']['base_commission'], 0, ',', ' ').' '.$commission['currency'],
            ],
            [
                'label' => 'Bonus de complexité',
                'amount' => $commission['complexity_bonus'],
                'percentage' => null,
                'formatted' => number_format($commission['complexity_bonus'], 0, ',', ' ').' '.$commission['currency'],
            ],
            [
                'label' => 'Bonus de livraison',
                'amount' => $commission['delivery_bonus'],
                'percentage' => null,
                'formatted' => number_format($commission['delivery_bonus'], 0, ',', ' ').' '.$commission['currency'],
            ],
            [
                'label' => 'Total Commission',
                'amount' => $commission['total_commission'],
                'percentage' => null,
                'formatted' => number_format($commission['total_commission'], 0, ',', ' ').' '.$commission['currency'],
                'is_total' => true,
            ],
        ];
    }
}
