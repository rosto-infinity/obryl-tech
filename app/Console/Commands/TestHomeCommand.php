<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestHomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:home';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester l affichage des avatars sur la home';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('🧪 TEST DES AVATARS - HOME');
        $this->info(str_repeat('=', 50));

        $developers = \App\Models\User::where('user_type', 'developer')->take(5)->get();

        foreach ($developers as $developer) {
            $this->line("👤 Nom: {$developer->name}");

            if ($developer->profile && $developer->profile->avatar_url) {
                $this->info("✅ Avatar: {$developer->profile->avatar_url}");
                $this->info('🌐 URL complète: '.url($developer->profile->avatar_url));
            } else {
                $this->warn("⚠️  Pas d'avatar dans le profil");
                $this->info('🔄 Fallback: ui-avatars.com');
            }

            $this->line(str_repeat('-', 50));
        }

        $this->info(str_repeat('=', 50));
        $this->info('🌐 Test des URLs...');

        foreach ($developers as $developer) {
            if ($developer->profile && $developer->profile->avatar_url) {
                $fullUrl = url($developer->profile->avatar_url);
                $this->line("🔗 {$fullUrl}");

                // Test si le fichier existe
                $path = storage_path('app/public/'.$developer->profile->avatar);
                if (file_exists($path)) {
                    $this->info("✅ Fichier existe: {$path}");
                } else {
                    $this->error("❌ Fichier manquant: {$path}");
                }
            }
        }

        $this->info(str_repeat('=', 50));
        $this->info('🎉 TEST TERMINÉ !');
        $this->info('📱 Visitez: '.url('/'));
    }
}
