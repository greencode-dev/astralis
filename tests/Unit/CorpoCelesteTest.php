<?php

namespace Tests\Unit;

use App\Models\CorpoCeleste;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CorpoCelesteTest extends TestCase
{
    use RefreshDatabase;

    public function test_nome_display_returns_nome_it_when_set(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'nome' => 'Jupiter',
            'nome_it' => 'Giove',
        ]);

        $this->assertEquals('Giove', $corpo->nome_display);
    }

    public function test_nome_display_returns_nome_when_nome_it_is_null(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'nome' => 'Jupiter',
            'nome_it' => null,
        ]);

        $this->assertEquals('Jupiter', $corpo->nome_display);
    }

    public function test_nome_display_returns_empty_string_when_nome_it_is_empty(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'nome' => 'Jupiter',
            'nome_it' => '',
        ]);

        $this->assertEquals('', $corpo->nome_display);
    }

    public function test_immagine_url_returns_null_when_no_image(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'immagine' => null,
        ]);

        $this->assertNull($corpo->immagine_url);
    }

    public function test_immagine_url_returns_http_url_as_is(): void
    {
        $url = 'https://example.com/image.jpg';
        $corpo = CorpoCeleste::factory()->create([
            'immagine' => $url,
        ]);

        $this->assertEquals($url, $corpo->immagine_url);
    }

    public function test_immagine_url_returns_storage_url_for_local_filename(): void
    {
        $corpo = CorpoCeleste::factory()->create([
            'immagine' => 'planets/jupiter.jpg',
        ]);

        $expected = Storage::url('corpi-celesti/planets/jupiter.jpg');
        $this->assertEquals($expected, $corpo->immagine_url);
    }
}
