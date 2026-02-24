@once
    @push('scripts')
        @vite('resources/js/gestionAuditoria.js')
    @endpush
@endonce

<div x-data="gestionAuditoria" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Encabezado del Panel -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Panel de Auditoria') }}</span>
        </div>

        <div class="p-8 space-y-8 bg-gray-50 dark:bg-gray-900/50">
            
            <!-- Filtros de Consulta -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Filtros de Consulta') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <!-- Usuario/Correo -->
                    <div>
                        <x-label value="Usuario / Correo" class="mb-1" />
                        <x-input type="text" placeholder="ID, nombre o correo" class="w-full" x-model="filters.usuario" />
                    </div>
                     <!-- Caso -->
                    <div>
                        <x-label value="Caso" class="mb-1" />
                        <x-input type="text" placeholder="ID Caso" class="w-full" x-model="filters.id_caso" />
                    </div>                
                    <!-- Fecha Inicio -->
                    <div>
                        <x-label value="Desde" class="mb-1" />
                        <x-input type="date" class="w-full" x-model="filters.fecha_inicio" />
                    </div>
                    <!-- Fecha Fin -->
                    <div>
                        <x-label value="Hasta" class="mb-1" />
                        <x-input type="date" class="w-full" x-model="filters.fecha_fin" />
                    </div>
                </div>

                <div class="flex gap-3">
                    <x-button @click="fetchData(1)" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                        {{ __('Consultar') }}
                    </x-button>
                    <x-secondary-button @click="limpiarFiltros()">
                        {{ __('Limpiar Filtros') }}
                    </x-secondary-button>
                </div>
            </div>

            <!-- Resultados de Auditoria -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 text-base">{{ __('Resultados de Auditoria') }}</h3>
                    <div x-show="loading" class="text-blue-600 text-sm flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('Cargando...') }}
                    </div>
                </div>
                
                <div class="overflow-x-auto min-h-[300px]">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border dark:border-gray-700">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">Usuario</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">Correo</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">Caso</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">Acción</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">IP</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">Estado Inicial</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">Estado Final</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">Fecha</th>
                                <th class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-xs">
                            <template x-for="item in auditorias" :key="item.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-3 py-3 whitespace-nowrap font-medium text-gray-900 dark:text-gray-100" x-text="item.id"></td>
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="item.usuario ? item.usuario.name : 'N/A'"></span>
                                            <span class="text-[10px] text-gray-500" x-text="'ID: ' + item.id_usuario"></span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-600 dark:text-gray-400" x-text="item.usuario ? item.usuario.email : 'N/A'"></td>
                                    <td class="px-3 py-3 text-gray-900 dark:text-gray-100" x-text="item.id_caso ? '#' + item.id_caso : 'N/A'"></td>
                                    <td class="px-3 py-3">
                                        <span class="px-2 py-1 rounded-full text-[10px] font-bold" 
                                              :class="{
                                                  'bg-green-100 text-green-800': ['INSERT', 'INSERT_RECEPCION_AUTO_ASIGNACION', 'REGISTRAR_ENTREGA', 'INSERT_SALIDA', 'INSERT_EQUIPO', 'INSERT_CLIENTE', 'INSERT_USER'].includes(item.sentencia),
                                                  'bg-blue-100 text-blue-800': ['UPDATE', 'UPDATE_RECEPCION', 'UPDATE_USER'].includes(item.sentencia),
                                                  'bg-purple-100 text-purple-800': item.sentencia === 'DOCUMENTAR',
                                                  'bg-gray-100 text-gray-800': ['LOGIN', 'LOGOUT'].includes(item.sentencia)
                                              }"
                                              x-text="formatAccion(item.sentencia)"></span>
                                    </td>
                                    <td class="px-3 py-3 text-gray-600 dark:text-gray-400 font-mono" x-text="item.ip"></td>
                                    <td class="px-3 py-3 text-gray-600 dark:text-gray-400 italic" x-text="truncateJSON(item.estado_inicial)"></td>
                                    <td class="px-3 py-3 text-gray-600 dark:text-gray-400 italic" x-text="truncateJSON(item.estado_final)"></td>
                                    <td class="px-3 py-3 whitespace-nowrap text-gray-900 dark:text-gray-100" x-text="formatDate(item.created_at)"></td>
                                    <td class="px-3 py-3 text-center">
                                        <button @click="showDetail(item)" class="text-blue-600 hover:text-blue-800 font-bold">Ver Todo</button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="auditorias.length === 0 && !loading">
                                <td colspan="10" class="px-3 py-10 text-center text-gray-500 italic text-sm">
                                    No se encontraron registros de auditoría.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-6 text-sm">
                    <div class="text-gray-600 dark:text-gray-400">
                        Mostrando página <span x-text="currentPage"></span> de <span x-text="lastPage"></span>
                    </div>
                    <div class="flex gap-2">
                        <button @click="fetchData(currentPage - 1)" 
                                :disabled="currentPage === 1 || loading"
                                class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm disabled:opacity-50 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
                            {{ __('Anterior') }}
                        </button>
                        <button @click="fetchData(currentPage + 1)" 
                                :disabled="currentPage === lastPage || loading"
                                class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm disabled:opacity-50 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
                            {{ __('Siguiente') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
