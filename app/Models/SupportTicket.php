<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Support\TicketCategory;
use App\Enums\Support\TicketPriority;
use App\Enums\Support\TicketSeverity;
use App\Enums\Support\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_to',
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'category',
        'severity',
        'messages',
        'attachments',
        'resolved_at',
    ];

    protected $casts = [
        'messages' => 'json',
        'attachments' => 'json',
        'resolved_at' => 'datetime',
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class,
        'category' => TicketCategory::class,
        'severity' => TicketSeverity::class,
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function isResolved(): bool
    {
        return $this->status === TicketStatus::RESOLVED || $this->status === TicketStatus::CLOSED;
    }
}
