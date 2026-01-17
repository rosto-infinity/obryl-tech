<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Blog\ArticleCategory;
use App\Enums\Blog\ArticleStatus;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        $publishedAt = $this->faker->boolean(70) ? $this->faker->dateTimeBetween('-6 months', 'now') : null;

        return [
            'author_id' => User::where('user_type', 'admin')->inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph(2),
            'content' => $this->generateMarkdownContent(),
            'featured_image' => null, // Sera géré par le seeder si nécessaire
            'status' => $this->faker->randomElement([
                ArticleStatus::DRAFT->value,
                ArticleStatus::PUBLISHED->value,
                ArticleStatus::ARCHIVED->value,
            ]),
            'tags' => $this->faker->randomElements([
                'Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 'Tailwind CSS',
                'MySQL', 'PostgreSQL', 'Docker', 'DevOps', 'API', 'REST',
                'GraphQL', 'Testing', 'Security', 'Performance', 'SEO',
            ], $this->faker->numberBetween(2, 5)),
            'category' => $this->faker->randomElement([
                ArticleCategory::TUTORIAL->value,
                ArticleCategory::NEWS->value,
                ArticleCategory::CASE_STUDY->value,
                ArticleCategory::ANNOUNCEMENT->value,
                ArticleCategory::GUIDE->value,
            ]),
            'seo' => [
                'meta_description' => $this->faker->sentence(15),
                'keywords' => implode(', ', $this->faker->words(8)),
                'og_title' => $title,
                'og_description' => $this->faker->sentence(12),
            ],
            'published_at' => $publishedAt,
            'scheduled_at' => null,
            'views_count' => $publishedAt ? $this->faker->numberBetween(0, 5000) : 0,
            'likes_count' => $publishedAt ? $this->faker->numberBetween(0, 500) : 0,
            'comments_count' => 0,
            'comments' => [],
        ];
    }

    /**
     * Generate realistic Markdown content.
     */
    private function generateMarkdownContent(): string
    {
        $content = '# '.$this->faker->sentence(4)."\n\n";
        $content .= $this->faker->paragraph(3)."\n\n";

        $content .= '## '.$this->faker->sentence(3)."\n\n";
        $content .= $this->faker->paragraph(5)."\n\n";

        $content .= "### Points clés\n\n";
        $content .= '- '.$this->faker->sentence(8)."\n";
        $content .= '- '.$this->faker->sentence(7)."\n";
        $content .= '- '.$this->faker->sentence(9)."\n\n";

        $content .= '## '.$this->faker->sentence(3)."\n\n";
        $content .= $this->faker->paragraph(4)."\n\n";

        $content .= "```php\n";
        $content .= "<?php\n\n";
        $content .= "// Exemple de code\n";
        $content .= "function example() {\n";
        $content .= "    return 'Hello World';\n";
        $content .= "}\n";
        $content .= "```\n\n";

        $content .= $this->faker->paragraph(4)."\n\n";

        $content .= "## Conclusion\n\n";
        $content .= $this->faker->paragraph(3)."\n";

        return $content;
    }

    /**
     * Indicate that the article is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ArticleStatus::PUBLISHED->value,
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the article is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ArticleStatus::DRAFT->value,
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the article is featured (high views/likes).
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => $this->faker->numberBetween(5000, 15000),
            'likes_count' => $this->faker->numberBetween(500, 2000),
        ]);
    }
}
