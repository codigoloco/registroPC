@once
    @push('scripts')
        @vite('resources/js/gestionCasos/casosAsignados.js')
    @endpush
@endonce

<div x-show="showAssignedCasesModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">

    <!-- Backdrop -->
    <div x-show="showAssignedCasesModal" class="fixed inset-0 transform transition-all"
        x-on:click="showAssignedCasesModal = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <div x-show="showAssignedCasesModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-4xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-data="initCasosAsignadosModal()">

        <div class="bg-green-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Casos Asignados') }}</span>
            <button @click="showAssignedCasesModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6">
            <template x-if="loading">
                <p class="text-center">Cargando casos...</p>
            </template>
            <template x-if="!loading">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Técnico</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-if="casos.length === 0">
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No hay casos asignados.</td>
                                </tr>
                            </template>
                            <template x-for="caso in casos" :key="caso.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        #<span x-text="caso.id"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        <span x-text="caso.cliente ? caso.cliente.nombre : 'N/A'"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        <span x-text="caso.tecnico ? caso.tecnico.name : 'N/A'"></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                        <span x-text="caso.descripcion_falla"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full"
                                              :class="{
                                                'bg-yellow-100 text-yellow-800': caso.estatus === 'espera',
                                                'bg-blue-100 text-blue-800': caso.estatus === 'asignado',
                                                'bg-green-100 text-green-800': caso.estatus === 'reparado',
                                                'bg-gray-100 text-gray-800': caso.estatus === 'entregado'
                                              }"
                                              x-text="caso.estatus.charAt(0).toUpperCase() + caso.estatus.slice(1)"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span x-text="new Date(caso.created_at).toLocaleDateString()"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </template>
        </div>
    </div>
</div>
