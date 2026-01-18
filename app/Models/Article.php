<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Blog\ArticleCategory;
use App\Enums\Blog\ArticleStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'tags',
        'category',
        'seo',
        'published_at',
        'scheduled_at',
        'views_count',
        'likes_count',
        'comments_count',
        'comments',
    ];

    protected $appends = [
        'url',
        'admin_url',
        'reading_time',
    ];

    protected $casts = [
        'status' => ArticleStatus::class,
        'category' => ArticleCategory::class,
        'tags' => 'array',
        'seo' => 'array',
        'comments' => 'array',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Générer automatiquement le slug à partir du titre
        static::creating(function (Article $article): void {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);

                // S'assurer que le slug est unique
                $originalSlug = $article->slug;
                $counter = 1;

                while (static::where('slug', $article->slug)->exists()) {
                    $article->slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }
        });

        // Mettre à jour le slug si le titre change
        static::updating(function (Article $article): void {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);

                // S'assurer que le slug est unique
                $originalSlug = $article->slug;
                $counter = 1;

                while (static::where('slug', $article->slug)->where('id', '!=', $article->id)->exists()) {
                    $article->slug = $originalSlug.'-'.$counter;
                    $counter++;
                }
            }
        });

        // Auto-publier si le statut passe à published
        static::saving(function (Article $article): void {
            if ($article->isDirty('status') && $article->status === ArticleStatus::PUBLISHED && ! $article->published_at) {
                $article->published_at = now();
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
     * Get the article's URL.
     */
    public function getUrlAttribute(): string
    {
        return route('blog.show', $this->slug);
    }

    /**
     * Get the article's admin URL.
     */
    public function getAdminUrlAttribute(): string
    {
        return route('filament.admin.resources.articles.edit', $this->id);
    }

    /**
     * Get the estimated reading time in minutes.
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));

        return (int) ceil($wordCount / 200); // Average reading speed: 200 words per minute
    }

    /**
     * Get the featured image URL (helper for blade/templates).
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            // Check if it's already a full URL (e.g. from a seeder or external source)
            if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
                return $this->featured_image;
            }

            // Return the URL from the public disk
            return Storage::disk('public')->url($this->featured_image);
        }

        // Fallback to a placeholder
        return asset('images/placeholder-blog.jpg');
    }

    /**
     * Get the tags attribute.
     */
    public function getTagsAttribute($value): array
    {
        if (is_null($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && ! empty($value)) {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * Get the comments attribute.
     */
    public function getCommentsAttribute($value): array
    {
        if (is_null($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && ! empty($value)) {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * Relation: Author of the article.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope: Get only published articles.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ArticleStatus::PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope: Get articles by category.
     */
    public function scopeByCategory(Builder $query, ArticleCategory|string $category): Builder
    {
        $categoryValue = $category instanceof ArticleCategory ? $category->value : $category;

        return $query->where('category', $categoryValue);
    }

    /**
     * Scope: Get articles by author.
     */
    public function scopeByAuthor(Builder $query, int $authorId): Builder
    {
        return $query->where('author_id', $authorId);
    }

    /**
     * Scope: Get featured articles.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->published()
            ->orderBy('views_count', 'desc')
            ->orderBy('likes_count', 'desc');
    }

    /**
     * Scope: Get recent articles.
     */
    public function scopeRecent(Builder $query, int $limit = 5): Builder
    {
        return $query->published()
            ->orderBy('published_at', 'desc')
            ->limit($limit);
    }

    /**
     * Scope: Search articles.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search): void {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        });
    }

    /**
     * Increment views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Increment likes count.
     */
    public function incrementLikes(): void
    {
        $this->increment('likes_count');
    }

    /**
     * Add a comment to the article.
     */
    public function addComment(int $userId, string $content, string $status = 'pending'): void
    {
        $comments = $this->comments ?? [];

        $comments[] = [
            'id' => uniqid(),
            'user_id' => $userId,
            'content' => $content,
            'status' => $status,
            'created_at' => now()->toIso8601String(),
        ];

        $this->update([
            'comments' => $comments,
            'comments_count' => count($comments),
        ]);
    }

    /**
     * Get similar articles.
     */
    public function getSimilarArticles(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('id', '!=', $this->id)
            ->published()
            ->where(function (Builder $query): void {
                $query->where('category', $this->category?->value)
                    ->orWhereJsonContains('tags', $this->tags);
            })
            ->orderByRaw('RAND()')
            ->limit($limit)
            ->get();
    }
}
