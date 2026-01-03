<?php

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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            
            // Profil Client
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->text('bio')->nullable();
            
            // Profil Développeur
            $table->string('specialization')->nullable();           // web, mobile, fullstack, backend, frontend, devops
            $table->integer('years_experience')->default(0);
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->string('availability')->default('available');   // available, busy, unavailable
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('cv_path')->nullable();
            
            // Vérification Développeur
            $table->boolean('is_verified')->default(false);
            $table->string('verification_level')->default('unverified');  // unverified, basic, advanced, certified
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Statistiques (dénormalisées)
            $table->decimal('total_earned', 15, 2)->default(0);
            $table->integer('completed_projects_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_reviews_count')->default(0);
            
            // Données JSON flexibles
            $table->json('skills')->nullable();                    // [{"name": "Laravel", "level": "expert"}, ...]
            $table->json('certifications')->nullable();            // [{"title": "AWS", "year": 2024}, ...]
            $table->json('experiences')->nullable();               // [{"company": "...", "position": "...", "years": "..."}]
            $table->json('social_links')->nullable();              // {"twitter": "...", "portfolio": "..."}
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('is_verified');
            $table->index('specialization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
