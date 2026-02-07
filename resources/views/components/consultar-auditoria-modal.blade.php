<div x-show="showAuditoriaModal" 
    x-data="gestionAuditoria"
    style="display: none;" 
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
    
    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showAuditoriaModal" class="fixed inset-0 transform transition-all" x-on:click="showAuditoriaModal = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showAuditoriaModal" class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-6xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Consultar Auditoria') }}</span>
            <button @click="showAuditoriaModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-8 space-y-8 bg-gray-50 dark:bg-gray-900/50">
            
            <!-- Filtros de Consulta -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Filtros de Consulta') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <!-- Usuario -->
                    <div>
                        <x-label value="Usuario" class="mb-1" />
                        <x-input type="text" placeholder="ID Usuario / Nombre" class="w-full" x-model="filters.usuario" />
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
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 text-base">{{ __('Resultados de Auditoria') }}</h3>
                    <div x-show="loading" class="text-blue-600 text-sm flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Cargando...
                    </div>
                </div>
                
                <div class="overflow-x-auto min-h-[300px]">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border dark:border-gray-700">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                                <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wider">Usuario</th>
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
                                    <td class="px-3 py-3 text-gray-900 dark:text-gray-100" x-text="item.id_caso ? '#' + item.id_caso : 'N/A'"></td>
                                    <td class="px-3 py-3">
                                        <span class="px-2 py-1 rounded-full text-[10px] font-bold" 
                                              :class="{
                                                  'bg-green-100 text-green-800': item.sentencia === 'INSERT',
                                                  'bg-blue-100 text-blue-800': item.sentencia === 'UPDATE',
                                                  'bg-purple-100 text-purple-800': item.sentencia === 'DOCUMENTAR',
                                                  'bg-gray-100 text-gray-800': !['INSERT', 'UPDATE', 'DOCUMENTAR'].includes(item.sentencia)
                                              }"
                                              x-text="item.sentencia"></span>
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
                                <td colspan="9" class="px-3 py-10 text-center text-gray-500 italic text-sm">
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
                                class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm disabled:opacity-50 hover:bg-gray-50">
                            Anterior
                        </button>
                        <button @click="fetchData(currentPage + 1)" 
                                :disabled="currentPage === lastPage || loading"
                                class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm disabled:opacity-50 hover:bg-gray-50">
                            Siguiente
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
