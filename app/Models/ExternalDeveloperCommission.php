<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Commission\CommissionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExternalDeveloperCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'external_developer_id',
        'amount',
        'currency',
        'commission_rate',
        'status',
        'payment_method',
        'payment_details',
        'work_delivered_at',
        'approved_at',
        'paid_at',
        'approved_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'payment_details' => 'json',
        'work_delivered_at' => 'datetime',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the project that owns this commission.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the external developer that earned this commission.
     */
    public function externalDeveloper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'external_developer_id');
    }

    /**
     * Get the admin who approved this commission.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if commission is pending.
     */
    public function isPending(): bool
    {
        return $this->status === CommissionStatus::PENDING->value;
    }

    /**
     * Check if commission is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === CommissionStatus::APPROVED->value;
    }

    /**
     * Check if commission is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === CommissionStatus::PAID->value;
    }

    /**
     * Approve the commission.
     */
    public function approve(User $approver): void
    {
        $this->update([
            'status' => CommissionStatus::APPROVED->value,
            'approved_at' => now(),
            'approved_by' => $approver->id,
        ]);
    }

    /**
     * Mark commission as paid.
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => CommissionStatus::PAID->value,
            'paid_at' => now(),
        ]);
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', ' ').' '.$this->currency;
    }

    /**
     * Get commission amount (amount * commission_rate / 100).
     */
    public function getCommissionAmountAttribute(): float
    {
        return ($this->amount * $this->commission_rate) / 100;
    }

    /**
     * Get formatted commission amount.
     */
    public function getFormattedCommissionAmountAttribute(): string
    {
        return number_format($this->commission_amount, 0, ',', ' ').' '.$this->currency;
    }
}
