<?php

namespace Database\Seeders;

use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use Illuminate\Database\Seeder;

class CuriositaSeeder extends Seeder
{
    public function run(): void
    {
        $curiosita = [
            ['slug' => 'sole',              'titolo' => 'Capienza Terra',             'descrizione' => 'Il Sole è così grande che al suo interno potrebbero entrare circa 1.3 milioni di Terre.',                                 'fonte' => 'NASA'],
            ['slug' => 'sole',              'titolo' => 'Età del Sole',               'descrizione' => 'Il Sole ha circa 4.6 miliardi di anni ed è a metà del suo ciclo vitale.',                                               'fonte' => 'NASA'],
            ['slug' => 'terra',             'titolo' => 'Unico pianeta con vita',     'descrizione' => 'La Terra è l\'unico pianeta conosciuto ad ospitare la vita, con oltre 8.7 milioni di specie stimate.',               'fonte' => 'National Geographic'],
            ['slug' => 'terra',             'titolo' => 'Oceano profondo',            'descrizione' => 'Il punto più profondo dell\'oceano, la Fossa delle Marianne, raggiunge circa 11 km di profondità.',                    'fonte' => 'NOAA'],
            ['slug' => 'luna',              'titolo' => 'Allontanamento',             'descrizione' => 'La Luna si allontana dalla Terra di circa 3.8 cm ogni anno.',                                                           'fonte' => 'NASA'],
            ['slug' => 'luna',              'titolo' => 'Faccia nascosta',            'descrizione' => 'La Luna mostra sempre la stessa faccia alla Terra. Il lato nascosto è stato fotografato per la prima volta nel 1959.',  'fonte' => 'Roscosmos'],
            ['slug' => 'marte',             'titolo' => 'Monte più alto',             'descrizione' => 'Marte ospita l\'Olympus Mons, il più grande vulcano del sistema solare, alto circa 21.9 km.',                          'fonte' => 'NASA'],
            ['slug' => 'marte',             'titolo' => 'Tramonti blu',               'descrizione' => 'Su Marte i tramonti sono di colore blu, a causa della dispersione della luce da parte della polvere fine nell\'atmosfera.', 'fonte' => 'NASA'],
            ['slug' => 'giove',             'titolo' => 'Grande Macchia Rossa',       'descrizione' => 'La Grande Macchia Rossa di Giove è una tempesta anticiclonica più grande della Terra, osservata da oltre 350 anni.',  'fonte' => 'NASA'],
            ['slug' => 'giove',             'titolo' => 'Più lune',                   'descrizione' => 'Giove ha oltre 95 lune conosciute, tra cui Io, Europa, Ganimede e Callisto.',                                          'fonte' => 'NASA'],
            ['slug' => 'saturno',           'titolo' => 'Anelli immensi',             'descrizione' => 'Gli anelli di Saturno si estendono fino a 282.000 km dal pianeta, ma hanno uno spessore di soli 10 metri.',         'fonte' => 'NASA'],
            ['slug' => 'saturno',           'titolo' => 'Galleggerebbe',              'descrizione' => 'Saturno ha una densità così bassa che, se esistesse una vasca d\'acqua abbastanza grande, il pianeta galleggerebbe.','fonte' => 'NASA'],
            ['slug' => 'plutone',           'titolo' => 'Declassato',                 'descrizione' => 'Plutone è stato riclassificato da pianeta a pianeta nano nel 2006 dall\'Unione Astronomica Internazionale.',          'fonte' => 'IAU'],
            ['slug' => 'plutone',           'titolo' => 'Cuore di ghiaccio',          'descrizione' => 'Plutone ha una caratteristica formazione a forma di cuore chiamata Tombaugh Regio.',                                     'fonte' => 'NASA'],
            ['slug' => 'andromeda',         'titolo' => 'Collisione futura',          'descrizione' => 'La Galassia di Andromeda si sta avvicinando alla Via Lattea a 110 km/s. La collisione è prevista tra circa 4.5 miliardi di anni.', 'fonte' => 'ESA'],
            ['slug' => 'cometa-di-halley',  'titolo' => 'Visita storica',             'descrizione' => 'La Cometa di Halley è stata osservata fin dal 240 a.C. La sua orbita è stata calcolata per la prima volta da Edmond Halley nel 1705.', 'fonte' => 'ESA'],
            ['slug' => 'europa',            'titolo' => 'Oceano nascosto',            'descrizione' => 'Sotto la crosta ghiacciata di Europa si estende un oceano globale d\'acqua liquida con più acqua di tutti gli oceani della Terra messi insieme.', 'fonte' => 'NASA'],
            ['slug' => 'titano',            'titolo' => 'Laghi di metano',            'descrizione' => 'Titano è l\'unico corpo celeste oltre la Terra ad avere liquidi stabili sulla superficie, sotto forma di laghi e mari di metano liquido.', 'fonte' => 'NASA'],
        ];

        foreach ($curiosita as $item) {
            $corpo = CorpoCeleste::where('slug', $item['slug'])->first();
            if (!$corpo) continue;

            Curiosita::create([
                'corpo_celeste_id' => $corpo->id,
                'titolo' => $item['titolo'],
                'descrizione' => $item['descrizione'],
                'fonte' => $item['fonte'],
            ]);
        }
    }
}
