<?php

declare(strict_types=1);

namespace App\Enums\Project;

enum MilestoneStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case DELAYED = 'delayed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::IN_PROGRESS => 'En cours',
            self::COMPLETED => 'Complété',
            self::DELAYED => 'Retardé',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::IN_PROGRESS => 'primary',
            self::COMPLETED => 'success',
            self::DELAYED => 'danger',
        };
    }
}
