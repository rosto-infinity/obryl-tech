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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            
            // Auteur
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            
            // Contenu
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            
            // Métadonnées
            $table->string('featured_image')->nullable();
            $table->string('status')->default('draft');            // draft, published, archived, scheduled
            $table->json('tags')->nullable();                      // ["Laravel", "PHP", "Web"]
            $table->string('category')->nullable();                // tutorial, news, case_study, announcement, guide
            $table->json('seo')->nullable();                       // {"meta_description": "...", "keywords": "..."}
            
            // Publication
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            
            // Statistiques (dénormalisées)
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            
            // Commentaires (JSON)
            $table->json('comments')->nullable();                  // [{"user_id": ..., "content": "...", "status": "..."}]
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('author_id');
            $table->index('category');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

