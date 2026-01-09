<?php

declare(strict_types=1);

namespace App\Enums\Blog;

enum ArticleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
    case SCHEDULED = 'scheduled';

    /**
     * Get the label for the article status.
     */
    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Brouillon',
            self::PUBLISHED => 'Publié',
            self::ARCHIVED => 'Archivé',
            self::SCHEDULED => 'Programmé',
        };
    }

    /**
     * Get the color for the article status.
     */
    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            self::PUBLISHED => 'bg-green-100 text-green-800 border-green-200',
            self::ARCHIVED => 'bg-gray-100 text-gray-800 border-gray-200',
            self::SCHEDULED => 'bg-blue-100 text-blue-800 border-blue-200',
        };
    }

    /**
     * Get the icon for the article status.
     */
    public function icon(): string
    {
        return match($this) {
            self::DRAFT => '📝',
            self::PUBLISHED => '✅',
            self::ARCHIVED => '📦',
            self::SCHEDULED => '⏰',
        };
    }
}
