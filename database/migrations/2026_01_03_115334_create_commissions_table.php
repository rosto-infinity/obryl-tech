<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            
            // Montant
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('XAF');
            $table->decimal('percentage', 5, 2)->nullable();       // % du projet
            
            // Statut
            $table->string('status')->default('pending');          // pending, approved, paid, cancelled, refunded
            $table->string('type')->default('project_completion'); // project_completion, milestone, referral, bonus
            
            // Détails
            $table->text('description')->nullable();
            $table->json('breakdown')->nullable();                 // {"base": 100, "bonus": 20, "tax": 10}
            
            // Approbation & Paiement
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Données de paiement
            $table->json('payment_details')->nullable();           // {"method": "bank", "account": "..."}
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('developer_id');
            $table->index('status');
            $table->index('project_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
