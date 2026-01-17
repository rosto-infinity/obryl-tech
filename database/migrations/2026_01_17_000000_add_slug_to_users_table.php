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
        Schema::table('users', function (Blueprint $table) {
            // Vérifier si la colonne slug n'existe pas déjà
            if (!Schema::hasColumn('users', 'slug')) {
                // Ajouter la colonne slug après la colonne email
                $table->string('slug')->unique()->after('email');
            } else {
                // Si la colonne existe, ajouter seulement l'index unique
                $table->unique('slug');
            }
            
            // Ajouter un index pour optimiser les recherches par slug
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer les index avant de supprimer la colonne
            $table->dropIndex(['slug']);
            $table->dropUnique(['slug']);
            
            // Supprimer la colonne slug si elle existe
            if (Schema::hasColumn('users', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};