<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer l'ancienne structure si elle existe
        Schema::dropIfExists('notification_settings');
        Schema::dropIfExists('notifications');

        // Créer la nouvelle structure selon AGENTS.md
        Schema::create('notifications', function (Blueprint $table): void {
            $table->uuid('id')->primary();

            // Destinataire
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Type & Contenu
            $table->string('type');                                // 'project_assigned', 'milestone_completed', etc
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();                      // {"project_id": ..., "url": "..."}

            // Canaux
            $table->string('channel')->default('in_app');          // in_app, email, sms, push

            // Statut
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('read_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
