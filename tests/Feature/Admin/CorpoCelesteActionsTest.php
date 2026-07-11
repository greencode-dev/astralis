<?php

namespace Tests\Feature\Admin;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Services\NasaImageService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CorpoCelesteActionsTest extends AdminTestCase
{
    private CorpoCeleste $corpo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->corpo = CorpoCeleste::factory()->create();
    }

    public function test_suggest_nome_requires_nome_it(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), []);

        $response->assertInvalid(['nome_it']);
    }

    public function test_suggest_nome_returns_suggestion_when_nasa_matches(): void
    {
        Cache::flush();

        $mock = \Mockery::mock(NasaImageService::class);
        $mock->shouldReceive('searchNasa')
            ->once()
            ->with('Jupiter')
            ->andReturn([
                'success' => true,
                'items' => [
                    [
                        'data' => [
                            [
                                'title' => 'Jupiter',
                                'keywords' => ['planet', 'Jupiter'],
                            ],
                        ],
                    ],
                ],
            ]);
        $this->app->instance(NasaImageService::class, $mock);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome_it' => 'Giove']);

        $response->assertOk()
            ->assertJson(['success' => true, 'nome' => 'Jupiter']);
    }

    public function test_suggest_nome_returns_failure_when_no_results(): void
    {
        Cache::flush();

        $mock = \Mockery::mock(NasaImageService::class);
        $mock->shouldReceive('searchNasa')
            ->once()
            ->andReturn([
                'success' => false,
                'message' => 'No results',
            ]);
        $this->app->instance(NasaImageService::class, $mock);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome_it' => 'Xyznotexist']);

        $response->assertOk()
            ->assertJson(['success' => false]);
    }

    public function test_suggest_nome_guest_cannot_access(): void
    {
        $response = $this->postJson(route('admin.corpi-celesti.suggest-nome'), ['nome_it' => 'Giove']);

        $response->assertRedirect();
    }

    public function test_set_image_from_gallery_updates_immagine(): void
    {
        $galleria = GalleriaCorpo::factory()->for($this->corpo)->create([
            'percorso' => 'new-image.jpg',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertRedirect(route('admin.corpi-celesti.show', $this->corpo));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('corpi_celesti', [
            'id' => $this->corpo->id,
            'immagine' => 'new-image.jpg',
            'immagine_utente' => true,
        ]);
    }

    public function test_set_image_from_gallery_rejects_wrong_ownership(): void
    {
        $otherCorpo = CorpoCeleste::factory()->create();
        $galleria = GalleriaCorpo::factory()->for($otherCorpo)->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertNotFound();
    }

    public function test_set_image_guest_cannot_access(): void
    {
        $galleria = GalleriaCorpo::factory()->for($this->corpo)->create();

        $response = $this->post(route('admin.corpi-celesti.set-image', [$this->corpo, $galleria]));

        $response->assertRedirect('/login');
    }
}
