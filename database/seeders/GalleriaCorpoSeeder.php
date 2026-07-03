<?php

namespace Database\Seeders;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Database\Seeder;

class GalleriaCorpoSeeder extends Seeder
{
    public function run(): void
    {
        $galleria = [
            // Sole
            ['slug' => 'sole',           'percorso' => 'galleria/sole-1.jpg',       'didascalia' => 'Il Sole in luce visibile',                              'crediti' => 'NASA/SDO',               'ordine' => 0],
            ['slug' => 'sole',           'percorso' => 'galleria/sole-2.jpg',       'didascalia' => 'Eruzione solare',                                      'crediti' => 'NASA/SDO',               'ordine' => 1],
            // Terra
            ['slug' => 'terra',           'percorso' => 'galleria/terra-1.jpg',     'didascalia' => 'La Terra vista dallo spazio',                           'crediti' => 'NASA/NOAA',              'ordine' => 0],
            ['slug' => 'terra',           'percorso' => 'galleria/terra-2.jpg',     'didascalia' => 'L\'Europa di notte',                                    'crediti' => 'NASA',                   'ordine' => 1],
            // Luna
            ['slug' => 'luna',            'percorso' => 'galleria/luna-1.jpg',      'didascalia' => 'Faccia visibile della Luna',                            'crediti' => 'NASA/LRO',               'ordine' => 0],
            ['slug' => 'luna',            'percorso' => 'galleria/luna-2.jpg',      'didascalia' => 'Superficie lunare',                                    'crediti' => 'NASA',                   'ordine' => 1],
            // Marte
            ['slug' => 'marte',           'percorso' => 'galleria/marte-1.jpg',     'didascalia' => 'Superficie marziana',                                  'crediti' => 'NASA/JPL',               'ordine' => 0],
            ['slug' => 'marte',           'percorso' => 'galleria/marte-2.jpg',     'didascalia' => 'Olympus Mons, il più grande vulcano del sistema solare','crediti' => 'NASA/JPL',               'ordine' => 1],
            // Giove
            ['slug' => 'giove',           'percorso' => 'galleria/giove-1.jpg',     'didascalia' => 'Giove con la Grande Macchia Rossa',                     'crediti' => 'NASA/JPL-Caltech',      'ordine' => 0],
            ['slug' => 'giove',           'percorso' => 'galleria/giove-2.jpg',     'didascalia' => 'Le lune galileiane di Giove',                          'crediti' => 'NASA/JPL',               'ordine' => 1],
            // Saturno
            ['slug' => 'saturno',         'percorso' => 'galleria/saturno-1.jpg',   'didascalia' => 'Saturno e i suoi anelli',                              'crediti' => 'NASA/JPL/SSI',           'ordine' => 0],
            ['slug' => 'saturno',         'percorso' => 'galleria/saturno-2.jpg',   'didascalia' => 'Saturno in controluce',                                'crediti' => 'NASA/JPL/SSI',           'ordine' => 1],
            // Andromeda
            ['slug' => 'andromeda',       'percorso' => 'galleria/andromeda-1.jpg', 'didascalia' => 'Galassia di Andromeda',                                'crediti' => 'NASA/ESA/Hubble',        'ordine' => 0],
            // Orione
            ['slug' => 'nebulosa-di-orione', 'percorso' => 'galleria/orione-1.jpg', 'didascalia' => 'Nebulosa di Orione',                                   'crediti' => 'NASA/ESA/Hubble',        'ordine' => 0],
            ['slug' => 'nebulosa-di-orione', 'percorso' => 'galleria/orione-2.jpg', 'didascalia' => 'Il vivaio stellare di Orione',                        'crediti' => 'NASA/ESA/Hubble',        'ordine' => 1],
            // Plutone
            ['slug' => 'plutone',         'percorso' => 'galleria/plutone-1.jpg',   'didascalia' => 'Plutone visto da New Horizons',                        'crediti' => 'NASA/JHUAPL/SwRI',       'ordine' => 0],
        ];

        foreach ($galleria as $item) {
            $corpo = CorpoCeleste::where('slug', $item['slug'])->first();
            if (!$corpo) continue;

            GalleriaCorpo::create([
                'corpo_celeste_id' => $corpo->id,
                'percorso' => $item['percorso'],
                'didascalia' => $item['didascalia'],
                'crediti' => $item['crediti'],
                'ordine' => $item['ordine'],
            ]);
        }
    }
}
