<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Etiqueta;
use App\Models\Pelicula;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearPeli extends Component
{
    use WithFileUploads;

    public bool $openModalCrear = false;

    #[Validate(['nullable', 'image', 'max:2048'])] //eso valida el elemento debajo, (sin saltar de linea)
    public $imagen;

    #[Validate(['required', 'string', 'min:3', 'unique:peliculas,titulo'])]
    public string $titulo;

    #[Validate(['required', 'string', 'min:10'])]
    public string $sinopsis;

    #[Validate(['nullable'])]
    public ?string $disponible = null;

    #[Validate(['required', 'exists:categories,id'])]
    public string $category_id;

    #[Validate(['required', 'array', 'min:1', 'exists:etiquetas,id'])]
    public array $etiquetas_id = [];

    public function render()
    {
        $etiquetas = Etiqueta::select('id', 'nombre', 'color')->orderBy('nombre')->get();
        $categorias = Category::select('id', 'nombre')->orderBy('nombre')->get();
        return view('livewire.crear-peli', compact('etiquetas', 'categorias'));
    }

    public function store()
    {
        $this->validate();
        $pelicula = Pelicula::create([
            'titulo' => $this->titulo,
            'sinopsis' => $this->sinopsis,
            'category_id' => $this->category_id,
            'disponible' => ($this->disponible) ? "SI" : "NO",
            'caratula' => ($this->imagen) ? $this->imagen->store('caratula') : "noimagen.png",
        ]);

        //le añado a la pelicula creada sus etiquetas
        $pelicula->etiquetas()->attach($this->etiquetas_id);

        //avisamos al show-peliculas para que se actualiza y aparezca la pelicula creada
        $this->dispatch('evento_pelicula_creada')->to(ShowPeliculas::class);
        //evento para el titpico mensaje de la peli creada
        $this->dispatch("mensaje", "Pelicula creada con éxito");
        $this->cancelarCrear();
    }

    /* usaremos este metodo en el boton en crear-peli */
    public function cancelarCrear()
    {
        $this->reset(['openModalCrear', 'titulo', 'imagen', 'disponible', 'sinopsis', 'category_id', 'etiquetas_id']);
    }
}
