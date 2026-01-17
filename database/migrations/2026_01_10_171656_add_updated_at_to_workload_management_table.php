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
        Schema::table('workload_management', function (Blueprint $table): void {
            $table->timestamp('updated_at')->nullable()->after('last_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workload_management', function (Blueprint $table): void {
            $table->dropColumn('updated_at');
        });
    }
};
