<?php

namespace App\Models;



use App\Enums\Project\ProjectType;
use App\Enums\Project\ProjectStatus;
use App\Enums\Project\ProjectPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'slug',
        'client_id',
        'developer_id',
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
        'deadline' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'featured_image' => 'json',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Relations
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

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
        $milestones = $this->attributes['milestones'] ?? null;
        
        if ($milestones === null) {
            return [];
        }
        
        if (is_string($milestones)) {
            return json_decode($milestones, true) ?? [];
        }
        
        return is_array($milestones) ? $milestones : [];
    }

    public function getTasksAttribute()
    {
        $tasks = $this->attributes['tasks'] ?? null;
        
        if ($tasks === null) {
            return [];
        }
        
        if (is_string($tasks)) {
            return json_decode($tasks, true) ?? [];
        }
        
        return is_array($tasks) ? $tasks : [];
    }

    public function getCollaboratorsAttribute()
    {
        $collaborators = $this->attributes['collaborators'] ?? null;
        
        if ($collaborators === null) {
            return [];
        }
        
        if (is_string($collaborators)) {
            return json_decode($collaborators, true) ?? [];
        }
        
        return is_array($collaborators) ? $collaborators : [];
    }

  public function getSimilarProjects(int $limit = 6)
{
    return Project::where('id', '!=', $this->id)
        ->where('status', ProjectStatus::PUBLISHED->value)
        ->where(function ($query) {
            // FIX ICI : utilisation de ?-> pour éviter le crash si $this->type est null
            $query->where('type', $this->type?->value)
                  ->orWhereRaw("JSON_CONTAINS(technologies, ?)", [json_encode($this->technologies)]);
        })
        ->where('deleted_at', null)
        ->orderByRaw('RAND()')
        ->limit($limit)
        ->get();
}
}
