<?php

declare(strict_types=1);

namespace App\Enums\Developer;

enum VerificationLevel: string
{
    case UNVERIFIED = 'unverified';
    case BASIC = 'basic';
    case ADVANCED = 'advanced';
    case CERTIFIED = 'certified';

    public function label(): string
    {
        return match ($this) {
            self::UNVERIFIED => 'Non vérifié',
            self::BASIC => 'Vérification basique',
            self::ADVANCED => 'Vérification avancée',
            self::CERTIFIED => 'Certifié',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::UNVERIFIED => '❌',
            self::BASIC => '✅',
            self::ADVANCED => '⭐',
            self::CERTIFIED => '🏆',
        };
    }
}
