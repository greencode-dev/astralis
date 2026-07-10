<?php

namespace Database\Factories;

use App\Models\GalleriaCorpo;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleriaCorpoFactory extends Factory
{
    protected $model = GalleriaCorpo::class;

    public function definition(): array
    {
        return [
            'corpo_celeste_id' => \App\Models\CorpoCeleste::factory(),
            'percorso' => fake()->imageUrl(),
            'didascalia' => fake()->sentence(),
            'crediti' => fake()->name(),
            'ordine' => fake()->numberBetween(0, 10),
        ];
    }
}
