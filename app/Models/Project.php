<?php

namespace App\Models;

use App\Enums\Project\ProjectStatus;
use App\Enums\Project\ProjectType;
use App\Enums\Project\ProjectPriority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'slug',
        'client_id',
        'type',
        'status',
        'priority',
        'budget',
        'final_cost',
        'currency',
        'deadline',
        'started_at',
        'completed_at',
        'progress_percentage',
        'technologies',
        'attachments',
        'milestones',
        'tasks',
        'collaborators',
        'is_published',
        'is_featured',
        'likes_count',
        'views_count',
        'reviews_count',
        'average_rating',
        'admin_notes',
        'cancellation_reason',
        'featured_image',
        'gallery_images',
    ];

    protected $casts = [
        'type' => ProjectType::class,
        'status' => ProjectStatus::class,
        'priority' => ProjectPriority::class,
        'technologies' => 'json',
        'attachments' => 'json',
        'milestones' => 'json',
        'tasks' => 'json',
        'collaborators' => 'json',
        'gallery_images' => 'json',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'deadline' => 'date',
        'started_at' => 'date',
        'completed_at' => 'date',
    ];

    // Relations
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    // public function tickets(): HasMany
    // {
    //     return $this->hasMany(SupportTicket::class);
    // }

    // Helpers
    public function isCompleted(): bool
    {
        return $this->status === ProjectStatus::COMPLETED;
    }

    public function isInProgress(): bool
    {
        return $this->status === ProjectStatus::IN_PROGRESS;
    }

    public function getMilestonesAttribute()
    {
        return $this->attributes['milestones'] ? json_decode($this->attributes['milestones'], true) : [];
    }

    public function getTasksAttribute()
    {
        return $this->attributes['tasks'] ? json_decode($this->attributes['tasks'], true) : [];
    }

    public function getCollaboratorsAttribute()
    {
        return $this->attributes['collaborators'] ? json_decode($this->attributes['collaborators'], true) : [];
    }
}
