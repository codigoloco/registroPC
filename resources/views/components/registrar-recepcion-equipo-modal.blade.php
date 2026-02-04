<div x-show="showRecepcionModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
    x-data="{ 
        showHistorial: false, 
        historial: [], 
        pagination: {}, 
        loading: false,
        fetchHistorial(url = '/recepcion/all') {
            this.loading = true;
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    this.historial = data.data;
                    this.pagination = data;
                    this.showHistorial = true;
                })
                .finally(() => this.loading = false);
        }
    }">

    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showRecepcionModal" class="fixed inset-0 transform transition-all"
        @click="showRecepcionModal = false; showHistorial = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showRecepcionModal" :class="showHistorial ? 'sm:max-w-7xl' : 'sm:max-w-3xl'"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto transition-all duration-500"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold"
                x-text="showHistorial ? '{{ __('Historial de Recepciones') }}' : '{{ __('Registrar Recepción de Equipo') }}'"></span>
            <div class="flex gap-2">
                <button type="button" @click="showHistorial = !showHistorial; if(showHistorial) fetchHistorial()"
                    class="text-xs bg-blue-500 hover:bg-blue-400 text-white px-3 py-1 rounded transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <span
                        x-text="showHistorial ? '{{ __('Volver al Registro') }}' : '{{ __('Ver Historial') }}'"></span>
                </button>
                <button @click="showRecepcionModal = false; showHistorial = false"
                    class="text-white hover:text-gray-200 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Vista de Registro -->
        <div x-show="!showHistorial">
            <form action="{{ route('recepcion.save') }}" method="POST">
                @csrf
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Columna 1 -->
                        <div class="space-y-4">
                            <div>
                                <x-label value="ID Caso" class="mb-1" />
                                <x-input type="text" name="id_caso" placeholder="ID Caso" class="w-full" required />
                            </div>
                            <div>
                                <x-label value="ID Equipo" class="mb-1" />
                                <x-input type="text" name="id_equipo" placeholder="ID Equipo" class="w-full" required />
                            </div>
                        </div>

                        <!-- Columna 2 -->
                        <div class="space-y-4">
                            <div>
                                <x-label value="Tipo de Atención" class="mb-1" />
                                <select name="tipo_atencion"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10"
                                    required>
                                    <option value="presupuesto">Presupuesto</option>
                                    <option value="garantia">Garantía</option>
                                </select>
                            </div>
                            <div>
                                <x-label value="Pago Realizado" class="mb-1" />
                                <select name="pago"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                                    <option value="">Seleccione...</option>
                                    <option value="si">Si</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div>
                                <x-label value="Falla Técnica" class="mb-1" />
                                <x-input type="text" name="falla_tecnica" placeholder="Descripción de la falla"
                                    class="w-full" required />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
                    <x-button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                        {{ __('Guardar') }}
                    </x-button>
                    <x-secondary-button class="px-10" @click="showRecepcionModal = false">
                        {{ __('Cancelar') }}
                    </x-secondary-button>
                </div>
            </form>
        </div>

        <!-- Vista de Historial (Data Table) -->
        <div x-show="showHistorial" class="p-6 overflow-hidden">
            <div x-show="loading" class="flex justify-center py-10">
                <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <div x-show="!loading" class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Fecha') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Usuario') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Caso') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Modelo') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Serial') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Tipo Eq.') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Atención') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Tipo Cliente') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Falla') }}</th>
                            <th class="px-3 py-2 text-left uppercase font-bold">{{ __('Pago') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="item in historial" :key="item.id">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-3 py-2 whitespace-nowrap text-gray-600 dark:text-gray-300" x-text="new Date(item.created_at).toLocaleDateString() + ' ' + new Date(item.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-600 dark:text-gray-300" x-text="(item.usuario_recepcion?.name || 'N/A') + ' ' + (item.usuario_recepcion?.lastname || '')"></td>
                                <td class="px-3 py-2 font-bold text-gray-900 dark:text-gray-100" x-text="'#' + item.id_caso"></td>
                                <td class="px-3 py-2 text-gray-600 dark:text-gray-300" x-text="item.equipo?.modelo?.nombre || 'N/A'"></td>
                                <td class="px-3 py-2 font-mono text-blue-600 dark:text-blue-400" x-text="item.equipo?.serial_equipo || 'N/A'"></td>
                                <td class="px-3 py-2 text-gray-600 dark:text-gray-300" x-text="item.equipo?.tipo?.nombre || 'N/A'"></td>
                                <td class="px-3 py-2 capitalize text-gray-600 dark:text-gray-300" x-text="item.tipo_atencion"></td>
                                <td class="px-3 py-2 text-gray-600 dark:text-gray-300" x-text="item.caso?.cliente?.tipo_cliente || 'N/A'"></td>
                                <td class="px-3 py-2 max-w-xs truncate text-gray-600 dark:text-gray-300" :title="item.falla_tecnica" x-text="item.falla_tecnica"></td>
                                <td class="px-3 py-1">
                                    <span :class="item.pago === 'si' ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400'" class="font-bold uppercase" x-text="item.pago || 'no'"></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Paginación Historial -->
            <div x-show="!loading" class="mt-4 flex items-center justify-between text-xs">
                <span class="text-gray-600 dark:text-gray-400"
                    x-text="'Mostrando ' + pagination.from + ' a ' + pagination.to + ' de ' + pagination.total + ' registros'"></span>
                <div class="flex gap-1">
                    <button @click="if(pagination.prev_page_url) fetchHistorial(pagination.prev_page_url)"
                        :disabled="!pagination.prev_page_url"
                        :class="!pagination.prev_page_url ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600 hover:text-white'"
                        class="px-3 py-1 border border-blue-600 dark:border-blue-400 text-blue-600 dark:text-blue-400 rounded transition-colors italic">
                        {{ __('Anterior') }}
                    </button>
                    <button @click="if(pagination.next_page_url) fetchHistorial(pagination.next_page_url)"
                        :disabled="!pagination.next_page_url"
                        :class="!pagination.next_page_url ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600 hover:text-white'"
                        class="px-3 py-1 border border-blue-600 dark:border-blue-400 text-blue-600 dark:text-blue-400 rounded transition-colors italic">
                        {{ __('Siguiente') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>