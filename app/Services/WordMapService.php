<?php

namespace App\Services;

class WordMapService
{
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
        $input = $nomeIt;

        foreach ($this->wordMap as $key => $value) {
            if (str_contains($key, ' ') && str_contains(mb_strtolower($input), mb_strtolower($key))) {
                $input = str_ireplace($key, $value, $input);
            }
        }

        return collect(explode(' ', $input))
            ->map(fn($w) => $this->wordMap[ucfirst($w)] ?? $this->wordMap[$w] ?? $w)
            ->filter()
            ->implode(' ');
    }

    public function guessEnglishName(array $items, string $query): ?string
    {
        $lower = strtolower($query);
        foreach ($items as $item) {
            $title = $item['data'][0]['title'] ?? '';
            $keywords = $item['data'][0]['keywords'] ?? [];
            $all = $title . ' ' . implode(' ', $keywords);

            if (preg_match('/\b' . preg_quote($lower, '/') . '\b/i', $all)) {
                return $title;
            }
        }

        return $items[0]['data'][0]['title'] ?? null;
    }
}
