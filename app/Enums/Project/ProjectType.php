<?php

namespace App\Enums\Project;

enum ProjectType: string
{
    case WEB = 'web';
    case MOBILE = 'mobile';
    case DESKTOP = 'desktop';
    case API = 'api';
    case CONSULTING = 'consulting';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::WEB => 'Web',
            self::MOBILE => 'Mobile',
            self::DESKTOP => 'Desktop',
            self::API => 'API',
            self::CONSULTING => 'Consulting',
            self::OTHER => 'Autre',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::WEB => '🌐',
            self::MOBILE => '📱',
            self::DESKTOP => '💻',
            self::API => '⚙️',
            self::CONSULTING => '💼',
            self::OTHER => '📦',
        };
    }
}
