# Guide des Migrations Consolidées (Fresh Start)

Ce guide fournit le code PHP complet pour une installation propre (Fresh Start), en fusionnant les modifications et en supprimant les doublons.

---

## 1. Profiles Table
**Fichier :** `database/migrations/2026_01_03_111110_create_profiles_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            
            // Profil Client
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->text('bio')->nullable();
            
            // Profil Développeur
            $table->string('specialization')->nullable();
            $table->integer('years_experience')->default(0);
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->string('availability')->default('available');
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('cv_path')->nullable();
            
            // Vérification
            $table->boolean('is_verified')->default(false);
            $table->string('verification_level')->default('unverified');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Statistiques
            $table->decimal('total_earned', 15, 2)->default(0);
            $table->integer('completed_projects_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_reviews_count')->default(0);
            
            // Données Flexibles
            $table->json('skills')->nullable();
            $table->json('certifications')->nullable();
            $table->json('experiences')->nullable();
            $table->json('social_links')->nullable();
            
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('is_verified');
            $table->index('specialization');
        });
    }

    public function down(): void {
        Schema::dropIfExists('profiles');
    }
};
```

---

## 2. Projects Table (FUSIONNÉE)
**Fichier :** `database/migrations/2026_01_03_111122_create_projects_table.php`
*(Inclut `developer_id` directement)*

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('slug')->unique();
            
            // Clients & Développeurs (FUSIONNÉS ICI)
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('developer_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('type')->default('web');
            $table->string('status')->default('pending');
            $table->string('priority')->default('medium');
            
            $table->decimal('budget', 12, 2)->nullable();
            $table->decimal('final_cost', 12, 2)->nullable();
            $table->string('currency', 3)->default('XAF');
            
            $table->date('deadline')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            
            $table->integer('progress_percentage')->default(0);
            
            $table->json('technologies')->nullable();
            $table->json('attachments')->nullable();
            $table->json('milestones')->nullable();
            $table->json('tasks')->nullable();
            $table->json('collaborators')->nullable();
            
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            
            $table->integer('likes_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('reviews_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('client_id');
            $table->index('status');
        });
    }

    public function down(): void {
        Schema::dropIfExists('projects');
    }
};
```

---

## 3. Reviews Table
**Fichier :** `database/migrations/2026_01_03_114929_create_reviews_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            
            $table->integer('rating')->default(5);
            $table->text('comment')->nullable();
            $table->string('status')->default('approved');
            $table->json('criteria')->nullable();
            
            $table->timestamps();
            
            $table->unique(['project_id', 'developer_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('reviews');
    }
};
```

---

## 4. Commissions Table
**Fichier :** `database/migrations/2026_01_03_115334_create_commissions_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('XAF');
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('status')->default('pending');
            $table->string('type')->default('project_completion');
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('commissions');
    }
};
```

---

## 5. Permissions System (Spatie)
**Fichier :** `database/migrations/2026_01_04_174520_create_permission_tables.php`
*(Structure standard de Spatie Permission)*

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->foreign('permission_id')->references('id')->on($tableNames['permissions'])->onDelete('cascade');
            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type']);
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->foreign('role_id')->references('id')->on($tableNames['roles'])->onDelete('cascade');
            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type']);
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('permission_id')->references('id')->on($tableNames['permissions'])->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on($tableNames['roles'])->onDelete('cascade');
            $table->primary(['permission_id', 'role_id']);
        });
    }

    public function down(): void {
        $tableNames = config('permission.table_names');
        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
};
```

---

## 6. Articles Table
**Fichier :** `database/migrations/2026_01_09_172701_create_articles_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('status')->default('draft');
            $table->json('tags')->nullable();
            $table->string('category')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->json('comments')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('articles');
    }
};
```

---

## 7. Workload Table (FUSIONNÉE)
**Fichier :** `database/migrations/2026_01_10_160000_create_workload_management_table.php`
*(Utilisation standard des `timestamps()`)*

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('workload_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('developer_id')->constrained('users')->cascadeOnDelete();
            $table->integer('current_projects_count')->default(0);
            $table->integer('max_projects_capacity')->default(3);
            $table->enum('availability_status', ['available', 'busy', 'overloaded'])->default('available');
            $table->decimal('workload_percentage', 5, 2)->default(0.00);
            
            $table->timestamps(); // FUSIONNÉ ICI
        });
    }

    public function down(): void {
        Schema::dropIfExists('workload_management');
    }
};
```

---

## 8. External Developer Commissions
**Fichier :** `database/migrations/2026_01_10_160100_create_external_developer_commissions_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('external_developer_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('external_developer_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3)->default('XAF');
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');
            $table->json('payment_details')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('external_developer_commissions');
    }
};
```

---

## 9. Support Tickets Table
**Fichier :** `database/migrations/2026_01_14_000001_create_support_tickets_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('open');
            $table->string('priority')->default('medium');
            $table->json('messages')->nullable();
            
            $table->timestamps();
            $table->timestamp('resolved_at')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('support_tickets');
    }
};
```

---

## 10. Settings Table
**Fichier :** `database/migrations/2026_01_14_000002_create_settings_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Données par défaut
        DB::table('settings')->insert([
            ['key' => 'platform_commission_rate', 'value' => '15.00', 'type' => 'decimal', 'description' => 'Commission plateforme %', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'currency', 'value' => 'XAF', 'type' => 'string', 'description' => 'Devise par défaut', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('settings');
    }
};
```

---

## 11. Audit Logs Table
**Fichier :** `database/migrations/2026_01_14_000003_create_audit_logs_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('audit_logs');
    }
};
```

---

## 12. Notifications Table (UUID v2)
**Fichier :** `database/migrations/2026_01_14_000004_create_notifications_table.php`
*(Utilisation directe de l'UUID et structure v2)*

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();
            $table->string('channel')->default('in_app');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};
```
