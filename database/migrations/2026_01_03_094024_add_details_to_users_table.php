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
        Schema::table('users', function (Blueprint $table): void {
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();

            // Type & Statut
            $table->string('user_type')->default('client');  // client, developer, admin
            $table->string('status')->default('active');     // active, inactive, suspended

            $table->softDeletes();

            $table->index('email');
            $table->index('user_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            //
        });
    }
};
