<?php

namespace App\Enums\Support;

enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
    case REOPENED = 'reopened';

    public function label(): string
    {
        return match($this) {
            self::OPEN => 'Ouvert',
            self::IN_PROGRESS => 'En cours',
            self::RESOLVED => 'Résolu',
            self::CLOSED => 'Fermé',
            self::REOPENED => 'Réouvert',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::OPEN => 'danger',
            self::IN_PROGRESS => 'primary',
            self::RESOLVED => 'success',
            self::CLOSED => 'secondary',
            self::REOPENED => 'warning',
        };
    }
}
