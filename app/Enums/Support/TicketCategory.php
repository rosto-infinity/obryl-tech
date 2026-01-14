<?php

namespace App\Enums\Support;

enum TicketCategory: string
{
    case BILLING = 'billing';
    case TECHNICAL = 'technical';
    case GENERAL = 'general';
    case ABUSE = 'abuse';
    case FEATURE_REQUEST = 'feature_request';

    public function label(): string
    {
        return match($this) {
            self::BILLING => 'Facturation',
            self::TECHNICAL => 'Technique',
            self::GENERAL => 'Général',
            self::ABUSE => 'Abus',
            self::FEATURE_REQUEST => 'Demande de fonctionnalité',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::BILLING => '💳',
            self::TECHNICAL => '🔧',
            self::GENERAL => '❓',
            self::ABUSE => '⛔',
            self::FEATURE_REQUEST => '💡',
        };
    }
}
