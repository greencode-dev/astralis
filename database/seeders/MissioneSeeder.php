<?php

namespace Database\Seeders;

use App\Models\Missione;
use Illuminate\Database\Seeder;

class MissioneSeeder extends Seeder
{
    public function run(): void
    {
        $missioni = [
            [
                'nome' => 'Apollo 11',
                'logo' => 'apollo-11.png',
                'agenzia' => 'NASA',
                'data_lancio' => '1969-07-16',
                'durata_giorni' => 8,
                'stato' => 'completata',
                'descrizione' => 'Prima missione con equipaggio ad atterrare sulla Luna. Neil Armstrong e Buzz Aldrin hanno camminato sulla superficie lunare il 20 luglio 1969.',
                'sito_web' => 'https://www.nasa.gov/mission/apollo-11/',
            ],
            [
                'nome' => 'Voyager 1',
                'logo' => 'voyager.png',
                'agenzia' => 'NASA',
                'data_lancio' => '1977-09-05',
                'durata_giorni' => 17876,
                'stato' => 'in corso',
                'descrizione' => 'Sonda spaziale lanciata per studiare i pianeti esterni del sistema solare. È il primo oggetto creato dall\'uomo ad aver raggiunto lo spazio interstellare.',
                'sito_web' => 'https://voyager.jpl.nasa.gov/',
            ],
            [
                'nome' => 'Voyager 2',
                'logo' => 'voyager.png',
                'agenzia' => 'NASA',
                'data_lancio' => '1977-08-20',
                'durata_giorni' => 17872,
                'stato' => 'in corso',
                'descrizione' => 'Sonda gemella di Voyager 1, unica sonda ad aver visitato Urano e Nettuno. Continua a inviare dati dallo spazio interstellare.',
                'sito_web' => 'https://voyager.jpl.nasa.gov/',
            ],
            [
                'nome' => 'Hubble Space Telescope',
                'logo' => 'hubble.png',
                'agenzia' => 'NASA / ESA',
                'data_lancio' => '1990-04-24',
                'durata_giorni' => 13238,
                'stato' => 'in corso',
                'descrizione' => 'Telescopio spaziale che ha rivoluzionato l\'astronomia con immagini spettacolari dell\'universo. Ha osservato galassie lontane, nebulose e buchi neri.',
                'sito_web' => 'https://hubblesite.org/',
            ],
            [
                'nome' => 'Mars Pathfinder',
                'logo' => 'mars-pathfinder.png',
                'agenzia' => 'NASA',
                'data_lancio' => '1996-12-04',
                'durata_giorni' => 265,
                'stato' => 'completata',
                'descrizione' => 'Missione che ha portato il rover Sojourner su Marte, dimostrando la fattibilità di lander e rover marziani a basso costo.',
                'sito_web' => 'https://www.nasa.gov/mission/mars-pathfinder/',
            ],
            [
                'nome' => 'Stazione Spaziale Internazionale',
                'logo' => 'iss.png',
                'agenzia' => 'NASA / Roscosmos / ESA / JAXA / CSA',
                'data_lancio' => '1998-11-20',
                'durata_giorni' => 10122,
                'stato' => 'in corso',
                'descrizione' => 'Stazione spaziale modulare in orbita terrestre bassa, il più grande laboratorio di ricerca fuori dalla Terra. Ha ospitato astronauti da 19 paesi.',
                'sito_web' => 'https://www.nasa.gov/mission/space-station/',
            ],
            [
                'nome' => 'Cassini-Huygens',
                'logo' => 'cassini.png',
                'agenzia' => 'NASA / ESA / ASI',
                'data_lancio' => '1997-10-15',
                'durata_giorni' => 7244,
                'stato' => 'completata',
                'descrizione' => 'Missione che ha studiato Saturno e le sue lune per 13 anni. La sonda Huygens è atterrata su Titano, la prima e unica atterrato su una luna esterna.',
                'sito_web' => 'https://solarsystem.nasa.gov/missions/cassini/overview/',
            ],
            [
                'nome' => 'Mars Science Laboratory (Curiosity)',
                'logo' => 'curiosity.png',
                'agenzia' => 'NASA',
                'data_lancio' => '2011-11-26',
                'durata_giorni' => 5338,
                'stato' => 'in corso',
                'descrizione' => 'Rover marziano che ha scoperto che Marte aveva le condizioni chimiche per supportare la vita microbica. Ha percorso oltre 28 km sulla superficie marziana.',
                'sito_web' => 'https://mars.nasa.gov/msl/',
            ],
            [
                'nome' => 'James Webb Space Telescope',
                'logo' => 'jwst.png',
                'agenzia' => 'NASA / ESA / CSA',
                'data_lancio' => '2021-12-25',
                'durata_giorni' => 1652,
                'stato' => 'in corso',
                'descrizione' => 'Il più grande e potente telescopio spaziale mai costruito. Osserva l\'universo nell\'infrarosso, rivelando le prime galassie e atmosfere di esopianeti.',
                'sito_web' => 'https://webb.nasa.gov/',
            ],
            [
                'nome' => 'Artemis I',
                'logo' => 'artemis.png',
                'agenzia' => 'NASA',
                'data_lancio' => '2022-11-16',
                'durata_giorni' => 25,
                'stato' => 'completata',
                'descrizione' => 'Prima missione del programma Artemis, con la capsula Orion senza equipaggio che ha orbitato attorno alla Luna e testato i sistemi per il ritorno umano.',
                'sito_web' => 'https://www.nasa.gov/artemis-i/',
            ],
        ];

        foreach ($missioni as $missione) {
            Missione::create($missione);
        }
    }
}
