<?php

namespace Database\Factories;

use App\Models\CorpoCeleste;
use App\Models\GalleriaCorpo;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleriaCorpoFactory extends Factory
{
    protected $model = GalleriaCorpo::class;

    public function definition(): array
    {
        return [
            'percorso' => fake()->imageUrl(),
            'didascalia' => fake()->sentence(),
            'crediti' => fake()->name(),
            'ordine' => fake()->numberBetween(0, 10),
        ];
    }
}
