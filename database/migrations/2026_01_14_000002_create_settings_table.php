<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Clé-Valeur
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string');            // string, integer, boolean, json, decimal
            $table->text('description')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Index
            $table->index('key');
        });
        
        // Données par défaut
        DB::table('settings')->insert([
            [
                'key' => 'platform_commission_rate',
                'value' => '15.00',
                'type' => 'decimal',
                'description' => 'Commission de la plateforme en %',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'currency',
                'value' => 'XAF',
                'type' => 'string',
                'description' => 'Devise par défaut (Code ISO)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'min_project_budget',
                'value' => '50000',
                'type' => 'integer',
                'description' => 'Budget minimum pour un projet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'platform_config',
                'value' => json_encode([
                    'site_name' => 'Obryl Tech',
                    'site_url' => 'https://obryl.tech',
                    'support_email' => 'support@obryl.tech',
                    'phone' => '+237...',
                    'address' => 'Yaoundé, Cameroun'
                ]),
                'type' => 'json',
                'description' => 'Configuration générale du site',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
