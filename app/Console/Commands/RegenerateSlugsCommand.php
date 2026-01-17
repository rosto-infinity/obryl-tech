<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class RegenerateSlugsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slugs:regenerate {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regénérer tous les slugs des utilisateurs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('⚠️  Ceci va regénérer tous les slugs. Continuer?')) {
                $this->info('❌ Opération annulée');
                return;
            }
        }

        $this->info('🔄 RÉGÉNÉRATION DES SLUGS');
        $this->info(str_repeat('=', 50));

        $users = User::all();
        $updated = 0;
        $unchanged = 0;

        foreach ($users as $user) {
            $oldSlug = $user->slug;
            $newSlug = $user->generateSlug();
            
            if ($oldSlug !== $newSlug) {
                $user->slug = $newSlug;
                $user->save();
                
                $this->line("✅ {$user->name}");
                $this->line("   Avant: {$oldSlug}");
                $this->line("   Après:  {$newSlug}");
                $this->line('');
                $updated++;
            } else {
                $unchanged++;
            }
        }

        $this->info(str_repeat('=', 50));
        $this->info("📊 RÉSULTATS:");
        $this->info("✅ Mis à jour: {$updated} utilisateurs");
        $this->info("📌 Inchangés: {$unchanged} utilisateurs");
        $this->info("📋 Total: {$users->count()} utilisateurs");

        // Vider les caches
        $this->info('🧹 Vidage des caches...');
        $this->call('optimize:clear');
        $this->call('optimize');

        $this->info('🎉 Slugs regénérés avec succès !');
    }
}
