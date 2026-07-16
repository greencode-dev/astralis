<?php

namespace Tests\Unit;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use App\Services\NasaImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NasaImageServiceTest extends TestCase
{
    use RefreshDatabase;

    private NasaImageService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NasaImageService();
    }

    public function test_search_returns_success_with_mock_response(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA123', 'title' => 'Test Image']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/img.jpg']],
                        ],
                    ],
                ],
            ]),
        ]);

        $result = $this->service->searchNasa('Earth');

        $this->assertTrue($result['success']);
        $this->assertCount(1, $result['items']);
        $this->assertEquals('Earth', $result['used_query']);
    }

    public function test_search_returns_failure_when_no_items(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => ['items' => []],
            ]),
        ]);

        $result = $this->service->searchNasa('NonexistentObjectXYZ');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Nessuna immagine trovata', $result['message']);
    }

    public function test_search_falls_back_to_stripped_query(): void
    {
        $calls = 0;
        Http::fake(function ($request) use (&$calls) {
            $calls++;
            if ($calls === 1) {
                return Http::response(['collection' => ['items' => []]]);
            }
            return Http::response([
                'collection' => [
                    'items' => [
                        ['data' => [['nasa_id' => 'P124', 'title' => 'Found']]],
                    ],
                ],
            ]);
        });

        $result = $this->service->searchNasa("Earth's Moon");

        $this->assertTrue($result['success']);
        $this->assertEquals(2, $calls);
        $this->assertEquals('Earth Moon', $result['used_query']);
    }

    public function test_search_uses_extra_fallbacks(): void
    {
        $calls = 0;
        Http::fake(function ($request) use (&$calls) {
            $calls++;
            if ($calls <= 2) {
                return Http::response(['collection' => ['items' => []]]);
            }
            return Http::response([
                'collection' => [
                    'items' => [
                        ['data' => [['nasa_id' => 'P125', 'title' => 'Fallback Hit']]],
                    ],
                ],
            ]);
        });

        $result = $this->service->searchNasa('Alpha', ['Beta', 'Gamma']);

        $this->assertTrue($result['success']);
        $this->assertEquals('Gamma', $result['used_query']);
    }

    public function test_search_returns_failure_when_all_fallbacks_exhausted(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response(['collection' => ['items' => []]]),
        ]);

        $result = $this->service->searchNasa('Missing', ['Fallback1', 'Fallback2']);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Nessuna immagine trovata', $result['message']);
    }

    public function test_search_continues_on_http_failure(): void
    {
        $calls = 0;
        Http::fake(function ($request) use (&$calls) {
            $calls++;
            if ($calls === 1) {
                return Http::response([], 500);
            }
            return Http::response([
                'collection' => [
                    'items' => [
                        ['data' => [['nasa_id' => 'P126', 'title' => 'Retry OK']]],
                    ],
                ],
            ]);
        });

        $result = $this->service->searchNasa('RetryMe');

        $this->assertTrue($result['success']);
        $this->assertEquals(2, $calls);
    }

    public function test_extract_metadata_returns_expected_keys(): void
    {
        $item = [
            'data' => [
                [
                    'nasa_id' => 'PIA456',
                    'title' => 'Mars Rover',
                    'photographer' => 'NASA',
                    'description' => 'A photo from Mars.',
                    'keywords' => ['mars', 'rover'],
                ],
            ],
        ];

        $metadata = $this->service->extractMetadata($item);

        $this->assertEquals('PIA456', $metadata['nasa_id']);
        $this->assertEquals('Mars Rover', $metadata['title']);
        $this->assertEquals('NASA', $metadata['photographer']);
        $this->assertEquals('A photo from Mars.', $metadata['description']);
        $this->assertEquals(['mars', 'rover'], $metadata['keywords']);
    }

    public function test_extract_metadata_handles_missing_keys(): void
    {
        $metadata = $this->service->extractMetadata(['data' => [[]]]);

        $this->assertNull($metadata['nasa_id']);
        $this->assertNull($metadata['title']);
        $this->assertNull($metadata['photographer']);
        $this->assertNull($metadata['description']);
        $this->assertEquals([], $metadata['keywords']);
    }

    public function test_extract_metadata_falls_back_to_secondary_creator(): void
    {
        $item = [
            'data' => [
                [
                    'nasa_id' => 'PIA789',
                    'title' => 'Hubble Shot',
                    'secondary_creator' => 'Hubble Team',
                    'description' => 'Deep field.',
                ],
            ],
        ];

        $metadata = $this->service->extractMetadata($item);

        $this->assertEquals('Hubble Team', $metadata['photographer']);
    }

    public function test_pick_image_url_prioritizes_alternate(): void
    {
        $item = [
            'links' => [
                ['rel' => 'canonical', 'render' => 'image', 'href' => 'https://example.com/canonical.jpg'],
                ['rel' => 'alternate', 'render' => 'image', 'href' => 'https://example.com/alternate.jpg'],
                ['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/preview.jpg'],
            ],
        ];

        $url = $this->service->pickImageUrl($item);

        $this->assertEquals('https://example.com/alternate.jpg', $url);
    }

    public function test_pick_image_url_falls_back_to_preview(): void
    {
        $item = [
            'links' => [
                ['rel' => 'canonical', 'render' => 'image', 'href' => 'https://example.com/canonical.jpg'],
                ['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/preview.jpg'],
            ],
        ];

        $url = $this->service->pickImageUrl($item);

        $this->assertEquals('https://example.com/preview.jpg', $url);
    }

    public function test_pick_image_url_falls_back_to_canonical(): void
    {
        $item = [
            'links' => [
                ['rel' => 'canonical', 'render' => 'image', 'href' => 'https://example.com/canonical.jpg'],
            ],
        ];

        $url = $this->service->pickImageUrl($item);

        $this->assertEquals('https://example.com/canonical.jpg', $url);
    }

    public function test_pick_image_url_returns_null_when_no_links(): void
    {
        $url = $this->service->pickImageUrl(['links' => []]);

        $this->assertNull($url);
    }

    public function test_pick_image_url_returns_null_when_no_image_links(): void
    {
        $item = [
            'links' => [
                ['rel' => 'preview', 'render' => 'video', 'href' => 'https://example.com/video.mp4'],
            ],
        ];

        $url = $this->service->pickImageUrl($item);

        $this->assertNull($url);
    }

    public function test_import_for_body_skips_if_already_has_image_and_not_force(): void
    {
        $corpo = CorpoCeleste::factory()->create(['immagine' => 'existing.jpg']);

        $result = $this->service->importForBody($corpo, 3, false);

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('già presente', $result['message']);
    }

    public function test_import_for_body_force_overwrites_main_image(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA999', 'title' => 'Fresh']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/fresh.jpg']],
                        ],
                    ],
                ],
            ]),
        ]);

        $corpo = CorpoCeleste::factory()->create([
            'immagine' => 'old.jpg',
            'immagine_utente' => false,
        ]);

        $result = $this->service->importForBody($corpo, 3, true);

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('immagine principale importata', $result['message']);
        $this->assertEquals('https://example.com/fresh.jpg', $corpo->fresh()->immagine);
        $this->assertEquals('PIA999', $corpo->fresh()->nasa_id);
    }

    public function test_import_for_body_force_does_not_overwrite_user_image(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA888', 'title' => 'WontReplace']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/new.jpg']],
                        ],
                    ],
                ],
            ]),
        ]);

        $corpo = CorpoCeleste::factory()->create([
            'immagine' => 'user-uploaded.jpg',
            'immagine_utente' => true,
        ]);

        $result = $this->service->importForBody($corpo, 3, true);

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('già presente', $result['message']);
        $this->assertEquals('user-uploaded.jpg', $corpo->fresh()->immagine);
    }

    public function test_import_for_body_creates_gallery_entries(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA001', 'title' => 'Main']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/main.jpg']],
                        ],
                        [
                            'data' => [['nasa_id' => 'PIA002', 'title' => 'Gallery 1', 'photographer' => 'NASA']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/g1.jpg']],
                        ],
                        [
                            'data' => [['nasa_id' => 'PIA003', 'title' => 'Gallery 2']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/g2.jpg']],
                        ],
                    ],
                ],
            ]),
        ]);

        $corpo = CorpoCeleste::factory()->create([
            'immagine' => null,
            'immagine_utente' => false,
        ]);

        $result = $this->service->importForBody($corpo, 2, true);

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('immagine principale importata', $result['message']);
        $this->assertStringContainsString('2 immagini galleria aggiunte', $result['message']);

        $gallery = GalleriaCorpo::where('corpo_celeste_id', $corpo->id)->get();
        $this->assertCount(2, $gallery);
        $this->assertEquals('https://example.com/g1.jpg', $gallery[0]->percorso);
        $this->assertEquals('Gallery 1', $gallery[0]->didascalia);
        $this->assertEquals('NASA', $gallery[0]->crediti);
        $this->assertEquals(0, $gallery[0]->ordine);
    }

    public function test_import_for_body_skips_duplicate_gallery_entries(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA010', 'title' => 'Main']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/main.jpg']],
                        ],
                        [
                            'data' => [['nasa_id' => 'PIA011', 'title' => 'Dup']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/dup.jpg']],
                        ],
                    ],
                ],
            ]),
        ]);

        $corpo = CorpoCeleste::factory()->create([
            'immagine' => null,
            'immagine_utente' => false,
        ]);

        GalleriaCorpo::factory()->for($corpo)->create([
            'percorso' => 'https://example.com/dup.jpg',
        ]);

        $result = $this->service->importForBody($corpo, 5, true);

        $this->assertStringContainsString('già presenti (skippate)', $result['message']);
    }

    public function test_import_for_body_updates_description_when_requested(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA020', 'title' => 'Desc Update', 'description' => 'NASA description text.']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/img.jpg']],
                        ],
                    ],
                ],
            ]),
        ]);

        $corpo = CorpoCeleste::factory()->create([
            'immagine' => null,
            'descrizione' => 'Old description.',
            'immagine_utente' => false,
        ]);

        $this->service->importForBody($corpo, 3, true, true);

        $this->assertEquals('NASA description text.', $corpo->fresh()->descrizione);
    }

    public function test_import_for_body_does_not_update_description_by_default(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA021', 'title' => 'No Desc Update', 'description' => 'Should be ignored.']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/img.jpg']],
                        ],
                    ],
                ],
            ]),
        ]);

        $corpo = CorpoCeleste::factory()->create([
            'immagine' => null,
            'descrizione' => 'Keep this.',
            'immagine_utente' => false,
        ]);

        $this->service->importForBody($corpo, 3, true);

        $this->assertEquals('Keep this.', $corpo->fresh()->descrizione);
    }

    public function test_import_for_body_returns_failure_when_search_fails(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response(['collection' => ['items' => []]]),
        ]);

        $corpo = CorpoCeleste::factory()->create(['immagine' => null]);

        $result = $this->service->importForBody($corpo, 3, true);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Nessuna immagine trovata', $result['message']);
    }

    public function test_import_for_body_translates_italian_name_via_wordmap(): void
    {
        $calls = 0;
        Http::fake(function ($request) use (&$calls) {
            $calls++;
            $query = $request['q'] ?? '';
            return Http::response([
                'collection' => [
                    'items' => $query === "Halley's Comet"
                        ? [['data' => [['nasa_id' => 'COMET']], 'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/c.jpg']]]]
                        : [],
                ],
            ]);
        });

        $corpo = CorpoCeleste::factory()->create([
            'nome' => 'Cometa di Halley',
            'immagine' => null,
            'immagine_utente' => false,
        ]);

        $result = $this->service->importForBody($corpo, 3, true);

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('immagine principale importata', $result['message']);
    }

    public function test_import_for_body_logs_error_when_item_lacks_image_url(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA030', 'title' => 'No Image']],
                            'links' => [],
                        ],
                    ],
                ],
            ]),
        ]);

        $corpo = CorpoCeleste::factory()->create([
            'immagine' => null,
            'immagine_utente' => false,
        ]);

        $result = $this->service->importForBody($corpo, 3, true);

        $this->assertFalse($result['success']);
        $this->assertNotEmpty($result['errors']);
        $this->assertStringContainsString('nessun URL disponibile', $result['errors'][0]);
    }

    public function test_import_all_returns_correct_counts(): void
    {
        Http::fake([
            'images-api.nasa.gov/*' => Http::response([
                'collection' => [
                    'items' => [
                        [
                            'data' => [['nasa_id' => 'PIA100', 'title' => 'One']],
                            'links' => [['rel' => 'preview', 'render' => 'image', 'href' => 'https://example.com/1.jpg']],
                        ],
                    ],
                ],
            ]),
        ]);

        CorpoCeleste::factory()->count(3)->create([
            'immagine' => null,
            'immagine_utente' => false,
        ]);

        $result = $this->service->importAll(2, true);

        $this->assertEquals(3, $result['success']);
        $this->assertEquals(3, $result['total']);
        $this->assertEquals(3, $result['total_main']);
        $this->assertCount(3, $result['results']);
    }

    public function test_import_all_counts_partial_successes(): void
    {
        $callIndex = 0;
        Http::fake(function ($request) use (&$callIndex) {
            $callIndex++;
            if ($callIndex <= 2) {
                return Http::response([
                    'collection' => [
                        'items' => [
                            [
                                'data' => [['nasa_id' => "PIA{$callIndex}", 'title' => 'OK']],
                                'links' => [['rel' => 'preview', 'render' => 'image', 'href' => "https://example.com/{$callIndex}.jpg"]],
                            ],
                        ],
                    ],
                ]);
            }
            return Http::response(['collection' => ['items' => []]]);
        });

        CorpoCeleste::factory()->count(3)->create([
            'immagine' => null,
            'immagine_utente' => false,
        ]);

        $result = $this->service->importAll(2, true);

        $this->assertEquals(2, $result['success']);
        $this->assertEquals(3, $result['total']);
    }
}
