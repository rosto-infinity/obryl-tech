<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table): void {
            $table->id();

            // Utilisateur
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Action
            $table->string('action');                              // 'created', 'updated', 'deleted'
            $table->string('model_type');                          // 'App\Models\Project'
            $table->unsignedBigInteger('model_id');

            // Changements
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Contexte
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('action');
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
