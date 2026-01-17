<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Project\ProjectStatus;
use App\Models\Commission;
use App\Models\Project;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::where('user_type', 'client')->get();
        $developers = User::where('user_type', 'developer')->get();

        // 1. Créer 5 projets en attente
        $this->command->info('📋 Création des projets en attente...');
        Project::factory()
            ->count(5)
            ->create([
                'status' => ProjectStatus::PENDING->value,
            ]);

        // 2. Créer 8 projets en cours
        $this->command->info('⚙️ Création des projets en cours...');
        Project::factory()
            ->count(8)
            ->inProgress()
            ->create();

        // 3. Créer 5 projets complétés
        $this->command->info('✅ Création des projets complétés...');
        $completedProjects = Project::factory()
            ->count(5)
            ->completed()
            ->create();

        // 4. Créer 5 projets publiés en vedette
        $this->command->info('⭐ Création des projets publiés...');
        Project::factory()
            ->count(5)
            ->published()
            ->featured()
            ->create();

        // 5. Pour chaque projet complété, créer des avis et commissions
        $this->command->info('📝 Création des avis et commissions...');

        foreach ($completedProjects as $project) {
            // ✅ FIXÉ : Créer des avis avec des développeurs DIFFÉRENTS
            // Puisqu'il y a une contrainte unique (project_id, developer_id)
            $reviewCount = rand(2, 3);
            $selectedDevelopers = $developers->random($reviewCount);

            foreach ($selectedDevelopers as $developer) {
                Review::create([
                    'project_id' => $project->id,
                    'client_id' => $project->client_id,
                    'developer_id' => $developer->id,
                    'rating' => rand(3, 5),
                    'comment' => fake()->paragraph(),
                    'status' => 'approved',
                    'criteria' => json_encode([
                        'quality' => rand(3, 5),
                        'communication' => rand(3, 5),
                        'timeliness' => rand(3, 5),
                        'professionalism' => rand(3, 5),
                    ]),
                ]);
            }

            // ✅ FIXÉ : Créer des commissions avec des développeurs DIFFÉRENTS
            $commissionCount = rand(1, 2);
            $selectedDevForCommission = $developers->random($commissionCount);

            foreach ($selectedDevForCommission as $developer) {
                Commission::create([
                    'project_id' => $project->id,
                    'developer_id' => $developer->id,
                    'amount' => rand(10000, 100000),
                    'currency' => 'XAF',
                    'percentage' => rand(10, 50),
                    'status' => 'approved',
                    'type' => 'project_completion',
                    'description' => fake()->sentence(),
                    'breakdown' => json_encode([
                        'base' => rand(8000, 80000),
                        'bonus' => rand(1000, 10000),
                        'tax' => rand(1000, 10000),
                    ]),
                    'approved_at' => now()->subDays(5),
                    'approved_by' => User::where('user_type', 'admin')->first()->id,
                    'payment_details' => json_encode([
                        'method' => 'bank_transfer',
                        'account' => '****'.rand(1000, 9999),
                    ]),
                ]);
            }
        }

        // 6. Créer quelques commissions payées supplémentaires
        $this->command->info('💰 Création des commissions payées...');

        $projects = Project::inRandomOrder()->limit(3)->get();
        foreach ($projects as $project) {
            $developer = $developers->random();

            // Vérifier si une commission existe déjà pour ce projet/développeur
            $existingCommission = Commission::where('project_id', $project->id)
                ->where('developer_id', $developer->id)
                ->exists();

            if (! $existingCommission) {
                Commission::create([
                    'project_id' => $project->id,
                    'developer_id' => $developer->id,
                    'amount' => rand(10000, 100000),
                    'currency' => 'XAF',
                    'percentage' => rand(10, 50),
                    'status' => 'paid',
                    'type' => 'bonus',
                    'description' => fake()->sentence(),
                    'breakdown' => json_encode([
                        'base' => rand(8000, 80000),
                        'bonus' => rand(1000, 10000),
                        'tax' => rand(1000, 10000),
                    ]),
                    'approved_at' => now()->subDays(10),
                    'paid_at' => now()->subDays(3),
                    'approved_by' => User::where('user_type', 'admin')->first()->id,
                    'payment_details' => json_encode([
                        'method' => 'bank_transfer',
                        'account' => '****'.rand(1000, 9999),
                    ]),
                ]);
            }
        }

        // Résumé
        $this->command->info('');
        $this->command->info('╔════════════════════════════════════════════════════════════╗');
        $this->command->info('║  ✅ PROJETS CRÉÉS AVEC SUCCÈS !                            ║');
        $this->command->info('║                                                            ║');
        $this->command->info('║  📊 Résumé :                                               ║');
        $this->command->info('║     • 5 Projets en attente                                 ║');
        $this->command->info('║     • 8 Projets en cours                                   ║');
        $this->command->info('║     • 5 Projets complétés (avec avis et commissions)       ║');
        $this->command->info('║     • 5 Projets publiés en vedette                         ║');
        $this->command->info('║     • 3+ Commissions payées                                ║');
        $this->command->info('║                                                            ║');
        $this->command->info('║  📈 Statistiques :                                         ║');
        $this->command->info('║     • '.Project::count().' Projets total');
        $this->command->info('║     • '.Review::count().' Avis total');
        $this->command->info('║     • '.Commission::count().' Commissions total');
        $this->command->info('║                                                            ║');
        $this->command->info('╚════════════════════════════════════════════════════════════╝');
    }
}
