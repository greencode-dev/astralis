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

    public function test_stats_returns_corpi_in_evidenza(): void
    {
        $categoria = Categoria::factory()->create();
        CorpoCeleste::factory(2)->create(['categoria_id' => $categoria->id, 'in_evidenza' => true]);
        CorpoCeleste::factory(1)->create(['categoria_id' => $categoria->id, 'in_evidenza' => false]);

        $response = $this->getJson('/api/dashboard/stats');

        $response->assertStatus(200);
        $this->assertEquals(2, $response->json('corpi_in_evidenza'));
    }

    public function test_stats_returns_ultimi_corpi(): void
    {
        $categoria = Categoria::factory()->create();
        CorpoCeleste::factory(3)->create(['categoria_id' => $categoria->id]);

        $response = $this->getJson('/api/dashboard/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'ultimi_corpi' => [
                    '*' => ['id', 'nome', 'slug', 'categoria', 'tipo'],
                ],
            ]);
        $this->assertCount(3, $response->json('ultimi_corpi'));
    }

    public function test_stats_returns_missioni_per_stato(): void
    {
        Missione::factory(2)->create(['stato' => 'Completata']);
        Missione::factory(1)->create(['stato' => 'In corso']);
        Missione::factory(1)->create(['stato' => 'Pianificata']);

        $response = $this->getJson('/api/dashboard/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'missioni_per_stato' => ['completate', 'in_corso', 'pianificate'],
            ]);
        $this->assertEquals(2, $response->json('missioni_per_stato.completate'));
        $this->assertEquals(1, $response->json('missioni_per_stato.in_corso'));
        $this->assertEquals(1, $response->json('missioni_per_stato.pianificate'));
    }
}
