<?php

namespace Database\Seeders;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Database\Seeder;

class GalleriaCorpoSeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            'terra' => [
                ['percorso' => 'https://images-assets.nasa.gov/image/GSFC_20171208_Archive_e002134/GSFC_20171208_Archive_e002134~medium.jpg', 'didascalia' => 'La Terra vista dallo spazio — Blue Marble', 'crediti' => 'NASA/GSFC', 'ordine' => 1],
                ['percorso' => 'https://images-assets.nasa.gov/image/PIA18033/PIA18033~medium.jpg', 'didascalia' => 'Terra di notte dalle ISS', 'crediti' => 'NASA', 'ordine' => 2],
            ],
            'luna' => [
                ['percorso' => 'https://images-assets.nasa.gov/image/AS17-148-22727/AS17-148-22727~medium.jpg', 'didascalia' => 'Luna vista dall\'Apollo 17', 'crediti' => 'NASA', 'ordine' => 1],
            ],
            'marte' => [
                ['percorso' => 'https://images-assets.nasa.gov/image/PIA19808/PIA19808~medium.jpg', 'didascalia' => 'Selfie del rover Curiosity sul Monte Sharp', 'crediti' => 'NASA/JPL-Caltech', 'ordine' => 1],
                ['percorso' => 'https://images-assets.nasa.gov/image/PIA25566/PIA25566~medium.jpg', 'didascalia' => 'Vista panoramica del cratere Gale', 'crediti' => 'NASA/JPL-Caltech/MSSS', 'ordine' => 2],
            ],
            'giove' => [
                ['percorso' => 'https://images-assets.nasa.gov/image/PIA21974/PIA21974~medium.jpg', 'didascalia' => 'Giove visto dalla sonda Juno', 'crediti' => 'NASA/JPL-Caltech/SwRI/MSSS', 'ordine' => 1],
            ],
            'saturno' => [
                ['percorso' => 'https://images-assets.nasa.gov/image/PIA11141/PIA11141~medium.jpg', 'didascalia' => 'Saturno e i suoi anelli ripresi da Cassini', 'crediti' => 'NASA/JPL-Caltech/Space Science Institute', 'ordine' => 1],
            ],
        ];

        foreach ($entries as $corpoSlug => $images) {
            $corpo = CorpoCeleste::where('slug', $corpoSlug)->first();
            if (!$corpo) continue;

            foreach ($images as $image) {
                GalleriaCorpo::create(array_merge($image, [
                    'corpo_celeste_id' => $corpo->id,
                ]));
            }
        }
    }
}
