<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WordMapService
{
    public const CUSTOM_MAP_PATH = 'wordmap-custom.json';

    private ?array $mergedMap = null;

    private array $wordMap = [
        'Nebulosa di Orione' => 'Orion Nebula',
        'Cometa di Halley' => "Halley's Comet",
        'Nebulosa' => 'Nebula',
        'Cometa' => 'Comet',
        'Galassia' => 'Galaxy',
        'Pianeta' => 'Planet',
        'Stella' => 'Star',
        'Asteroide' => 'Asteroid',
        'Luna' => 'Moon',
        'Sole' => 'Sun',
        'Satellite' => 'Moon',
        'Anello' => 'Ring',
        'Buco Nero' => 'Black Hole',
        'Ammasso' => 'Cluster',
        'Nana' => 'Dwarf',
        'Grande' => 'Great',
        'Piccola' => 'Small',
        'Nube' => 'Cloud',
        'Nuvola' => 'Cloud',
        'Via Lattea' => 'Milky Way',
        'Martello' => 'Hammer',
        'Boomerang' => 'Boomerang',
        'Falce' => 'Sickle',
        'Orsa' => 'Bear',
        'Cane' => 'Dog',
        'Granchio' => 'Crab',
        'Testa' => 'Head',
        'Coda' => 'Tail',
        'Giove' => 'Jupiter',
        'Marte' => 'Mars',
        'Venere' => 'Venus',
        'Mercurio' => 'Mercury',
        'Saturno' => 'Saturn',
        'Urano' => 'Uranus',
        'Nettuno' => 'Neptune',
        'Plutone' => 'Pluto',
        'Orione' => 'Orion',
        'Terra' => 'Earth',
        'Cerere' => 'Ceres',
        'Caronte' => 'Charon',
        'Europa' => 'Europa',
        'Titano' => 'Titan',
        'Encelado' => 'Enceladus',
        'Io' => 'Io',
        'Callisto' => 'Callisto',
        'Ganimede' => 'Ganymede',
        'Tritone' => 'Triton',
        'Fobos' => 'Phobos',
        'Deimos' => 'Deimos',
        'Titania' => 'Titania',
        'Oberon' => 'Oberon',
        'di' => '',
        'del' => '',
        'della' => '',
        'dell' => '',
        'degli' => '',
        'delle' => '',
        'con' => '',
        'per' => '',
        'tra' => '',
        'fra' => '',
        'sul' => '',
        'sulla' => '',
        'sulle' => '',
        'nell' => '',
        'nella' => '',
        'nelle' => '',
        'agli' => '',
        'alle' => '',
        'dal' => '',
        'dalla' => '',
        'dalle' => '',
    ];

    public function translate(string $nomeIt): string
    {
        $result = $nomeIt;

        $phrases = collect($this->map())
            ->filter(fn($v, $k) => str_contains($k, ' '))
            ->sortBy(fn($v, $k) => -str_word_count($k));

        foreach ($phrases as $it => $en) {
            $result = str_ireplace($it, $en, $result);
        }

        return collect(explode(' ', $result))
            ->map(fn($w) => $this->map()[ucfirst($w)] ?? $this->map()[$w] ?? $w)
            ->filter()
            ->implode(' ');
    }

    /**
     * Merge the static wordMap with the persisted custom map
     * (storage/app/wordmap-custom.json). Custom entries take precedence.
     */
    private function map(): array
    {
        if ($this->mergedMap !== null) {
            return $this->mergedMap;
        }

        $custom = [];
        if (Storage::disk('local')->exists(self::CUSTOM_MAP_PATH)) {
            $custom = json_decode(
                Storage::disk('local')->get(self::CUSTOM_MAP_PATH),
                true
            ) ?: [];
        }

        $this->mergedMap = array_merge($this->wordMap, $custom);

        return $this->mergedMap;
    }

    /**
     * Persist a new Italian→English mapping learned from the
     * MyMemory fallback so the offline map stays populated.
     */
    public function saveCustomTranslation(string $it, string $en): void
    {
        $it = trim($it);
        $en = trim($en);

        if ($it === '' || $en === '' || strcasecmp($it, $en) === 0) {
            return;
        }

        $custom = [];
        if (Storage::disk('local')->exists(self::CUSTOM_MAP_PATH)) {
            $custom = json_decode(
                Storage::disk('local')->get(self::CUSTOM_MAP_PATH),
                true
            ) ?: [];
        }

        $custom[$it] = $en;
        $this->mergedMap = null;

        Storage::disk('local')->put(
            self::CUSTOM_MAP_PATH,
            json_encode($custom, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function guessEnglishName(array $items, string $query): ?string
    {
        $words = array_filter(explode(' ', strtolower($query)));
        $best = null;
        $bestScore = 0;

        foreach ($items as $item) {
            $title = $item['data'][0]['title'] ?? '';
            $keywords = $item['data'][0]['keywords'] ?? [];
            $all = strtolower($title . ' ' . implode(' ', $keywords));

            $score = 0;
            foreach ($words as $w) {
                if (str_contains($all, $w)) {
                    $score++;
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $title;
            }
        }

        return $bestScore > 0 ? $best : ($items[0]['data'][0]['title'] ?? null);
    }

    public function translateWithApi(string $nomeIt): ?string
    {
        $cleaned = $this->cleanTranslationInput($nomeIt);

        try {
            $http = Http::timeout(10)->retry(2, 500);
            if (app()->environment('local', 'testing')) {
                $http = $http->withoutVerifying();
            }

            $response = $http->get('https://api.mymemory.translated.net/get', [
                'q' => $cleaned,
                'langpair' => 'it|en',
            ]);

            if ($response->failed()) {
                return null;
            }

            $translated = $response->json('responseData.translatedText', '');
            $result = $this->cleanTranslationOutput($translated, $cleaned);

            if ($result && $result !== $cleaned) {
                $this->saveCustomTranslation($cleaned, $result);

                return $result;
            }

            $matches = $response->json('matches', []);
            foreach ($matches as $match) {
                $candidate = $this->cleanTranslationOutput($match['translation'] ?? '', $cleaned);
                if ($candidate && $candidate !== $cleaned) {
                    return $candidate;
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::warning('MyMemory translation failed', [
                'input' => $nomeIt,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    private function cleanTranslationInput(string $input): string
    {
        $input = trim($input);
        $input = preg_replace('/\s+/', ' ', $input);
        return $input;
    }

    private function cleanTranslationOutput(string $translated, string $original): string
    {
        $translated = trim($translated);
        $translated = preg_replace('/^[aA]\s+/', '', $translated);
        $translated = preg_replace('/^[aA]n\s+/', '', $translated);
        $translated = preg_replace('/^[Tt]he\s+/', '', $translated);
        $translated = rtrim($translated, '.,;:!?');
        $translated = trim($translated);

        if (strtolower($translated) === strtolower($original)) {
            return '';
        }

        return $translated;
    }
}
