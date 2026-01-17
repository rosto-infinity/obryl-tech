<?php

declare(strict_types=1);

namespace App\Enums\Notification;

enum NotificationStatus: string
{
    case PENDING = 'pending';
    case SENT = 'sent';
    case FAILED = 'failed';
    case READ = 'read';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::SENT => 'Envoyée',
            self::FAILED => 'Échouée',
            self::READ => 'Lue',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::SENT => 'info',
            self::FAILED => 'danger',
            self::READ => 'success',
        };
    }
}
