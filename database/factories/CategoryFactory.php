<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker; // Importe o Faker

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker; // Inicialize o Faker

        return [
            'nome' => $faker->word, // Gera um nome aleatório
            'descricao' => $faker->text(200), // Gera uma descrição aleatória
        ];
    }
}
