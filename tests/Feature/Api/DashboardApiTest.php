<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Missione;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DashboardApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
    }

    public function test_stats_returns_counts(): void
    {
        $categoria = Categoria::factory()->create();
        CorpoCeleste::factory(3)->create(['categoria_id' => $categoria->id]);
        Missione::factory(2)->create();

        $response = $this->getJson('/api/dashboard/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'totale_corpi_celesti', 'totale_categorie', 'totale_missioni',
            ]);
        $this->assertEquals(3, $response->json('totale_corpi_celesti'));
        $this->assertEquals(1, $response->json('totale_categorie'));
        $this->assertEquals(2, $response->json('totale_missioni'));
    }
}
