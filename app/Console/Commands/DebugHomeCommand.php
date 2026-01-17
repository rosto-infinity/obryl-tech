<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DebugHomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:home';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Déboguer l affichage des avatars sur la home';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 DÉBOGAGE - HOME AVATARS');
        $this->info(str_repeat('=', 60));

        // 1. Vérifier les développeurs chargés
        $this->info('📋 1. Développeurs avec profil:');
        $featuredDevelopers = User::where('user_type', 'developer')
            ->whereHas('profile')
            ->take(4)
            ->get();

        foreach ($featuredDevelopers as $index => $developer) {
            $this->line("👤 [{$index}] {$developer->name}");
            $this->line("   ID: {$developer->id}");
            $this->line("   Slug: {$developer->slug}");
            $this->line("   Type: " . ($developer->user_type ? $developer->user_type->value : 'NULL'));
            
            if ($developer->profile) {
                $this->line("   ✅ Profil trouvé");
                $this->line("   Avatar: " . ($developer->profile->avatar ?? 'NULL'));
                $this->line("   Avatar URL: " . ($developer->profile->avatar_url ?? 'NULL'));
            } else {
                $this->line("   ❌ Pas de profil");
            }
            $this->line('');
        }

        $this->info(str_repeat('=', 60));

        // 2. Vérifier les fichiers d'avatars
        $this->info('📁 2. Vérification des fichiers:');
        foreach ($featuredDevelopers as $developer) {
            if ($developer->profile && $developer->profile->avatar) {
                $path = storage_path('app/public/' . $developer->profile->avatar);
                $exists = file_exists($path);
                $url = $developer->profile->avatar_url;
                
                $this->line("👤 {$developer->name}:");
                $this->line("   Fichier: {$path}");
                $this->line("   Existe: " . ($exists ? '✅' : '❌'));
                $this->line("   URL: {$url}");
                $this->line("   URL complète: " . url($url));
            }
        }

        $this->info(str_repeat('=', 60));

        // 3. Test des URLs complètes
        $this->info('🌐 3. Test des URLs complètes:');
        foreach ($featuredDevelopers as $developer) {
            if ($developer->profile && $developer->profile->avatar_url) {
                $fullUrl = url($developer->profile->avatar_url);
                $this->line("🔗 {$fullUrl}");
                
                // Test si l'URL répond
                $headers = @get_headers($fullUrl);
                if ($headers && strpos($headers[0], '200')) {
                    $this->line("   ✅ Accessible");
                } else {
                    $this->line("   ❌ Non accessible");
                }
            }
        }

        $this->info(str_repeat('=', 60));
        $this->info('🎯 RECOMMANDATIONS:');
        $this->info('1. Vider le cache navigateur (Ctrl+F5)');
        $this->info('2. Vérifier la console navigateur pour les erreurs');
        $this->info('3. Tester en navigation privée');
        $this->info('4. Vérifier que le lien symbolique public/storage fonctionne');
        
        $this->info(str_repeat('=', 60));
        $this->info('🔧 LIEN SYMBOLIQUE:');
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');
        $this->line("Lien: {$linkPath}");
        $this->line("Cible: {$targetPath}");
        $this->line("Existe: " . (is_link($linkPath) ? '✅' : '❌'));
        $this->line("Pointe vers: " . (is_link($linkPath) ? readlink($linkPath) : 'N/A'));
        
        $this->info(str_repeat('=', 60));
        $this->info('🎉 DÉBOGAGE TERMINÉ !');
    }
}
