<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\GalleriaCorpo;
use App\Models\Missione;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiEdgeCaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
    }

    public function test_search_with_percent_character_does_not_match_all(): void
    {
        $categoria = Categoria::factory()->create();
        CorpoCeleste::factory()->create(['nome' => '100% Object', 'categoria_id' => $categoria->id]);
        CorpoCeleste::factory()->create(['nome' => 'Normal Object', 'categoria_id' => $categoria->id]);

        $response = $this->getJson('/api/corpi-celesti?search=' . urlencode('100%'));

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_search_with_underscore_character_does_not_match_all(): void
    {
        $categoria = Categoria::factory()->create();
        CorpoCeleste::factory()->create(['nome' => 'Test_Object', 'categoria_id' => $categoria->id]);
        CorpoCeleste::factory()->create(['nome' => 'TestObject', 'categoria_id' => $categoria->id]);

        $response = $this->getJson('/api/corpi-celesti?search=Test_Object');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_search_no_results_returns_empty(): void
    {
        $categoria = Categoria::factory()->create();
        CorpoCeleste::factory()->create(['nome' => 'Earth', 'categoria_id' => $categoria->id]);

        $response = $this->getJson('/api/corpi-celesti?search=Zorgon');

        $response->assertStatus(200);
        $this->assertCount(0, $response->json('data'));
    }

    public function test_per_page_zero_defaults_to_one(): void
    {
        $categoria = Categoria::factory()->create();
        CorpoCeleste::factory(3)->create(['categoria_id' => $categoria->id]);

        $response = $this->getJson('/api/corpi-celesti?per_page=0');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_simili_returns_empty_when_no_same_categoria(): void
    {
        $cat1 = Categoria::factory()->create();
        $cat2 = Categoria::factory()->create();
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $cat1->id]);
        CorpoCeleste::factory(3)->create(['categoria_id' => $cat2->id]);

        $response = $this->getJson("/api/corpi-celesti/{$corpo->slug}/simili");

        $response->assertStatus(200);
        $this->assertCount(0, $response->json('data'));
    }

    public function test_missione_index_filters_by_agenzia_and_stato(): void
    {
        Missione::factory()->create(['nome' => 'Apollo 11', 'agenzia' => 'NASA', 'stato' => 'Completata']);
        Missione::factory()->create(['nome' => 'Voyager 1', 'agenzia' => 'NASA', 'stato' => 'In corso']);
        Missione::factory()->create(['nome' => 'Tiangong', 'agenzia' => 'CNSA', 'stato' => 'In corso']);

        $response = $this->getJson('/api/missioni?agenzia=NASA&stato=Completata');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Apollo 11', $response->json('data.0.nome'));
    }

    public function test_missione_index_filters_by_agenzia(): void
    {
        Missione::factory()->create(['agenzia' => 'NASA']);
        Missione::factory()->create(['agenzia' => 'ESA']);
        Missione::factory()->create(['agenzia' => 'NASA']);

        $response = $this->getJson('/api/missioni?agenzia=NASA');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    public function test_missione_index_filters_by_stato(): void
    {
        Missione::factory()->create(['stato' => 'Completata']);
        Missione::factory()->create(['stato' => 'In corso']);

        $response = $this->getJson('/api/missioni?stato=Completata');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_curiosita_index_returns_all(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => Categoria::factory()->create()->id]);
        Curiosita::factory(3)->create(['corpo_celeste_id' => $corpo->id]);

        $response = $this->getJson('/api/curiosita');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_galleria_index_returns_all(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => Categoria::factory()->create()->id]);
        GalleriaCorpo::factory(3)->for($corpo)->create();

        $response = $this->getJson('/api/galleria');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_categoria_index_returns_all(): void
    {
        Categoria::factory(3)->create();

        $response = $this->getJson('/api/categorie');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_empty_database_returns_empty_arrays(): void
    {
        $response = $this->getJson('/api/corpi-celesti');

        $response->assertStatus(200);
        $this->assertCount(0, $response->json('data'));
        $this->assertEquals(0, $response->json('meta.total'));
    }

    public function test_corpo_celeste_factory_creates_categoria(): void
    {
        $corpo = CorpoCeleste::factory()->create();

        $this->assertNotNull($corpo->categoria_id);
        $this->assertDatabaseHas('categorie', ['id' => $corpo->categoria_id]);
    }

    public function test_dashboard_stats_empty_database(): void
    {
        $response = $this->getJson('/api/dashboard/stats');

        $response->assertStatus(200);
        $this->assertEquals(0, $response->json('totale_corpi_celesti'));
        $this->assertEquals(0, $response->json('totale_categorie'));
        $this->assertEquals(0, $response->json('totale_missioni'));
    }

    public function test_corpo_show_includes_galleria(): void
    {
        $categoria = Categoria::factory()->create();
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $categoria->id]);
        GalleriaCorpo::factory(2)->for($corpo)->create();

        $response = $this->getJson("/api/corpi-celesti/{$corpo->slug}");

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data.galleria'));
    }

    public function test_corpo_show_includes_curiosita(): void
    {
        $categoria = Categoria::factory()->create();
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $categoria->id]);
        Curiosita::factory(2)->create(['corpo_celeste_id' => $corpo->id]);

        $response = $this->getJson("/api/corpi-celesti/{$corpo->slug}");

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data.curiosita'));
    }
}
