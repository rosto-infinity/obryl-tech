<?php

namespace App\Enums\Support;

enum TicketSeverity: string
{
    case MINOR = 'minor';
    case MAJOR = 'major';
    case CRITICAL = 'critical';

    public function label(): string
    {
        return match($this) {
            self::MINOR => 'Mineure',
            self::MAJOR => 'Majeure',
            self::CRITICAL => 'Critique',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::MINOR => 'info',
            self::MAJOR => 'warning',
            self::CRITICAL => 'danger',
        };
    }
}
