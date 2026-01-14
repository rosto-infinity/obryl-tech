<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'developer_id',
        'rating',
        'comment',
        'status',
        'criteria',
    ];

    protected $casts = [
        'rating' => 'integer',
        'criteria' => 'json',
        'status' => \App\Enums\ReviewStatus::class,
    ];

    // Relations
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    // Helpers
    public function isApproved(): bool
    {
        return $this->status === \App\Enums\ReviewStatus::APPROVED;
    }

    public function isPending(): bool
    {
        return $this->status === \App\Enums\ReviewStatus::PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status === \App\Enums\ReviewStatus::REJECTED;
    }

    public function getRatingLabel(): string
    {
        return match($this->rating) {
            1 => '⭐ Très mauvais',
            2 => '⭐⭐ Mauvais',
            3 => '⭐⭐⭐ Moyen',
            4 => '⭐⭐⭐⭐ Bon',
            5 => '⭐⭐⭐⭐⭐ Excellent',
            default => 'Non noté',
        };
    }

    public function getStars(): string
    {
        return str_repeat('⭐', $this->rating);
    }

    public function approve(): void
    {
        $this->update(['status' => \App\Enums\ReviewStatus::APPROVED]);
        
        // Mettre à jour la note moyenne du développeur
        $this->developer->profile->updateAverageRating();
    }

    public function reject(): void
    {
        $this->update(['status' => \App\Enums\ReviewStatus::REJECTED]);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForDeveloper($query, int $developerId)
    {
        return $query->where('developer_id', $developerId);
    }

    public function scopeForProject($query, int $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
