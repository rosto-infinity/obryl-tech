<?php

namespace App\Enums\Notification;

enum NotificationChannel: string
{
    case IN_APP = 'in_app';
    case EMAIL = 'email';
    case SMS = 'sms';
    case PUSH = 'push';

    public function label(): string
    {
        return match($this) {
            self::IN_APP => 'Dans l\'app',
            self::EMAIL => 'Email',
            self::SMS => 'SMS',
            self::PUSH => 'Push',
        };
    }
}
