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
        Schema::create('workload_management', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            $table->integer('current_projects_count')->default(0);
            $table->integer('max_projects_capacity')->default(3);
            $table->enum('availability_status', ['available', 'busy', 'overloaded'])->default('available');
            $table->decimal('workload_percentage', 5, 2)->default(0.00);
            $table->timestamp('last_updated_at')->useCurrent();

            // Indexes
            $table->index('developer_id');
            $table->index('availability_status');
            $table->index('workload_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workload_management');
    }
};
