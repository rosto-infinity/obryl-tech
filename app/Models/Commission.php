<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Commission\CommissionStatus;
use App\Enums\Commission\CommissionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'developer_id',
        'amount',
        'currency',
        'percentage',
        'status',
        'type',
        'description',
        'breakdown',
        'approved_at',
        'paid_at',
        'approved_by',
        'payment_details',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:2',
        'status' => CommissionStatus::class,
        'type' => CommissionType::class,
        'breakdown' => 'json',
        'payment_details' => 'json',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    // Relations
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helpers
    public function isPending(): bool
    {
        return $this->status === CommissionStatus::PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === CommissionStatus::APPROVED;
    }

    public function isPaid(): bool
    {
        return $this->status === CommissionStatus::PAID;
    }

    public function canBePaid(): bool
    {
        return $this->status === CommissionStatus::APPROVED;
    }

    public function markAsPaid(): void
    {
        $this->update([
            'status' => CommissionStatus::PAID,
            'paid_at' => now(),
        ]);
    }

    public function markAsApproved(int $approvedById): void
    {
        $this->update([
            'status' => CommissionStatus::APPROVED,
            'approved_at' => now(),
            'approved_by' => $approvedById,
        ]);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', CommissionStatus::PENDING->value);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', CommissionStatus::APPROVED->value);
    }

    public function scopePaid($query)
    {
        return $query->where('status', CommissionStatus::PAID->value);
    }

    public function scopeForDeveloper($query, int $developerId)
    {
        return $query->where('developer_id', $developerId);
    }

    public function scopeForProject($query, int $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeByType($query, CommissionType $type)
    {
        return $query->where('type', $type->value);
    }
}
