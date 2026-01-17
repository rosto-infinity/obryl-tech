<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Auth\UserStatus;
use App\Enums\Auth\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable,TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'status',
        'phone',
        'avatar',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_type' => UserType::class,
            'status' => UserStatus::class,
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Générer automatiquement le slug à partir du nom
        static::creating(function ($user): void {
            if (empty($user->slug)) {
                $user->slug = Str::slug($user->name);

                // S'assurer que le slug est unique
                $originalSlug = $user->slug;
                $counter = 1;

                while (static::where('slug', $user->slug)->exists()) {
                    $user->slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }
        });

        // Mettre à jour le slug si le nom change
        static::updating(function ($user): void {
            if ($user->isDirty('name') && empty($user->slug)) {
                $user->slug = Str::slug($user->name);

                // S'assurer que le slug est unique
                $originalSlug = $user->slug;
                $counter = 1;

                while (static::where('slug', $user->slug)->where('id', '!=', $user->id)->exists()) {
                    $user->slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }
        });

        // Assigner automatiquement le rôle correspondant au user_type
        static::created(function ($user): void {
            // user_type est une chaîne, pas un enum
            if ($user->user_type) {
                $user->assignRole($user->user_type);
            }
        });

        static::updated(function ($user): void {
            if ($user->isDirty('user_type')) {
                // Synchroniser le rôle si le type a changé
                $user->syncRoles([$user->user_type]);
            }
        });
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // Relations
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class, 'developer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'developer_id');
    }

    // public function articles(): HasMany
    // {
    //     return $this->hasMany(Article::class, 'author_id');
    // }

    public function tickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class, 'user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    // Helpers
    public function isDeveloper(): bool
    {
        return $this->user_type === UserType::DEVELOPER;
    }

    public function isClient(): bool
    {
        return $this->user_type === UserType::CLIENT;
    }

    public function isAdmin(): bool
    {
        return $this->user_type === UserType::ADMIN;
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::ACTIVE;
    }

    /**
     * Get the workload management record for this developer.
     */
    public function workload(): HasOne
    {
        return $this->hasOne(WorkloadManagement::class, 'developer_id');
    }

    /**
     * Get external commissions for this developer.
     */
    public function externalCommissions(): HasMany
    {
        return $this->hasMany(ExternalDeveloperCommission::class, 'external_developer_id');
    }

    /**
     * Get current workload information.
     */
    public function getCurrentWorkload(): array
    {
        if (! $this->workload) {
            return [
                'active_projects' => 0,
                'max_capacity' => 3,
                'workload_percentage' => 0,
                'availability_status' => 'available',
            ];
        }

        return $this->workload->calculateWorkload();
    }

    /**
     * Check if developer is available for new projects.
     */
    public function isAvailableForWork(): bool
    {
        if (! $this->isDeveloper() || ! $this->isActive()) {
            return false;
        }

        if (! $this->workload) {
            return true;
        }

        return $this->workload->isAvailable();
    }

    /**
     * Get developer's commission rate based on skill level.
     */
    public function getCommissionRate(): float
    {
        if (! $this->profile) {
            return 10.0;
        }

        return match ($this->profile->skill_level) {
            'junior' => 8.0,
            'intermediate' => 10.0,
            'senior' => 12.0,
            'expert' => 15.0,
            default => 10.0
        };
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id'; // Temporairement, utiliser l'ID
    }
}
