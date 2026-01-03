<?php

namespace App\Enums\Project;

enum ProjectStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case IN_PROGRESS = 'in_progress';
    case REVIEW = 'review';
    case COMPLETED = 'completed';
    case PUBLISHED = 'published';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::ACCEPTED => 'Accepté',
            self::IN_PROGRESS => 'En cours',
            self::REVIEW => 'En révision',
            self::COMPLETED => 'Complété',
            self::PUBLISHED => 'Publié',
            self::CANCELLED => 'Annulé',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::ACCEPTED => 'info',
            self::IN_PROGRESS => 'primary',
            self::REVIEW => 'secondary',
            self::COMPLETED => 'success',
            self::PUBLISHED => 'success',
            self::CANCELLED => 'danger',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::PENDING => '⏳',
            self::ACCEPTED => '✅',
            self::IN_PROGRESS => '⚙️',
            self::REVIEW => '👀',
            self::COMPLETED => '🎉',
            self::PUBLISHED => '📢',
            self::CANCELLED => '❌',
        };
    }
}
