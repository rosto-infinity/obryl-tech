<?php

declare(strict_types=1);

namespace App\Enums\Auth;

enum Country: string
{
    case CAMEROON = 'CM';
    case FRANCE = 'FR';
    case USA = 'US';
    case CANADA = 'CA';
    case BELGIUM = 'BE';
    case SWITZERLAND = 'CH';
    case IVORY_COAST = 'CI';
    case SENEGAL = 'SN';
    case GABON = 'GA';
    case CONGO = 'CG';

    public function label(): string
    {
        return match ($this) {
            self::CAMEROON => 'Cameroun',
            self::FRANCE => 'France',
            self::USA => 'États-Unis',
            self::CANADA => 'Canada',
            self::BELGIUM => 'Belgique',
            self::SWITZERLAND => 'Suisse',
            self::IVORY_COAST => 'Côte d\'Ivoire',
            self::SENEGAL => 'Sénégal',
            self::GABON => 'Gabon',
            self::CONGO => 'Congo',
        };
    }

    public function flag(): string
    {
        return match ($this) {
            self::CAMEROON => '🇨🇲',
            self::FRANCE => '🇫🇷',
            self::USA => '🇺🇸',
            self::CANADA => '🇨🇦',
            self::BELGIUM => '🇧🇪',
            self::SWITZERLAND => '🇨🇭',
            self::IVORY_COAST => '🇨🇮',
            self::SENEGAL => '🇸🇳',
            self::GABON => '🇬🇦',
            self::CONGO => '🇨🇬',
        };
    }
}
