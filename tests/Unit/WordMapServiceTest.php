<?php

namespace Tests\Unit;

use App\Services\WordMapService;
use Tests\TestCase;

class WordMapServiceTest extends TestCase
{
    private WordMapService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new WordMapService();
    }

    public function test_translate_known_word(): void
    {
        $result = $this->service->translate('Nebulosa');

        $this->assertEquals('Nebula', $result);
    }

    public function test_translate_multiple_words(): void
    {
        $result = $this->service->translate('Nebulosa del Granchio');

        $this->assertEquals('Nebula Crab', $result);
    }

    public function test_translate_removes_prepositions(): void
    {
        $result = $this->service->translate('Nebulosa della calabria');

        $this->assertEquals('Nebula calabria', $result);
    }

    public function test_translate_unknown_word_kept(): void
    {
        $result = $this->service->translate('Zorgon');

        $this->assertEquals('Zorgon', $result);
    }

    public function test_translate_empty_string(): void
    {
        $result = $this->service->translate('');

        $this->assertEquals('', $result);
    }

    public function test_translate_planet_names(): void
    {
        $this->assertEquals('Jupiter', $this->service->translate('Giove'));
        $this->assertEquals('Mars', $this->service->translate('Marte'));
        $this->assertEquals('Earth', $this->service->translate('Terra'));
    }

    public function test_guess_english_name_matches_title(): void
    {
        $items = [
            ['data' => [['title' => 'Crab Nebula', 'keywords' => ['supernova']]]],
            ['data' => [['title' => 'Eagle Nebula', 'keywords' => ['pillars']]]],
        ];

        $result = $this->service->guessEnglishName($items, 'Granchio');

        $this->assertEquals('Crab Nebula', $result);
    }

    public function test_guess_english_name_falls_back_to_first(): void
    {
        $items = [
            ['data' => [['title' => 'Mars Rover', 'keywords' => ['surface']]]],
            ['data' => [['title' => 'Mars Olympus', 'keywords' => ['mountain']]]],
        ];

        $result = $this->service->guessEnglishName($items, 'Zorgon');

        $this->assertEquals('Mars Rover', $result);
    }
}
