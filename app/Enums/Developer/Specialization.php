<?php

declare(strict_types=1);

namespace App\Enums\Developer;

enum Specialization: string
{
    case WEB = 'web';
    case MOBILE = 'mobile';
    case FULLSTACK = 'fullstack';
    case BACKEND = 'backend';
    case FRONTEND = 'frontend';
    case DEVOPS = 'devops';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::WEB => 'Web',
            self::MOBILE => 'Mobile',
            self::FULLSTACK => 'Fullstack',
            self::BACKEND => 'Backend',
            self::FRONTEND => 'Frontend',
            self::DEVOPS => 'DevOps',
            self::OTHER => 'Autre',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::WEB => '🌐',
            self::MOBILE => '📱',
            self::FULLSTACK => '🔄',
            self::BACKEND => '⚙️',
            self::FRONTEND => '🎨',
            self::DEVOPS => '🚀',
            self::OTHER => '📦',
        };
    }
}
