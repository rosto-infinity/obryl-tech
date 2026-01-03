<?php

namespace App\Models;

use App\Enums\Developer\Availability;
use App\Enums\Developer\Specialization;
use App\Enums\Developer\VerificationLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company',
        'country',
        'bio',
        'specialization',
        'years_experience',
        'hourly_rate',
        'availability',
        'github_url',
        'linkedin_url',
        'cv_path',
        'is_verified',
        'verification_level',
        'verified_at',
        'verified_by',
        'total_earned',
        'completed_projects_count',
        'average_rating',
        'total_reviews_count',
        'skills',
        'certifications',
        'experiences',
        'social_links',
       
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'skills' => 'json',
        'certifications' => 'json',
        'experiences' => 'json',
        'social_links' => 'json',
        'preferences' => 'json',
        'specialization' => Specialization::class,
        'availability' => Availability::class,
        'verification_level' => VerificationLevel::class,
        'verified_at' => 'datetime',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
