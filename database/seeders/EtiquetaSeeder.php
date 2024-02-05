<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'infantil' => '#40A2E3',
            'accion' => '#FC6736',
            'aventura' => '#6C22A6',
            'animada' => '#F28585',
            'batallas' => '#F8E559',
            'laravel' => '#FF004D',
        ];

        foreach ($tags as $nombre => $color) {
            Etiqueta::create(compact('nombre', 'color'));
        }
    }
}
