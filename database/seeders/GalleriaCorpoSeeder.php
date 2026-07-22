<?php

namespace Database\Seeders;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Database\Seeder;

class GalleriaCorpoSeeder extends Seeder
{
    public function run(): void
    {
        // Galleria popolata automaticamente da fetch-nasa --force in DatabaseSeeder.
        // Entry locali rimosse (file inesistenti in storage/app/public/galleria/).
    }
}
