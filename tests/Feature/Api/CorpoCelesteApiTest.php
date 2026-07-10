<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CorpoCelesteApiTest extends TestCase
{
    use RefreshDatabase;

    private Categoria $categoria;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
        $this->categoria = Categoria::factory()->create();
    }

    public function test_index_returns_paginated_corpi(): void
    {
        CorpoCeleste::factory(5)->create(['categoria_id' => $this->categoria->id]);

        $response = $this->getJson('/api/corpi-celesti');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
                'meta' => ['current_page', 'last_page', 'total'],
            ]);
        $this->assertCount(5, $response->json('data'));
    }

    public function test_index_filters_by_categoria(): void
    {
        $cat2 = Categoria::factory()->create();
        CorpoCeleste::factory(3)->create(['categoria_id' => $this->categoria->id]);
        CorpoCeleste::factory(2)->create(['categoria_id' => $cat2->id]);

        $response = $this->getJson('/api/corpi-celesti?categoria=' . $cat2->slug);

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    public function test_index_filters_by_tipo(): void
    {
        CorpoCeleste::factory(2)->create(['categoria_id' => $this->categoria->id, 'tipo' => 'gassoso']);
        CorpoCeleste::factory(3)->create(['categoria_id' => $this->categoria->id, 'tipo' => 'roccioso']);

        $response = $this->getJson('/api/corpi-celesti?tipo=gassoso');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    public function test_index_filters_by_in_evidenza(): void
    {
        CorpoCeleste::factory(2)->create(['categoria_id' => $this->categoria->id, 'in_evidenza' => true]);
        CorpoCeleste::factory(3)->create(['categoria_id' => $this->categoria->id, 'in_evidenza' => false]);

        $response = $this->getJson('/api/corpi-celesti?in_evidenza=1');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    public function test_index_searches_by_name(): void
    {
        CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id, 'nome' => 'Saturn']);
        CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id, 'nome' => 'Mars']);
        CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id, 'nome' => 'Venus']);

        $response = $this->getJson('/api/corpi-celesti?search=Sat');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_index_respects_per_page_limit(): void
    {
        CorpoCeleste::factory(20)->create(['categoria_id' => $this->categoria->id]);

        $response = $this->getJson('/api/corpi-celesti?per_page=5');

        $response->assertStatus(200);
        $this->assertCount(5, $response->json('data'));
        $this->assertEquals(5, $response->json('meta')['per_page']);
    }

    public function test_index_caps_per_page_at_100(): void
    {
        CorpoCeleste::factory(20)->create(['categoria_id' => $this->categoria->id]);

        $response = $this->getJson('/api/corpi-celesti?per_page=999');

        $response->assertStatus(200);
        $this->assertEquals(100, $response->json('meta')['per_page']);
    }

    public function test_show_returns_corpo_with_relations(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id]);

        $response = $this->getJson("/api/corpi-celesti/{$corpo->slug}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id', 'nome', 'slug', 'categoria', 'galleria', 'curiosita', 'missioni',
                ],
            ]);
        $this->assertEquals($corpo->slug, $response->json('data.slug'));
    }

    public function test_show_returns_404_for_invalid_slug(): void
    {
        $response = $this->getJson('/api/corpi-celesti/non-existent-slug');

        $response->assertStatus(404);
    }

    public function test_simili_returns_up_to_4_corpi_same_categoria(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id]);
        CorpoCeleste::factory(6)->create(['categoria_id' => $this->categoria->id]);

        $response = $this->getJson("/api/corpi-celesti/{$corpo->slug}/simili");

        $response->assertStatus(200);
        $this->assertCount(4, $response->json('data'));
        $ids = array_column($response->json('data'), 'id');
        $this->assertNotContains($corpo->id, $ids);
    }

    public function test_simili_excludes_current_corpo(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $this->categoria->id]);

        $response = $this->getJson("/api/corpi-celesti/{$corpo->slug}/simili");

        $ids = array_column($response->json('data'), 'id');
        $this->assertNotContains($corpo->id, $ids);
    }
}
