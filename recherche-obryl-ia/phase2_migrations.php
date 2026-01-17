<?php

declare(strict_types=1);
// ============================================
// PHASE 2 : TABLES DÉPENDANTES DE USERS
// ============================================

// ============================================
// 2025_01_02_000001_create_developer_profiles_table.php
// ============================================
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developer_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('specialization', ['web', 'mobile', 'fullstack', 'backend', 'frontend', 'devops'])->default('web');
            $table->integer('years_experience')->default(0);
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->text('bio')->nullable();
            $table->json('skills')->nullable(); // ['PHP', 'Laravel', 'Vue.js']
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('cv_path')->nullable();
            $table->enum('availability', ['available', 'busy', 'unavailable'])->default('available');
            $table->boolean('is_verified')->default(false);
            $table->decimal('balance', 15, 2)->default(0); // Solde compte
            $table->integer('completed_projects')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0); // 0-5
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->unique('user_id');
            $table->index('is_verified');
            $table->index(['availability', 'is_verified']);
            $table->index('average_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developer_profiles');
    }
};

// ============================================
// 2025_01_02_000002_create_projects_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 20)->unique(); // PRJ-2025-001
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['web', 'mobile', 'desktop', 'api', 'design', 'consulting', 'other'])->default('web');
            $table->decimal('budget', 12, 2)->nullable();
            $table->decimal('final_cost', 12, 2)->nullable();
            $table->date('deadline')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->enum('status', [
                'pending',      // En attente validation
                'accepted',     // Accepté par admin
                'in_progress',  // En cours
                'review',       // Livraison en révision
                'completed',    // Terminé
                'published',    // Publié portfolio
                'cancelled',    // Annulé
                'dispute',       // Litige
            ])->default('pending');
            $table->integer('progress_percentage')->default(0);
            $table->json('technologies')->nullable(); // ['Laravel', 'Vue.js']
            $table->json('attachments')->nullable(); // Fichiers uploadés
            $table->text('admin_notes')->nullable();
            $table->text('client_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('likes_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('code');
            $table->index(['client_id', 'status']);
            $table->index('status');
            $table->index(['is_published', 'is_featured']);
            $table->index('created_at');

            // Fulltext search
            $table->fullText(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

// ============================================
// 2025_01_02_000003_create_blog_posts_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('blog_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('tags')->nullable(); // ['Laravel', 'PHP', 'Tutorial']
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('reading_time')->nullable(); // Minutes
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index(['status', 'published_at']);
            $table->index(['is_featured', 'published_at']);
            $table->index('author_id');
            $table->index('category_id');

            // Fulltext search
            $table->fullText(['title', 'excerpt', 'content']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
