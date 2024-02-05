<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = ['Documental', 'Anime', 'Ciencia Ficcion', 'Terror'];
        foreach ($categorias as $item) {
            Category::create(['nombre' => $item]);
        }
    }
}
