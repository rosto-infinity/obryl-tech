<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table): void {
            $table->id();

            // Relations
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();

            // Contenu
            $table->integer('rating')->default(5);
            $table->text('comment')->nullable();
            $table->string('status')->default('approved');         // pending, approved, rejected

            // Détails supplémentaires (JSON)
            $table->json('criteria')->nullable();                  // {"quality": 5, "communication": 4, "timeliness": 5}

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('project_id');
            $table->index('developer_id');
            $table->unique(['project_id', 'developer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
