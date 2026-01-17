<?php

declare(strict_types=1);

namespace App\Enums\Blog;

enum CommentStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    /**
     * Get the label for the comment status.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::APPROVED => 'Approuvé',
            self::REJECTED => 'Rejeté',
        };
    }

    /**
     * Get the color for the comment status.
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            self::APPROVED => 'bg-green-100 text-green-800 border-green-200',
            self::REJECTED => 'bg-red-100 text-red-800 border-red-200',
        };
    }
}
