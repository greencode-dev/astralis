<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CategoriaApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
    }

    public function test_index_returns_all_categorie(): void
    {
        Categoria::factory(3)->create();

        $response = $this->getJson('/api/categorie');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_show_returns_categoria_with_corpi_count(): void
    {
        $categoria = Categoria::factory()->create();
        CorpoCeleste::factory(2)->create(['categoria_id' => $categoria->id]);

        $response = $this->getJson("/api/categorie/{$categoria->slug}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'nome', 'slug']]);
        $this->assertEquals($categoria->slug, $response->json('data.slug'));
    }

    public function test_show_returns_404_for_invalid_slug(): void
    {
        $response = $this->getJson('/api/categorie/non-existent');

        $response->assertStatus(404);
    }
}
