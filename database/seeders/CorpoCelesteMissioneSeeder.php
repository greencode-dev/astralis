<?php

namespace Database\Seeders;

use App\Models\CorpoCeleste;
use App\Models\Missione;
use Illuminate\Database\Seeder;

class CorpoCelesteMissioneSeeder extends Seeder
{
    public function run(): void
    {
        $relazioni = [
            'apollo-11' => ['luna'],
            'voyager-1' => ['giove', 'saturno'],
            'voyager-2' => ['giove', 'saturno', 'urano', 'nettuno'],
            'hubble-space-telescope' => ['nebulosa-di-orione', 'andromeda'],
            'mars-pathfinder' => ['marte'],
            'cassini-huygens' => ['saturno', 'titano'],
            'mars-science-laboratory-curiosity' => ['marte'],
            'james-webb-space-telescope' => ['nebulosa-di-orione', 'andromeda', 'via-lattea'],
            'artemis-i' => ['luna'],
        ];

        foreach ($relazioni as $missioneSlug => $corpiSlugs) {
            $missione = Missione::where('slug', $missioneSlug)->first();
            if (!$missione) continue;

            foreach ($corpiSlugs as $corpoSlug) {
                $corpo = CorpoCeleste::where('slug', $corpoSlug)->first();
                if (!$corpo) continue;

                $missione->corpiCelesti()->syncWithoutDetaching([$corpo->id => [
                    'tipo_esplorazione' => match ($missioneSlug) {
                        'apollo-11', 'artemis-i' => 'missione con equipaggio',
                        'voyager-1', 'voyager-2', 'cassini-huygens' => 'sorvolo ravvicinato',
                        'mars-pathfinder', 'mars-science-laboratory-curiosity' => 'atterraggio con rover',
                        'hubble-space-telescope', 'james-webb-space-telescope' => 'osservazione remota',
                        default => 'esplorazione',
                    },
                    'anno_arrivo' => match ($missioneSlug) {
                        'apollo-11' => 1969,
                        'voyager-1' => 1979,
                        'voyager-2' => 1979,
                        'mars-pathfinder' => 1997,
                        'cassini-huygens' => 2004,
                        'mars-science-laboratory-curiosity' => 2012,
                        'artemis-i' => 2022,
                        default => null,
                    },
                ]]);
            }
        }
    }
}
