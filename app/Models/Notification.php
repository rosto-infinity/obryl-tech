<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Notification\NotificationChannel;
use App\Enums\Notification\NotificationType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'channel',
        'read_at',
        'sent_at',
    ];

    protected $casts = [
        'data' => 'json',
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
        'type' => NotificationType::class,
        'channel' => NotificationChannel::class,
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helpers
    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
