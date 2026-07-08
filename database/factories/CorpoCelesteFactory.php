<?php

namespace Database\Factories;

use App\Models\CorpoCeleste;
use Illuminate\Database\Eloquent\Factories\Factory;

class CorpoCelesteFactory extends Factory
{
    protected $model = CorpoCeleste::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->word(),
            'categoria_id' => \App\Models\Categoria::factory(),
            'descrizione' => fake()->paragraph(),
            'tipo' => fake()->randomElement(['gassoso', 'roccioso', 'ghiacciato']),
        ];
    }
}
