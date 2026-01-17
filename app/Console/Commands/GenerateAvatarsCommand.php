<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateAvatarsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avatars:generate {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Générer des avatars pour les développeurs';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('🎨 GÉNÉRATION DES AVATARS');
        $this->info(str_repeat('=', 50));

        $developers = User::where('user_type', 'developer')->get();
        $updated = 0;

        foreach ($developers as $developer) {
            if (! $developer->profile) {
                $this->warn("⚠️  Profil manquant pour: {$developer->name}");

                continue;
            }

            if (! $developer->profile->avatar) {
                // Générer un avatar unique
                $avatarName = 'avatar-'.$developer->slug.'-'.time().'.jpg';
                $avatarUrl = 'https://ui-avatars.com/api/?'.http_build_query([
                    'name' => $developer->name,
                    'size' => 400,
                    'background' => '0F172A',
                    'color' => '10B981',
                    'font-size' => 0.6,
                    'rounded' => true,
                    'bold' => true,
                ]);

                try {
                    // Télécharger l'avatar
                    $imageContent = file_get_contents($avatarUrl);

                    // Sauvegarder dans storage
                    $path = 'avatars/'.$avatarName;
                    Storage::disk('public')->put($path, $imageContent);

                    // Mettre à jour le profil
                    $developer->profile->avatar = $path;
                    $developer->profile->save();

                    $this->info("✅ Avatar généré pour: {$developer->name}");
                    $this->line("   Fichier: {$path}");
                    $updated++;
                } catch (\Exception $e) {
                    $this->error("❌ Erreur pour {$developer->name}: {$e->getMessage()}");
                }
            } else {
                $this->line("📌 Avatar existant: {$developer->name}");
            }
        }

        $this->info(str_repeat('=', 50));
        $this->info('📊 RÉSULTATS:');
        $this->info("✅ Avatars générés: {$updated}");
        $this->info("📋 Total développeurs: {$developers->count()}");

        // Créer le lien symbolique si nécessaire
        if (! file_exists(public_path('storage'))) {
            $this->info('🔗 Création du lien symbolique storage...');
            $this->call('storage:link');
        }

        $this->info('🎉 Génération terminée !');
    }
}
