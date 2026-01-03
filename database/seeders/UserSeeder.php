<?php

namespace Database\Seeders;

use App\Enums\Auth\UserStatus;
use App\Enums\Auth\UserType;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ FIXÉ : Vérifier si l'admin existe déjà
        if (User::where('email', 'admin@obryl.tech')->exists()) {
            $this->command->info("⚠️  Admin existe déjà, passage...");
            $admin = User::where('email', 'admin@obryl.tech')->first();
        } else {
            // 1. Créer l'administrateur
            $admin = User::create([
                'name' => 'Admin Obryl',
                'email' => 'admin@obryl.tech',  // ✅ FIXÉ : Email unique
                'phone' => '+237 6XX XXX XXX',
                'avatar' => null,
                'user_type' => UserType::ADMIN->value,
                'status' => UserStatus::ACTIVE->value,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ]);

            Profile::create([
                'user_id' => $admin->id,
                'company' => 'Obryl Tech',
                'country' => 'CM',
                'bio' => 'Administrateur de la plateforme Obryl Tech',
            ]);

            $this->command->info("✅ Admin créé : admin@obryl.tech");
        }

        // 2. Créer 5 clients
        $clients = User::factory()
            ->count(5)
            ->client()
            ->create();

        $clientProfiles = [];
        foreach ($clients as $client) {
            $clientProfiles[] = [
                'user_id' => $client->id,
                'company' => fake()->company(),
                'country' => 'CM',
                'bio' => fake()->paragraph(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Profile::insert($clientProfiles);

        $this->command->info("✅ 5 Clients créés");

        // 3. Créer 10 développeurs expérimentés
        $developers = User::factory()
            ->count(10)
            ->developer()
            ->create();

        foreach ($developers as $developer) {
            Profile::factory()
                ->for($developer)
                ->verified()
                ->experienced()
                ->create();
        }

        $this->command->info("✅ 10 Développeurs expérimentés créés");

        // 4. Créer 5 développeurs juniors
        $juniorDevelopers = User::factory()
            ->count(5)
            ->developer()
            ->create();

        foreach ($juniorDevelopers as $developer) {
            Profile::factory()
                ->for($developer)
                ->junior()
                ->create();
        }

        $this->command->info("✅ 5 Développeurs juniors créés");

        // Résumé
        $this->command->info("");
        $this->command->info("╔════════════════════════════════════════════════════════════╗");
        $this->command->info("║                                                            ║");
        $this->command->info("║     ✅ UTILISATEURS CRÉÉS AVEC SUCCÈS !                    ║");
        $this->command->info("║                                                            ║");
        $this->command->info("║  📊 Résumé :                                               ║");
        $this->command->info("║     • 1 Admin (admin@obryl.tech)                           ║");
        $this->command->info("║     • 5 Clients                                            ║");
        $this->command->info("║     • 10 Développeurs expérimentés                         ║");
        $this->command->info("║     • 5 Développeurs juniors                               ║");
        $this->command->info("║                                                            ║");
        $this->command->info("║  🔐 Identifiants de connexion :                            ║");
        $this->command->info("║     Email : admin@obryl.tech                               ║");
        $this->command->info("║     Mot de passe : password                                ║");
        $this->command->info("║                                                            ║");
        $this->command->info("╚════════════════════════════════════════════════════════════╝");
    }
}
