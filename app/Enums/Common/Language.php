<?php

namespace App\Enums\Common;

enum Language: string
{
    case FRENCH = 'fr';
    case ENGLISH = 'en';
    case SPANISH = 'es';

    public function label(): string
    {
        return match($this) {
            self::FRENCH => 'Français',
            self::ENGLISH => 'English',
            self::SPANISH => 'Español',
        };
    }

    public function flag(): string
    {
        return match($this) {
            self::FRENCH => '🇫🇷',
            self::ENGLISH => '🇬🇧',
            self::SPANISH => '🇪🇸',
        };
    }
}
