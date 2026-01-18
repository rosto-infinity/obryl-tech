<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;

class TestFilamentImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:filament-images {project_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester l affichage des images dans Filament v4';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $projectId = $this->argument('project_id');
        
        $this->info('🧪 TEST FILAMENT V4 - IMAGES');
        $this->info(str_repeat('=', 60));
        
        if ($projectId) {
            $project = Project::find($projectId);
            if (!$project) {
                $this->error("❌ Projet #{$projectId} non trouvé");
                return;
            }
            
            $this->info("📋 Test du projet #{$projectId}: {$project->title}");
            $this->info('');
            
            // Test featured_image
            $this->info('🖼️  Image principale:');
            $this->info('   - Chemin BDD: ' . ($project->featured_image ?? 'NULL'));
            $this->info('   - URL complète: ' . $project->featured_image_url);
            $this->info('   - Format FileUpload: [' . ($project->featured_image ?? 'NULL') . ']');
            $this->info('');
            
            // Test gallery_images
            $this->info('🎨 Galerie d\'images:');
            if ($project->gallery_images) {
                foreach ($project->gallery_images as $index => $image) {
                    $this->info("   - Image " . ($index + 1) . ": " . $image);
                }
            } else {
                $this->info('   - Aucune image');
            }
            $this->info('');
            
        } else {
            // Lister tous les projets avec images
            $projects = Project::whereNotNull('featured_image')
                ->orWhereNotNull('gallery_images')
                ->limit(5)
                ->get();
                
            $this->info('📋 Projets avec images (limit 5):');
            $this->info('');
            
            foreach ($projects as $project) {
                $this->info("📁 {$project->title} (ID: {$project->id})");
                $this->info("   🖼️  Featured: " . ($project->featured_image ? '✅' : '❌'));
                $this->info("   🎨  Gallery: " . ($project->gallery_images && count($project->gallery_images) > 0 ? '✅ (' . count($project->gallery_images) . ')' : '❌'));
                $this->info('');
            }
        }
        
        $this->info(str_repeat('=', 60));
        $this->info('🎯 Test Filament v4 terminé');
        $this->info('');
        $this->info('💡 Pour tester dans Filament:');
        $this->info('   1. Vider les caches: php artisan optimize:clear');
        $this->info('   2. Optimiser: php artisan optimize');
        $this->info('   3. Accéder au panneau admin et éditer un projet');
    }
}
