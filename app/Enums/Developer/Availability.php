<?php

declare(strict_types=1);

namespace App\Enums\Developer;

enum Availability: string
{
    case AVAILABLE = 'available';
    case BUSY = 'busy';
    case UNAVAILABLE = 'unavailable';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Disponible',
            self::BUSY => 'Occupé',
            self::UNAVAILABLE => 'Indisponible',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::AVAILABLE => 'success',
            self::BUSY => 'warning',
            self::UNAVAILABLE => 'danger',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::AVAILABLE => '🟢',
            self::BUSY => '🟡',
            self::UNAVAILABLE => '🔴',
        };
    }
}
