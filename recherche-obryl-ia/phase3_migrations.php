<?php
// ============================================
// PHASE 3 : TABLES DÉPENDANTES DE PROJECTS
// ============================================

// ============================================
// 2025_01_03_000001_create_project_milestones_table.php
// ============================================
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('title'); // "Maquettes", "Backend", "Frontend"
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->boolean('is_paid')->default(false); // Débloque paiement
            $table->decimal('percentage_release', 5, 2)->nullable(); // % budget à libérer
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->integer('order')->default(0);
            $table->text('deliverables')->nullable(); // JSON ou texte
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['project_id', 'status']);
            $table->index(['project_id', 'order']);
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_milestones');
    }
};

// ============================================
// 2025_01_03_000002_create_project_payments_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Qui paie
            $table->foreignId('milestone_id')->nullable()->constrained('project_milestones')->nullOnDelete();
            $table->enum('payment_type', ['deposit', 'milestone', 'full', 'refund'])->default('full');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method', 50)->nullable(); // stripe, paypal, orange_money
            $table->string('transaction_id')->nullable()->unique(); // ID externe
            $table->text('gateway_response')->nullable(); // JSON response
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['project_id', 'status']);
            $table->index('transaction_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_payments');
    }
};

// ============================================
// 2025_01_03_000003_create_chats_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->json('attachments')->nullable(); // [{name, path, size, type}]
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['project_id', 'created_at']);
            $table->index(['sender_id', 'created_at']);
            $table->index('is_read');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};

// ============================================
// 2025_01_03_000004_create_project_collaborators_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            $table->enum('role', ['lead', 'developer', 'designer', 'tester', 'consultant'])->default('developer');
            $table->text('task_description')->nullable();
            $table->decimal('task_percentage', 5, 2)->default(0); // % du projet
            $table->decimal('commission_amount', 10, 2)->default(0); // Montant à recevoir
            $table->enum('payment_status', ['pending', 'released', 'refunded'])->default('pending');
            $table->enum('status', ['invited', 'accepted', 'declined', 'working', 'completed', 'removed'])->default('invited');
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Contrainte unique
            $table->unique(['project_id', 'developer_id']);
            
            // Indexes
            $table->index(['developer_id', 'status']);
            $table->index(['project_id', 'role']);
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_collaborators');
    }
};

// ============================================
// 2025_01_03_000005_create_portfolio_projects_table.php
// ============================================
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('showcase_title')->nullable(); // Titre public
            $table->text('showcase_description')->nullable(); // Description publique
            $table->json('screenshots')->nullable(); // Images
            $table->string('demo_url')->nullable();
            $table->string('github_url')->nullable();
            $table->json('highlighted_features')->nullable(); // Features mises en avant
            $table->boolean('is_featured')->default(false);
            $table->integer('display_order')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->unique('project_id');
            $table->index(['is_featured', 'display_order']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_projects');
    }
};
