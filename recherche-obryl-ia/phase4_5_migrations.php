<?php

declare(strict_types=1);
// ============================================
// PHASE 4 : REVIEWS
// ============================================

// ============================================
// 2025_01_04_000001_create_reviews_table.php
// ============================================
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete(); // Client
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete(); // Développeur noté
            $table->integer('rating')->unsigned(); // 1-5 étoiles
            $table->text('comment')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            // Contraintes
            $table->unique(['project_id', 'reviewer_id', 'developer_id']);

            // Indexes
            $table->index(['developer_id', 'status']);
            $table->index('rating');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

// ============================================
// PHASE 5 : COMPLÉMENTAIRES
// ============================================

// ============================================
// 2025_01_05_000001_create_portfolio_likes_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_likes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('portfolio_project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable(); // Pour likes anonymes
            $table->timestamps();

            // Contrainte unique
            $table->unique(['portfolio_project_id', 'user_id']);
            $table->unique(['portfolio_project_id', 'ip_address']);

            // Indexes
            $table->index('portfolio_project_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_likes');
    }
};

// ============================================
// 2025_01_05_000002_create_blog_comments_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_comments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('blog_comments')->cascadeOnDelete();
            $table->string('author_name')->nullable(); // Pour commentaires anonymes
            $table->string('author_email')->nullable();
            $table->text('content');
            $table->enum('status', ['pending', 'approved', 'rejected', 'spam'])->default('pending');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['blog_post_id', 'status']);
            $table->index('user_id');
            $table->index('parent_id');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};

// ============================================
// 2025_01_05_000003_create_notifications_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

// ============================================
// 2025_01_05_000004_create_activity_log_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_log', function (Blueprint $table): void {
            $table->id();
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->nullableMorphs('causer', 'causer');
            $table->json('properties')->nullable();
            $table->uuid('batch_uuid')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('log_name');
            $table->index(['subject_type', 'subject_id']);
            $table->index(['causer_type', 'causer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};

// ============================================
// 2025_01_05_000005_create_media_table.php (Spatie Media Library)
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table): void {
            $table->id();
            $table->morphs('model');
            $table->uuid('uuid')->nullable()->unique();
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->json('manipulations');
            $table->json('custom_properties');
            $table->json('generated_conversions');
            $table->json('responsive_images');
            $table->unsignedInteger('order_column')->nullable()->index();
            $table->timestamps();

            // Indexes
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
