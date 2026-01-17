<?php

declare(strict_types=1);

namespace App\Enums\Blog;

enum ArticleCategory: string
{
    case TUTORIAL = 'tutorial';
    case NEWS = 'news';
    case CASE_STUDY = 'case_study';
    case ANNOUNCEMENT = 'announcement';
    case GUIDE = 'guide';

    /**
     * Get the label for the article category.
     */
    public function label(): string
    {
        return match ($this) {
            self::TUTORIAL => 'Tutoriel',
            self::NEWS => 'Actualité',
            self::CASE_STUDY => 'Étude de cas',
            self::ANNOUNCEMENT => 'Annonce',
            self::GUIDE => 'Guide',
        };
    }

    /**
     * Get the icon for the article category.
     */
    public function icon(): string
    {
        return match ($this) {
            self::TUTORIAL => '📚',
            self::NEWS => '📰',
            self::CASE_STUDY => '📊',
            self::ANNOUNCEMENT => '📢',
            self::GUIDE => '📖',
        };
    }

    /**
     * Get the color for the article category.
     */
    public function color(): string
    {
        return match ($this) {
            self::TUTORIAL => 'bg-purple-100 text-purple-800 border-purple-200',
            self::NEWS => 'bg-blue-100 text-blue-800 border-blue-200',
            self::CASE_STUDY => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            self::ANNOUNCEMENT => 'bg-orange-100 text-orange-800 border-orange-200',
            self::GUIDE => 'bg-teal-100 text-teal-800 border-teal-200',
        };
    }
}
