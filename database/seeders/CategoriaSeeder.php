<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorie = [
            ['nome' => 'Pianeta',      'icona' => 'globe',     'descrizione' => 'Corpo celeste che orbita attorno a una stella, con massa sufficiente per avere una forma sferica.',                               'colore' => '#22D3EE'],
            ['nome' => 'Stella',       'icona' => 'sun',       'descrizione' => 'Sfera luminosa di plasma che produce energia tramite fusione nucleare.',                                                               'colore' => '#F97316'],
            ['nome' => 'Luna',         'icona' => 'moon',      'descrizione' => 'Satellite naturale che orbita attorno a un pianeta.',                                                                                   'colore' => '#94A3B8'],
            ['nome' => 'Galassia',     'icona' => 'galaxy',    'descrizione' => 'Vasto sistema di stelle, polveri e gas legati dalla gravità.',                                                                           'colore' => '#A855F7'],
            ['nome' => 'Nebulosa',     'icona' => 'cloud',     'descrizione' => 'Nube interstellare di polvere, idrogeno ed elio dove nascono nuove stelle.',                                                              'colore' => '#F472B6'],
            ['nome' => 'Asteroide',    'icona' => 'asteroid',  'descrizione' => 'Corpo roccioso di dimensioni ridotte che orbita attorno al Sole, principalmente nella fascia tra Marte e Giove.',                        'colore' => '#78716C'],
            ['nome' => 'Cometa',       'icona' => 'sparkles',  'descrizione' => 'Corpo ghiacciato che sviluppa una chioma e una coda quando si avvicina al Sole.',                                                         'colore' => '#22C55E'],
            ['nome' => 'Pianeta Nano', 'icona' => 'circle',    'descrizione' => 'Corpo celeste con massa sufficiente per essere sferico, ma che non ha fatto piazza pulita della propria orbita.',                        'colore' => '#6B7280'],
        ];

        foreach ($categorie as $categoria) {
            Categoria::create($categoria);
        }
    }
}
