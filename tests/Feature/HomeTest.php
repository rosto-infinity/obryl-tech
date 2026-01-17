<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_home_page_renders_correctly(): void
    {
        // Seeding isn't strictly necessary if it handles empty states,
        // but the error showed it failed on Article query.
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('OBRYL');
        $response->assertSee('TECH');
        $response->assertSee('Portfolio');
        $response->assertSee('Insights');
        $response->assertSee('REJOINDRE L\'AVENTURE', false);
    }
}
