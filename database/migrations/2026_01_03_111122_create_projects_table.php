<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            // Identité
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('slug')->unique();

            // Client
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();

            // Détails
            $table->string('type')->default('web');                // web, mobile, desktop, api, consulting
            $table->string('status')->default('pending');          // pending, accepted, in_progress, review, completed, published, cancelled
            $table->string('priority')->default('medium');         // low, medium, high, critical

            // Budget & Coûts
            $table->decimal('budget', 12, 2)->nullable();
            $table->decimal('final_cost', 12, 2)->nullable();
            $table->string('currency', 3)->default('XAF');

            // Dates
            $table->date('deadline')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();

            // Progression
            $table->integer('progress_percentage')->default(0);

            // Contenu & Médias
            $table->json('technologies')->nullable();              // ["Laravel", "Vue.js", "MySQL"]
            $table->json('attachments')->nullable();               // [{"name": "...", "path": "...", "size": ...}]
            $table->json('milestones')->nullable();                // [{"title": "...", "due_date": "...", "status": "..."}]
            $table->json('tasks')->nullable();                     // [{"title": "...", "status": "...", "assigned_to": ...}]
            $table->json('collaborators')->nullable();             // [{"user_id": ..., "role": "...", "percentage": ...}]

            // Publication & Visibilité
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);

            // Statistiques (dénormalisées)
            $table->integer('likes_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('reviews_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);

            // Admin
            $table->text('admin_notes')->nullable();
            $table->text('cancellation_reason')->nullable();

            // Images
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();            // [{"path": "...", "caption": "..."}]

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('client_id');
            $table->index('status');
            $table->index('is_published');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
