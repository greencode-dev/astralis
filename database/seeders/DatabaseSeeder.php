<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@astralis.it')->exists()) {
            User::factory()->create([
                'name' => 'Admin Astralis',
                'email' => 'admin@astralis.it',
                'password' => bcrypt('password'),
            ]);
        }

        $this->call([
            CategoriaSeeder::class,
            CorpoCelesteSeeder::class,
            MissioneSeeder::class,
            GalleriaCorpoSeeder::class,
            CuriositaSeeder::class,
            CorpoCelesteMissioneSeeder::class,
        ]);
    }
}
