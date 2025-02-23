<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pt_BR');

        Category::factory(10)->create();


        $categoryIds = Category::all()->pluck('id')->toArray();


        for ($i = 0; $i < 200; $i++) {
            Product::create([
                'nome' => $faker->word . ' ' . $faker->numberBetween(1, 100), // Nome com número para variedade
                'descricao' => $faker->sentence,
                'preco' => $faker->randomFloat(2, 10, 1000), // Preço entre 10 e 1000
                'quantidade' => $faker->numberBetween(1, 500), // Quantidade entre 1 e 500
                'category_id' => $faker->randomElement($categoryIds), // Escolhe um ID de categoria aleatório
            ]);
        }
    }
}
