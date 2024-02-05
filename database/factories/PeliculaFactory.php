<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelicula>
 */
class PeliculaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new \Mmo\Faker\PicsumProvider(fake()));

        return [
            'titulo' => fake()->unique()->sentence(nbWords: 4),
            'sinopsis' => fake()->text(),
            'category_id' => Category::all()->random()->id,
            'caratula' => 'caratulas/' . fake()->picsum('public/storage/caratulas', 640, 480, false),
            'disponible' => fake()->randomElement(['SI', 'NO'])
        ];
    }
}
