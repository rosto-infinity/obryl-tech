<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            
            // Contenu
            $table->string('title');
            $table->text('description');
            
            // Statut
            $table->string('status')->default('open');             // open, in_progress, resolved, closed, reopened
            $table->string('priority')->default('medium');         // low, medium, high, urgent
            $table->string('category')->default('general');        // billing, technical, general, abuse, feature_request
            $table->string('severity')->default('minor');          // minor, major, critical
            
            // Messages & Pièces jointes (JSON)
            $table->json('messages')->nullable();                  // [{"user_id": ..., "content": "...", "attachments": [...]}]
            $table->json('attachments')->nullable();               // [{"name": "...", "path": "...", "size": ...}]
            
            // Timestamps
            $table->timestamps();
            $table->timestamp('resolved_at')->nullable();
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
