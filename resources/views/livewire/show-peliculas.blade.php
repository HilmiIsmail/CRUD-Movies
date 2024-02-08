<x-propios.principal>
    <div class="flex w-full mb-2 items-center">
        <div class="flex-1">
            <x-input type="search" class="w-3/4" placeholder="Buscar..." wire:model.live="buscar" /><i
                class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div>
            @livewire('crear-peli') {{-- para cargar el componente --}}
        </div>
    </div>
    @if (count($peliculas))

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        INFO
                    </th>
                    <th scope="col" class="px-6 py-3">
                        POSTER
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('titulo')">
                        <i class="fas fa-sort mr-1"></i>TITULO
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                        <i class="fas fa-sort mr-1"></i>CATEGORIA
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('disponible')">
                        <i class="fas fa-sort mr-1"></i>DISPONIBLE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ACCIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peliculas as $item)
                    {{-- @dd($item) --}}
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <button><i class="fas fa-info text-xl"></i></button>
                        </td>
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-16 h-20 rounded" src="{{ Storage::url($item->caratula) }}" alt="">
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->titulo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->nombre }} {{-- nombre -> nombre de la categoria --}}
                        </td>
                        <td class="px-6 py-4 cursor-pointer"
                            wire:click="actualizarDisponibilidad( {{ $item->pid }})">
                            <div class="flex items-center">
                                <div @class([
                                    'h-3.5 w-3.5 rounded-full',
                                    'bg-green-500 me-2' => $item->disponible == 'SI',
                                    'bg-red-500 me-2' => $item->disponible == 'NO',
                                ])></div> {{ $item->disponible }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="pedirConfirmacion({{ $item->pid }})"> {{-- en ShowPeli hemos dado el nomre pid al id de pelicula --}}
                                <i class="fas fa-trash text-xl text-red-600"></i>
                            </button>
                            <button wire:click="edit({{ $item->pid }})">
                                <i class="fas fa-edit text-xl text-yellow-600"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="mt-2">
            {{ $peliculas->links() }}
        </div>
    @else
        <p class="p-2 rounded-xl shadow-xl text-gray-200 bg-gray-600 font-bold">
            No se encontró ningúna película! Modifique los terminos de búsqueda.
        </p>
    @endif
    {{--  !Ventana modal para actualizar la Pelicula --}}
    @isset($form->pelicula) {{--  si existe el atributo pelicula en form, muestro el modal // hacemos eso pq hemos enicializado pelicula con null --}}
        <x-dialog-modal maxWidth='4xl' wire:model="openModalUpdate">
            <x-slot name="title">
                Actualizar Película
            </x-slot>
            <x-slot name="content">
                {{-- Formulario --}}
                <x-label for="titulo">Título</x-label>
                <x-input type="text" id="titulo" class="w-full mb-3" placeholder="Título..."
                    wire:model="form.titulo" />
                <x-input-error for="form.titulo"></x-input-error>

                {{-- SINOPSIS --}}
                <x-label for="sinopsis">Sinopsis</x-label>
                <textarea class="w-full mb-3" name="sinopsis" id="sinopsis" placeholder="Sinopsis..." wire:model="form.sinopsis"></textarea>
                <x-input-error for="form.sinopsis"></x-input-error>

                {{-- CATEGORIAS --}}
                <x-label for="category_id">Título</x-label>
                <select class="w-full mb-3" id="category_id" wire:model="form.category_id">
                    <option>Selecciones una categoria...</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error for="form.category_id"></x-input-error>

                {{-- DISPONIBLE --}}
                <x-label for="disponible">Disponible</x-label>
                <div class="flex items-center mb-3">
                    <input id="disponible" type="checkbox" value="SI" wire:model="form.disponible"
                        @checked($form->disponible == 'SI')
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="disponible" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">SI</label>
                </div>
                <x-input-error for="form.disponible"></x-input-error>

                {{-- TAGS --}}
                <x-label for="etiqueta">Etiquetas</x-label>
                <div class="flex mb-3">
                    @foreach ($etiquetas as $etiqueta)
                        <div class="flex items-center me-4">
                            <input id="{{ $etiqueta->nombre }}" type="checkbox" value="{{ $etiqueta->id }}"
                                wire:model="form.etiquetas_id"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $etiqueta->nombre }}"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                <p class="px-1 py-1 rounded-lg" style="background-color: {{ $etiqueta->color }}">
                                    {{ $etiqueta->nombre }}</p>
                            </label>
                        </div>
                    @endforeach
                </div>
                <x-input-error for="form.etiquetas_id"></x-input-error>

                {{-- CARATULA --}}
                <x-label for="imagenU">Imagen</x-label>
                <div class="w-full h-96 bg-gray-200 relative">
                    @if ($form->imagen)
                        <img src="{{ $form->imagen->temporaryUrl() }}"
                            class="w-full h-full bg-center bg-cover bg-no-repeat">
                    @else
                        <img src="{{ Storage::url($form->pelicula->caratula) }}"
                            class="w-full h-full bg-center bg-cover bg-no-repeat">
                    @endif
                    <input type="file" accept="image/" hidden id="imagenU" wire:model="form.imagen"
                        wire:loading.attr="disabled" {{-- para que no se active el boton mientras carga la imagen --}} />
                    <label for="imagenC"
                        class="absolute bottom-2 right-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ">
                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i>SUBIR
                    </label>
                </div>
                <x-input-error for="form.imagen"></x-input-error>
            </x-slot>
            <x-slot name="footer">
                {{-- Botones --}}
                <div class="flex flex-row-reverse">
                    <button wire:click="update" wire:loading.attr="disabled" {{--  disabled mientras se esta cargando --}}
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit"></i> EDITAR
                    </button>
                    <button wire:click="cancelarUpdate"
                        class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> CANCELAR
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endisset

    {{--  !Fin de Ventana modal para actualizar la Pelicula --}}
</x-propios.principal>
