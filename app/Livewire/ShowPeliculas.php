<?php

namespace App\Livewire;

use App\Livewire\Forms\UpdateForm;
use App\Models\Category;
use App\Models\Etiqueta;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPeliculas extends Component
{
    use WithPagination; //eso para paginate el livewire
    use WithFileUploads; //para subir imagenes
    public string $campo = 'pid';
    public string $orden = 'desc';
    public string $buscar = "";
    public bool $openModalUpdate = false;

    public UpdateForm $form;

    /*------------------------------------------------------*/
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

        /* etiquetas y categorias los necesitamos para actualizar */
        $etiquetas = Etiqueta::select('id', 'nombre', 'color')->orderBy('nombre')->get();
        $categorias = Category::select('id', 'nombre')->orderBy('nombre')->get();

        return view('livewire.show-peliculas', compact('peliculas', 'etiquetas', 'categorias'));
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

    //Borrar
    public function pedirConfirmacion($id)
    {
        $this->dispatch('confirmar', $id);
    }

    #[On('borrarOk')]
    public function  borrarPelicula(Pelicula $peli)
    {
        /* dd($peli); */
        if (basename($peli->caratula) != "noimagen.png") { //si la imagen no es default.jpg se elimina de storage
            Storage::delete($peli->caratula);
        }
        $peli->delete();
        $this->dispatch('mensaje', 'pelicula borrada');
    }


    //Actualizar disponibilidad
    public function actualizarDisponibilidad(Pelicula $peli)
    {
        $disponible = ($peli->disponible == "SI") ? "NO" : "SI";
        $peli->update([
            'disponible' => $disponible,
            // cambiar la disponibilidad en la BD, el resto de las columnas se quedaran igual por eso no los pongamos
        ]);
    }

    //Metodos para update
    public function edit(Pelicula $peli)
    {
        $this->form->setpelicula($peli);
        $this->openModalUpdate = true;
    }

    public function update()
    {
        $this->form->actualizar();
        $this->cancelarUpdate();
        $this->dispatch('mensaje', 'Película Actualizada');
    }

    public function cancelarUpdate()
    {
        $this->form->limpiar();
        $this->openModalUpdate = false;
    }
}
