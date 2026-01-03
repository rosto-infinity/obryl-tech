<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Exécuter les seeders dans l'ordre
        $this->call([
            UserSeeder::class,
            ProjectSeeder::class,
            // ArticleSeeder::class,
            // SettingSeeder::class,
        ]);

        echo "\n";
        echo "╔════════════════════════════════════════════════════════════╗\n";
        echo "║                                                            ║\n";
        echo "║     ✅ BASE DE DONNÉES OBRYL TECH 2026 INITIALISÉE !      ║\n";
        echo "║                                                            ║\n";
        echo "║  📊 Données créées :                                       ║\n";
        echo "║     • 1 Admin                                              ║\n";
        echo "║     • 5 Clients                                            ║\n";
        echo "║     • 15 Développeurs                                      ║\n";
        echo "║     • 23 Projets                                           ║\n";
        echo "║     • 10-15 Avis                                           ║\n";
        echo "║     • 10-15 Commissions                                    ║\n";
        echo "║                                                            ║\n";
        echo "║  🚀 Prêt pour le développement !                           ║\n";
        echo "║                                                            ║\n";
        echo "╚════════════════════════════════════════════════════════════╝\n";
    }
}
