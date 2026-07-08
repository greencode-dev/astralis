<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GalleriaApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
        CorpoCeleste::unsetEventDispatcher();
    }

    protected function tearDown(): void
    {
        CorpoCeleste::setEventDispatcher(app('events'));
        parent::tearDown();
    }

    public function test_index_returns_all_galleria(): void
    {
        $categoria = Categoria::factory()->create();
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => $categoria->id]);
        GalleriaCorpo::factory(3)->create(['corpo_celeste_id' => $corpo->id]);

        $response = $this->getJson('/api/galleria');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }
}
