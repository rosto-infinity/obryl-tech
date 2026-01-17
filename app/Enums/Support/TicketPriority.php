<?php

declare(strict_types=1);

namespace App\Enums\Support;

enum TicketPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Basse',
            self::MEDIUM => 'Moyenne',
            self::HIGH => 'Haute',
            self::URGENT => 'Urgente',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW => 'success',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger',
            self::URGENT => 'dark',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::LOW => '🟢',
            self::MEDIUM => '🟡',
            self::HIGH => '🔴',
            self::URGENT => '⚠️',
        };
    }
}
