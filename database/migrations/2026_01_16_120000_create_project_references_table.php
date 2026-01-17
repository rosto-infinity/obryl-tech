<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_references', function (Blueprint $table) {
            $table->id();
            
            // Relation avec le projet
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            
            // Informations sur la plateforme de référence
            $table->string('platform_name');
            $table->string('platform_url')->nullable();
            $table->string('platform_type')->default('reference'); // reference, competitor, inspiration
            $table->text('description')->nullable();
            
            // Évaluation de similarité
            $table->integer('similarity_score')->default(0); // 0-100
            $table->json('matching_features')->nullable(); // ["e-commerce", "payment", "user_auth"]
            
            // Notes internes
            $table->text('internal_notes')->nullable();
            $table->text('client_notes')->nullable();
            
            // Statut
            $table->string('status')->default('active'); // active, archived, rejected
            
            // Métadonnées
            $table->json('metadata')->nullable(); // {"screenshot": "...", "tech_stack": [...]}
            
            $table->timestamps();
            
            // Indexes
            $table->index('project_id');
            $table->index('platform_type');
            $table->index('similarity_score');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_references');
    }
};
