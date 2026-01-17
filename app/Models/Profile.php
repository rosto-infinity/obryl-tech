<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Developer\Availability;
use App\Enums\Developer\Specialization;
use App\Enums\Developer\VerificationLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
        'avatar',
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

    // Accesseurs JSON simplifiés pour éviter les boucles infinies
    public function getSkillsAttribute($value)
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

    public function getCertificationsAttribute($value)
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

    public function getExperiencesAttribute($value)
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

    public function getSocialLinksAttribute($value)
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

    public function updateAverageRating(): void
    {
        $average = \App\Models\Review::where('developer_id', $this->user_id)
            ->where('status', \App\Enums\ReviewStatus::APPROVED)
            ->avg('rating');

        $count = \App\Models\Review::where('developer_id', $this->user_id)
            ->where('status', \App\Enums\ReviewStatus::APPROVED)
            ->count();

        $this->update([
            'average_rating' => round($average ?? 0, 1),
            'total_reviews_count' => $count,
        ]);
    }

    public function getAvatarUrlAttribute()
    {
        if (! $this->avatar) {
            return null;
        }

        return Storage::url($this->avatar);
    }
}
