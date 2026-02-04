<div x-show="showAuditoriaModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
    
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
    <div x-show="showAuditoriaModal" class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-4xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('CU 009 Consultar Auditoria') }}</span>
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
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Usuario -->
                    <div>
                        <x-label value="Usuario" class="mb-1" />
                        <x-input type="text" placeholder="ID Usuario / Nombre" class="w-full" />
                    </div>
                     <!-- Caso -->
                    <div>
                        <x-label value="Caso" class="mb-1" />
                        <x-input type="text" placeholder="ID Caso" class="w-full" />
                    </div>                
                    <!-- Fechas -->
                    <div>
                        <x-label value="Rango de Fechas" class="mb-1" />
                        <div class="flex gap-2">
                            <x-input type="date" class="w-full" />
                            <x-input type="date" class="w-full" />
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                        {{ __('Consultar') }}
                    </x-button>
                    <x-secondary-button>
                        {{ __('Limpiar Filtros') }}
                    </x-secondary-button>
                </div>
            </div>

            <!-- Resultados de Auditoria -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Resultados de Auditoria') }}</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Usuario</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Caso</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Acción</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">IP</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Estado Anterior</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Estado Final</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <!-- Helper row for preview -->
                          
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Dummy -->
                <div class="flex justify-center items-center mt-6 gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <button class="px-2 hover:text-blue-600">Anterior</button>
                    <button class="px-2 font-bold text-blue-600 bg-blue-50 rounded">1</button>
                    <button class="px-2 hover:text-blue-600">2</button>
                    <button class="px-2 hover:text-blue-600">3</button>
                    <button class="px-2 hover:text-blue-600">Siguiente</button>
                </div>
            </div>

        </div>

    </div>
</div>
