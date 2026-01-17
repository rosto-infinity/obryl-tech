<?php

declare(strict_types=1);

namespace App\Enums\Notification;

enum NotificationType: string
{
    case PROJECT_ASSIGNED = 'project_assigned';
    case MILESTONE_COMPLETED = 'milestone_completed';
    case COMMISSION_APPROVED = 'commission_approved';
    case COMMISSION_PAID = 'commission_paid';
    case REVIEW_RECEIVED = 'review_received';
    case MESSAGE_RECEIVED = 'message_received';
    case PROJECT_COMPLETED = 'project_completed';
    case DEVELOPER_VERIFIED = 'developer_verified';

    public function label(): string
    {
        return match ($this) {
            self::PROJECT_ASSIGNED => 'Projet assigné',
            self::MILESTONE_COMPLETED => 'Jalon complété',
            self::COMMISSION_APPROVED => 'Commission approuvée',
            self::COMMISSION_PAID => 'Commission payée',
            self::REVIEW_RECEIVED => 'Avis reçu',
            self::MESSAGE_RECEIVED => 'Message reçu',
            self::PROJECT_COMPLETED => 'Projet complété',
            self::DEVELOPER_VERIFIED => 'Développeur vérifié',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PROJECT_ASSIGNED => '📋',
            self::MILESTONE_COMPLETED => '🎯',
            self::COMMISSION_APPROVED => '✅',
            self::COMMISSION_PAID => '💰',
            self::REVIEW_RECEIVED => '⭐',
            self::MESSAGE_RECEIVED => '💬',
            self::PROJECT_COMPLETED => '🎉',
            self::DEVELOPER_VERIFIED => '🏆',
        };
    }
}
