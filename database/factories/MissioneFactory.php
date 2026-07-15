<?php

namespace Database\Factories;

use App\Models\Missione;
use Illuminate\Database\Eloquent\Factories\Factory;

class MissioneFactory extends Factory
{
    protected $model = Missione::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->word(),
            'agenzia' => fake()->randomElement(['NASA', 'ESA', 'CNSA']),
            'data_lancio' => fake()->date(),
            'durata_giorni' => fake()->numberBetween(1, 3650),
            'stato' => fake()->randomElement(['Completata', 'In corso', 'Pianificata']),
            'descrizione' => fake()->paragraph(),
        ];
    }
}
