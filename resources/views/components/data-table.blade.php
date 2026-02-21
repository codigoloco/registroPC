@props([
    'title' => '',
    'headers' => [],
    'paginator' => null,
    'emptyMessage' => 'No hay registros actualmente.',
    'searchPlaceholder' => 'Buscar...',
])

<div class="mt-12 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700"
     x-data="dataTable()">
    <div class="p-6">

        {{-- Encabezado + Buscador --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                @if(isset($icon))
                    {{ $icon }}
                @endif
                {{ __($title) }}
            </h3>

            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text"
                       x-model="search"
                       placeholder="{{ $searchPlaceholder }}"
                       class="w-full pl-9 pr-8 py-2 text-sm border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
                <button x-show="search.length > 0" @click="search = ''"
                        class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Info de resultados filtrados --}}
        <div x-show="search.length > 0" x-cloak
             class="mb-3 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <span>Mostrando <strong x-text="visibleCount"></strong> de <strong x-text="totalCount"></strong> registros</span>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        @foreach($headers as $header)
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider {{ $header['class'] ?? '' }}">
                                {{ __($header['label']) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
                       x-ref="tableBody">
                    {{ $slot }}

                    {{-- Fila vacía (sin datos en la paginación) --}}
                    @if($paginator && $paginator->isEmpty())
                        <tr>
                            <td colspan="{{ count($headers) }}"
                                class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                {{ __($emptyMessage) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Mensaje cuando el filtro no encuentra resultados --}}
        <div x-show="search.length > 0 && visibleCount === 0" x-cloak
             class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg text-sm text-yellow-700 dark:text-yellow-400 flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            No se encontraron registros que coincidan con "<span x-text="search" class="font-semibold"></span>".
        </div>

        {{-- Paginación --}}
        @if($paginator && $paginator->hasPages())
            <div class="mt-6">
                {{ $paginator->links() }}
            </div>
        @endif
    </div>
</div>
