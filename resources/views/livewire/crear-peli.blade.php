<div>
    <x-button wire:click="$set('openModalCrear',true)"><i class="fas fa-add"></i>Nueva</x-button>
    <x-dialog-modal maxWidth='4xl' wire:model="openModalCrear">
        <x-slot name="title">
            Crear Película
        </x-slot>
        <x-slot name="content">
            {{-- Formulario --}}
            <x-label for="titulo">Título</x-label>
            <x-input type="text" id="titulo" class="w-full mb-3" placeholder="Título..."
                wire:model="titulo"></x-input>
            <x-input-error for="titulo"></x-input-error>

            {{-- SINOPSIS --}}
            <x-label for="sinopsis">Sinopsis</x-label>
            <textarea class="w-full mb-3" name="sinopsis" id="sinopsis" placeholder="Sinopsis..." wire:model="sinopsis"></textarea>
            <x-input-error for="sinopsis"></x-input-error>

            {{-- CATEGORIAS --}}
            <x-label for="category_id">Título</x-label>
            <select class="w-full mb-3" id="category_id" wire:model="category_id">
                <option>Selecciones una categoria...</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
            <x-input-error for="category_id"></x-input-error>

            {{-- DISPONIBLE --}}
            <x-label for="disponible">Disponible</x-label>
            <div class="flex items-center mb-3">
                <input id="disponible" type="checkbox" value="SI" wire:model="disponible"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="disponible" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">SI</label>
            </div>
            <x-input-error for="disponible"></x-input-error>

            {{-- TAGS --}}
            <x-label for="etiqueta">Etiquetas</x-label>
            <div class="flex mb-3">
                @foreach ($etiquetas as $etiqueta)
                    <div class="flex items-center me-4">
                        <input id="{{ $etiqueta->nombre }}" type="checkbox" value="{{ $etiqueta->id }}"
                            wire:model="etiquetas_id"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="{{ $etiqueta->nombre }}"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            <p class="px-1 py-1 rounded-lg" style="background-color: {{ $etiqueta->color }}">
                                {{ $etiqueta->nombre }}</p>
                        </label>
                    </div>
                @endforeach
            </div>
            <x-input-error for="etiquetas_id"></x-input-error>

            {{-- CARATULA --}}
            <x-label for="imagenC">Imagen</x-label>
            <div class="w-full h-96 bg-gray-200 relative">
                @if ($imagen)
                    <img src="{{ $imagen->temporaryUrl() }}" class="w-full h-full bg-center bg-cover bg-no-repeat">
                @endif
                <input type="file" accept="image/" hidden id="imagenC" wire:model="imagen"
                    wire:loading.attr="disabled" {{-- para que no se active el boton mientras carga la imagen --}} />
                <label for="imagenC"
                    class="absolute bottom-2 right-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ">
                    <i class="fa-solid fa-cloud-arrow-up mr-2"></i>Subir
                </label>
            </div>
            <x-input-error for="imagen"></x-input-error>
        </x-slot>
        <x-slot name="footer">
            {{-- Botones --}}
            <div class="flex flex-row-reverse">
                <button wire:click="store" wire:loading.attr="disabled" {{--  disabled mientras se esta cargando --}}
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save"></i> GUARDAR
                </button>
                <button wire:click="cancelarCrear"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
