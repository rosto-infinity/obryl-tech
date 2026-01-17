<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'platform_name',
        'platform_url',
        'platform_type',
        'description',
        'similarity_score',
        'matching_features',
        'internal_notes',
        'client_notes',
        'status',
        'metadata'
    ];

    protected $casts = [
        'similarity_score' => 'integer',
        'matching_features' => 'array',
        'metadata' => 'array',
    ];

    // Types de plateforme
    const TYPE_REFERENCE = 'reference';
    const TYPE_COMPETITOR = 'competitor';
    const TYPE_INSPIRATION = 'inspiration';

    // Statuts
    const STATUS_ACTIVE = 'active';
    const STATUS_ARCHIVED = 'archived';
    const STATUS_REJECTED = 'rejected';

    /**
     * Relation avec le projet
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Vérifier si la référence est très similaire
     */
    public function isHighlySimilar(): bool
    {
        return $this->similarity_score >= 80;
    }

    /**
     * Vérifier si la référence est moyennement similaire
     */
    public function isModeratelySimilar(): bool
    {
        return $this->similarity_score >= 50 && $this->similarity_score < 80;
    }

    /**
     * Obtenir le badge de similarité
     */
    public function getSimilarityBadge(): string
    {
        if ($this->similarity_score >= 80) {
            return '🔥 Très similaire';
        } elseif ($this->similarity_score >= 50) {
            return '👍 Similaire';
        } elseif ($this->similarity_score >= 30) {
            return '🤔 Partiellement similaire';
        } else {
            return '📋 Référence';
        }
    }

    /**
     * Obtenir l'URL formatée
     */
    public function getFormattedUrl(): string
    {
        if (!$this->platform_url) {
            return '#';
        }
        
        if (!str_starts_with($this->platform_url, 'http')) {
            return 'https://' . $this->platform_url;
        }
        
        return $this->platform_url;
    }

    /**
     * Obtenir le nom de domaine
     */
    public function getDomain(): string
    {
        if (!$this->platform_url) {
            return $this->platform_name;
        }
        
        $url = parse_url($this->getFormattedUrl());
        return $url['host'] ?? $this->platform_name;
    }

    /**
     * Scope pour les références actives
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope pour les références par type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('platform_type', $type);
    }

    /**
     * Scope pour les références les plus similaires
     */
    public function scopeMostSimilar($query)
    {
        return $query->orderBy('similarity_score', 'desc');
    }
}
