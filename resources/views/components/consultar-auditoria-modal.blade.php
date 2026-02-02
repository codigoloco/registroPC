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
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Row 1 -->
                    <div>
                        <div class="flex justify-between">
                             <x-label value="Usuario:" class="mb-1" />
                        </div>
                        <x-input type="text" placeholder="Caso:" class="w-full" />
                    </div>
                    <div>
                        <x-label value="Rece:" class="mb-1" />
                        <x-input type="text" class="w-full" />
                    </div>
                
                    <!-- Row 2 -->
                    <div>
                        <div class="flex justify-between">
                            <x-label value="Fecha Inicio:" class="mb-1" />
                            <x-label value="Fecha Fin:" class="mb-1" />
                        </div>
                        <div class="flex gap-2">
                            <x-input type="date" class="w-full" />
                            <x-input type="date" class="w-full" />
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                             <x-label value="Acción:" class="mb-1" />
                             <x-label value="Estado:" class="mb-1" />
                        </div>
                         <div class="flex gap-2">
                             <select class="w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                                <option>Acción</option>
                             </select>
                             <select class="w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                                <option>Estado</option>
                             </select>
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
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Fecha</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Hora</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Caso</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Acción</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Detalles</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <!-- Helper row for preview -->
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap">001</td>
                                <td class="px-3 py-2 whitespace-nowrap">2023-10-26</td>
                                <td class="px-3 py-2 whitespace-nowrap">10:30</td>
                                <td class="px-3 py-2 whitespace-nowrap">C035</td>
                                <td class="px-3 py-2 whitespace-nowrap">Crear Caso</td>
                                <td class="px-3 py-2 whitespace-nowrap">Caso creado</td>
                                <td class="px-3 py-2 whitespace-nowrap">Éxito</td>
                            </tr>
                             <tr>
                                <td class="px-3 py-2 whitespace-nowrap">002</td>
                                <td class="px-3 py-2 whitespace-nowrap">2023-10-26</td>
                                <td class="px-3 py-2 whitespace-nowrap">11:00</td>
                                <td class="px-3 py-2 whitespace-nowrap"></td>
                                <td class="px-3 py-2 whitespace-nowrap">Recep</td>
                                <td class="px-3 py-2 whitespace-nowrap">Equipo recibido</td>
                                <td class="px-3 py-2 whitespace-nowrap">Éxito</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap">003</td>
                                <td class="px-3 py-2 whitespace-nowrap">2023-10-26</td>
                                <td class="px-3 py-2 whitespace-nowrap">11:30</td>
                                <td class="px-3 py-2 whitespace-nowrap">11:00</td>
                                <td class="px-3 py-2 whitespace-nowrap">Solicitar Pieza</td>
                                <td class="px-3 py-2 whitespace-nowrap">Solicito P005</td>
                                <td class="px-3 py-2 whitespace-nowrap">Pendiente</td>
                            </tr>
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
