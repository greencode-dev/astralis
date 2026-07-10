<?php

namespace Database\Factories;

use App\Models\Curiosita;
use Illuminate\Database\Eloquent\Factories\Factory;

class CuriositaFactory extends Factory
{
    protected $model = Curiosita::class;

    public function definition(): array
    {
        return [
            'corpo_celeste_id' => \App\Models\CorpoCeleste::factory(),
            'titolo' => fake()->sentence(3),
            'descrizione' => fake()->paragraph(),
            'fonte' => fake()->url(),
        ];
    }
}
