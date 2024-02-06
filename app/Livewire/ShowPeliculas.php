<?php

namespace App\Livewire;

use App\Models\Pelicula;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPeliculas extends Component
{
    use WithPagination; //eso para paginate el livewire
    public string $campo = 'pid';
    public string $orden = 'desc';
    public string $buscar = "";

    #[On('evento_pelicula_creada')]  //este evento se ejecuta cuando se crea una pelicula, actualiza la lista de las peliculas
    public function render()
    {
        $peliculas = Pelicula::join('categories', 'categories.id', '=', 'category_id')
            ->select('peliculas.id as pid', 'caratula', 'disponible', 'titulo', 'nombre')
            /* si tenemos dos campos con el mismo nombre => pelicula.nombre as pnombre categories.nombre as cnombre */
            ->where('titulo', 'like', "%$this->buscar%") /* usamos la comia doble para evitar la concatinación */
            ->orWhere('nombre', 'like', "%$this->buscar%")
            ->orWhere('disponible', 'like', "%$this->buscar%")
            ->orderBy($this->campo, $this->orden)
            ->paginate(5);
        return view('livewire.show-peliculas', compact('peliculas'));
    }

    public function ordenar($campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function updatingBuscar() // esta funccion para buscar el la base de dtos y no solo en la pagina actual
    {
        $this->resetPage();
    }
}
