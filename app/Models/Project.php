<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Project\ProjectPriority;
use App\Enums\Project\ProjectStatus;
use App\Enums\Project\ProjectType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    // Attributs calculés à inclure automatiquement
    protected $appends = [
        'url',
        'admin_url',
        'formatted_code',
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
        'gallery_images' => 'array', // On caste en array directement, pas besoin de getter complexe
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'deadline' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        // 'featured_image' => 'json',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Générer automatiquement le slug à partir du titre
        static::creating(function ($project): void {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);

                // S'assurer que le slug est unique
                $originalSlug = $project->slug;
                $counter = 1;

                while (static::where('slug', $project->slug)->exists()) {
                    $project->slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }
        });

        // Mettre à jour le slug si le titre change
        static::updating(function ($project): void {
            if ($project->isDirty('title') && empty($project->slug)) {
                $project->slug = Str::slug($project->title);

                // S'assurer que le slug est unique
                $originalSlug = $project->slug;
                $counter = 1;

                while (static::where('slug', $project->slug)->where('id', '!=', $project->id)->exists()) {
                    $project->slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }
        });

        // Générer automatiquement le code du projet si non fourni
        static::creating(function ($project): void {
            if (empty($project->code)) {
                // Générer un code plus lisible et professionnel
                $year = date('Y');
                $month = date('m');
                $random = strtoupper(Str::random(6));
                $project->code = "PROJ-{$year}{$month}-{$random}";

                // S'assurer que le code est unique
                while (static::where('code', $project->code)->exists()) {
                    $random = strtoupper(Str::random(6));
                    $project->code = "PROJ-{$year}{$month}-{$random}";
                }
            }
        });

        // Gérer automatiquement is_published en fonction du statut
        static::saving(function ($project): void {
            if ($project->isDirty('status')) {
                $publishedStatuses = ['published', 'completed'];
                $project->is_published = in_array($project->status, $publishedStatuses);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the project's URL.
     */
    public function getUrlAttribute(): string
    {
        return route('projects.detail', $this->slug);
    }

    /**
     * Get the admin URL.
     */
    public function getAdminUrlAttribute(): string
    {
        return route('filament.admin.resources.projects.edit', $this->id);
    }

    /**
     * Check if project can be automatically assigned.
     */
    public function canBeAutoAssigned(): bool
    {
        return in_array($this->status, ['pending', 'accepted'])
            && is_null($this->developer_id);
    }

    /**
     * Get the best available developer for this project.
     */
    public function getBestAvailableDeveloper(): ?User
    {
        $assignmentService = app(\App\Services\ProjectAssignmentService::class);

        return $assignmentService->assignProject($this);
    }

    /**
     * Calculate total commission breakdown for this project.
     */
    public function calculateTotalCommission(): array
    {
        if (! $this->developer_id) {
            return [
                'total' => 0,
                'breakdown' => [],
                'currency' => $this->currency,
            ];
        }

        $calculationService = app(\App\Services\CommissionCalculationService::class);

        return $calculationService->calculateProjectCommission($this, $this->developer);
    }

    /**
     * Auto-assign to best available developer.
     */
    public function autoAssign(): bool
    {
        if (! $this->canBeAutoAssigned()) {
            return false;
        }

        $bestDeveloper = $this->getBestAvailableDeveloper();

        if (! $bestDeveloper) {
            return false;
        }

        $this->update(['developer_id' => $bestDeveloper->id]);

        // Update developer workload
        if ($bestDeveloper->workload) {
            $bestDeveloper->workload->calculateWorkload();
        }

        return true;
    }

    /**
     * Get formatted project code.
     */
    public function getFormattedCodeAttribute(): string
    {
        return strtoupper($this->code);
    }

    /**
     * Set the is_published attribute.
     * Convertit les valeurs de chaîne en booléens.
     */
    public function setIsPublishedAttribute($value): void
    {
        if (is_string($value)) {
            $this->attributes['is_published'] = in_array(strtolower($value), ['published', 'true', '1', 'yes']);
        } else {
            $this->attributes['is_published'] = (bool) $value;
        }
    }

    /**
     * Set the featured image attribute.
     */
    public function setFeaturedImageAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['featured_image'] = $value[0] ?? null;
        } else {
            $this->attributes['featured_image'] = $value;
        }
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return Storage::disk('public')->url($this->featured_image);
        }

        return asset('images/placeholder.jpg');
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

    public function references(): HasMany
    {
        return $this->hasMany(ProjectReference::class);
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

    // Accesseurs JSON simplifiés pour éviter les boucles infinies
    public function getTechnologiesAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        // Si c'est déjà un tableau, retourner directement
        if (is_array($value)) {
            return $value;
        }

        // Si c'est une chaîne, essayer de décoder du JSON
        if (is_string($value) && ! empty($value)) {
            // Gérer le cas où le JSON est mal formé (manque des accolades)
            $cleaned = trim($value, '"');

            // Si la chaîne ne commence pas par [ ou {, l'envelopper dans un tableau
            if (! str_starts_with($cleaned, '[') && ! str_starts_with($cleaned, '{')) {
                // Essayer de réparer le JSON mal formé
                $cleaned = '['.$cleaned.']';
            }

            $decoded = json_decode($cleaned, true);
            if (is_array($decoded)) {
                return $decoded;
            }

            // Si ça échoue, essayer stripslashes
            $cleaned = stripslashes($value);
            $cleaned = trim($cleaned, '"');
            if (! str_starts_with($cleaned, '[') && ! str_starts_with($cleaned, '{')) {
                $cleaned = '['.$cleaned.']';
            }
            $decoded = json_decode($cleaned, true);
            if (is_array($decoded)) {
                return $decoded;
            }

            // Si ce n'est pas du JSON, traiter comme une liste simple
            return array_filter(array_map('trim', explode("\n", $value)));
        }

        return [];
    }

    public function getAttachmentsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        // Si c'est déjà un tableau, retourner directement
        if (is_array($value)) {
            return $value;
        }

        // Si c'est une chaîne, essayer de décoder du JSON
        if (is_string($value) && ! empty($value)) {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    public function getMilestonesAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        // Si c'est déjà un tableau, retourner directement
        if (is_array($value)) {
            return $value;
        }

        // Si c'est une chaîne, essayer de décoder du JSON
        if (is_string($value) && ! empty($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }

            // Si ce n'est pas du JSON, traiter comme une liste simple
            return array_filter(array_map('trim', explode("\n", $value)));
        }

        return [];
    }

    public function getTasksAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        // Si c'est déjà un tableau, retourner directement
        if (is_array($value)) {
            return $value;
        }

        // Si c'est une chaîne, essayer de décoder du JSON
        if (is_string($value) && ! empty($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }

            // Si ce n'est pas du JSON, traiter comme une liste simple
            return array_filter(array_map('trim', explode("\n", $value)));
        }

        return [];
    }

    public function getCollaboratorsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }

        // Si c'est déjà un tableau, retourner directement
        if (is_array($value)) {
            return $value;
        }

        // Si c'est une chaîne, essayer de décoder du JSON
        if (is_string($value) && ! empty($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }

            // Si ce n'est pas du JSON, traiter comme une liste simple
            return array_filter(array_map('trim', explode("\n", $value)));
        }

        return [];
    }

    /**
     * ACCESSOR POUR LA GALERIE
     * Comme 'gallery_images' est casté en 'array' plus haut,
     * Laravel nous donne déjà un tableau. On doit juste convertir chaque chemin en URL.
     */
    protected function galleryImages(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // 1. Si la valeur est vide ou nulle, on retourne un tableau vide
                if (empty($value)) {
                    return [];
                }

                // 2. Si c'est déjà un tableau (ex: cast 'json' a fonctionné), on l'utilise
                if (is_array($value)) {
                    return array_map(fn ($item) => Storage::disk('public')->url($item), $value);
                }

                // 3. Si c'est une chaîne (JSON brut de la base de données), on la décode
                if (is_string($value)) {
                    $decoded = json_decode($value, true);
                    // Si le décodage réussit et donne un tableau, on mappe les URLs
                    if (is_array($decoded)) {
                        return array_map(fn ($item) => Storage::disk('public')->url($item), $decoded);
                    }
                }

                // 4. Fallback : si ça a échoué, on retourne un tableau vide
                return [];
            },
        );
    }

    public function getSimilarProjects(int $limit = 6)
    {
        return Project::where('id', '!=', $this->id)
            ->where('status', ProjectStatus::PUBLISHED->value)
            ->where(function ($query): void {
                // FIX ICI : utilisation de ?-> pour éviter le crash si $this->type est null
                $query->where('type', $this->type?->value)
                    ->orWhereRaw('JSON_CONTAINS(technologies, ?)', [json_encode($this->technologies)]);
            })
            ->where('deleted_at', null)
            ->orderByRaw('RAND()')
            ->limit($limit)
            ->get();
    }

    /**
     * ACCESSOR MODERNE (Laravel 9/10/11+)
     * Transforme le chemin de la base de données en URL complète accessible.
     */
    protected function featuredImage(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::disk('public')->url($value) : null,
        );
    }
}
