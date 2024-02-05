<div>
    <x-button><i class="fas fa-add"></i>Nueva</x-button>
    <x-dialog-modal maxWidth='4xl'>
        <x-slot name="title">
            Crear Película
        </x-slot>
        <x-slot name="content">
            {{-- Formulario --}}
            <x-label for="titulo">Título</x-label>
            <x-input type="text" id="titulo" class="w-full mb-3" placeholder="Título..."></x-input>

            <x-label for="sinopsis">Título</x-label>
            <textarea class="w-full mb-3" name="sinopsis" id="sinopsis" placeholder="Sinopsis..."></textarea>

            <x-label for="category_id">Título</x-label>
            <select class="w-full mb-3" id="category_id">
                <option>Selecciones una categoria...</option>
            </select>

            <x-label for="disponible">Disponible</x-label>
            <x-input type="checkbox" value="SI" id="disponible" class="mb-3" placeholder="Título..."></x-input>
        </x-slot>
        <x-slot name="footer">
            {{-- Botones --}}
        </x-slot>
    </x-dialog-modal>
</div>
