<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 30 articles avec différents statuts
        Article::factory()->count(20)->published()->create();
        Article::factory()->count(5)->draft()->create();
        Article::factory()->count(3)->published()->featured()->create();
        Article::factory()->count(2)->create(['status' => 'archived']);
        
        $this->command->info('✅ 30 articles créés avec succès !');
    }
}
