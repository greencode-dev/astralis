<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RateLimitingTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_corpi_celesti_returns_200_under_limit(): void
    {
        $response = $this->getJson('/api/corpi-celesti');

        $response->assertStatus(200);
    }

    public function test_api_corpi_celesti_returns_429_when_rate_limited(): void
    {
        for ($i = 0; $i < 61; $i++) {
            $response = $this->getJson('/api/corpi-celesti');
        }

        $response->assertStatus(429);
    }

    public function test_api_corpo_celeste_show_returns_404_for_missing(): void
    {
        $response = $this->getJson('/api/corpi-celesti/non-esistente');

        $response->assertStatus(404);
    }

    public function test_api_categorie_returns_200_under_limit(): void
    {
        $response = $this->getJson('/api/categorie');

        $response->assertStatus(200);
    }

    public function test_api_missioni_returns_200_under_limit(): void
    {
        $response = $this->getJson('/api/missioni');

        $response->assertStatus(200);
    }

    public function test_api_curiosita_returns_200_under_limit(): void
    {
        $response = $this->getJson('/api/curiosita');

        $response->assertStatus(200);
    }

    public function test_api_galleria_returns_200_under_limit(): void
    {
        $response = $this->getJson('/api/galleria');

        $response->assertStatus(200);
    }

    public function test_api_dashboard_stats_returns_200_under_limit(): void
    {
        $response = $this->getJson('/api/dashboard/stats');

        $response->assertStatus(200);
    }
}
