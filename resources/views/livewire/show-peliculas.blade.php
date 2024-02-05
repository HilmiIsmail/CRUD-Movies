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
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div @class([
                                    'h-3.5 w-3.5 rounded-full ',
                                    'bg-green-500 me-2' => $item->disponible == 'SI',
                                    'bg-red-500 me-2' => $item->disponible == 'NO',
                                ])></div> {{ $item->disponible }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit
                                user</a>
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
</x-propios.principal>
