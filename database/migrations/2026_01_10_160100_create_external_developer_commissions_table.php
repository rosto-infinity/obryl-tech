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
        Schema::create('external_developer_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('external_developer_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3)->default('XAF');
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['bank_transfer', 'mobile_money', 'crypto', 'wallet']);
            $table->json('payment_details')->nullable();
            $table->timestamp('work_delivered_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
            
            // Indexes
            $table->index(['project_id', 'external_developer_id'], 'proj_dev_idx');
            $table->index('status');
            $table->index('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_developer_commissions');
    }
};
