<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use App\Models\Pelicula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeliculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelicula = Pelicula::factory(50)->create();
        foreach ($pelicula as $peli) {
            /* $peli->etiquetas()->attach([1,3,5]); */
            $etiquetas = $this->devolverIdsEtiquetasRandom();
            $peli->etiquetas()->attach($etiquetas);
        }
    }

    private function devolverIdsEtiquetasRandom(): array
    {
        $etiquetas = [];
        $idsEtiquetas = Etiqueta::pluck('id')->toArray();
        $indices = array_rand($idsEtiquetas, random_int(2, count($idsEtiquetas)));
        foreach ($indices as $indice) {
            $etiquetas[] = $idsEtiquetas[$indice];
        }
        return $etiquetas;
    }
}
