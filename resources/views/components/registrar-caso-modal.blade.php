@once
    @push('scripts')
        @vite('resources/js/registrarCaso.js')
    @endpush
@endonce

<div x-show="showRegistrarCasoModal" style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0" x-data="registrarCaso()">

    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showRegistrarCasoModal" class="fixed inset-0 transform transition-all"
        x-on:click="showRegistrarCasoModal = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showRegistrarCasoModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Consultar / Modificar Caso') }}</span>
            <button @click="showRegistrarCasoModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('casos.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" x-bind:value="caso.id || ''">

            <div class="p-8 space-y-6">

                <!-- Consultar Caso -->
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-3 text-base">{{ __('Consultar Caso') }}
                    </h3>
                    <div class="flex gap-4">
                        <div class="flex-grow relative">
                            <x-input 
                                type="text" 
                                placeholder="Buscar ID o Cliente..." 
                                class="w-full" 
                                x-model="searchId"
                                @focus="showCasosList = true"
                                @click.away="showCasosList = false"
                                @keyup.enter="buscarCaso()"
                                autocomplete="off"
                            />
                            
                            <div x-show="showCasosList && filteredCasos.length > 0" 
                                 class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg max-h-48 overflow-y-auto">
                                <template x-for="caso in filteredCasos" :key="caso.id">
                                    <div @click="selectCaso(caso)" 
                                         class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-bold text-blue-600 dark:text-blue-400" x-text="'#' + caso.id"></span>
                                            <span class="text-[10px] px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 capitalize" x-text="caso.estatus"></span>
                                        </div>
                                        <div class="text-xs text-gray-700 dark:text-gray-300 font-medium" x-text="caso.cliente.nombre + ' ' + (caso.cliente.apellido || '')"></div>
                                    </div>
                                </template>
                            </div>

                            <div x-show="loading" class="absolute right-3 top-2.5">
                                <svg class="animate-spin h-5 w-5 text-blue-500" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <x-button type="button" @click="buscarCaso()"
                            class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                            {{ __('Modificar') }}
                        </x-button>
                    </div>
                    <p x-show="error" class="text-sm text-red-600 mt-2 font-bold" x-text="error"></p>
                </div>

                <!-- Detalles del Caso -->
                <div x-show="caso.id" x-transition>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Detalles del Caso') }}
                    </h3>

                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md space-y-4">

                        <!-- Cliente -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Cliente</label>
                            <div class="col-span-2">
                                <p class="text-sm font-bold text-blue-600"
                                    x-text="caso.cliente.nombre + ' ' + (caso.cliente.apellido || '')"></p>
                            </div>
                        </div>

                        <!-- Falla Reportada -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Descripción Falla</label>
                            <div class="col-span-2">
                                <x-input type="text" name="descripcion_falla" class="w-full" maxlength="100" required
                                    x-model="caso.descripcion_falla" />
                            </div>
                        </div>

                        <!-- Pieza Sugerida -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Pieza Sugerida</label>
                            <div class="col-span-2">
                                <x-input type="text" name="pieza_sugerida" class="w-full" maxlength="100"
                                    placeholder="Opcional" x-model="caso.pieza_sugerida" />
                            </div>
                        </div>

                        <!-- Forma de Atención (Select) -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Forma de Atención</label>
                            <div class="col-span-2">
                                <select name="forma_de_atencion"
                                    x-model="caso.forma_de_atencion"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                                    <option value="encomienda">Encomienda</option>
                                    <option value="presencial">Presencial</option>
                                </select>
                            </div>
                        </div>

                        <!-- Estatus (Select) -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Estatus</label>
                            <div class="col-span-2">
                                <select name="estatus" x-model="caso.estatus"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                                    <option value="asignado">Asignado</option>
                                    <option value="espera">Espera</option>
                                    <option value="reparado">Reparado</option>
                                    <option value="entregado">Entregado</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <!-- Historial de Documentación (Piezas/Servicios) -->
                    <div x-show="caso && caso.documentacion && caso.documentacion.length > 0"
                        class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h4 class="font-bold text-blue-600 dark:text-blue-400 mb-3 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            {{ __('Historial de Piezas / Servicios') }}
                        </h4>
                        <div class="overflow-x-auto shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th
                                            class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                                            {{ __('Pieza / Servicio') }}
                                        </th>
                                        <th
                                            class="px-4 py-2 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                                            {{ __('Cant.') }}
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                                            {{ __('Obs.') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                    <template x-for="doc in caso.documentacion" :key="doc.id">
                                        <tr>
                                            <td class="px-4 py-2 text-[11px] text-gray-700 dark:text-gray-300"
                                                x-text="doc.pieza_soporte ? doc.pieza_soporte.nombre : 'N/A'"></td>
                                            <td class="px-4 py-2 text-[11px] text-center text-gray-700 dark:text-gray-300 font-bold"
                                                x-text="doc.cantidad"></td>
                                            <td class="px-4 py-2 text-[11px] text-gray-700 dark:text-gray-300 italic truncate max-w-[150px]"
                                                :title="doc.observacion" x-text="doc.observacion || '-'"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div
                class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
                <x-button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-8"
                    ::disabled="!caso.id">
                    {{ __('Guardar') }}
                </x-button>
                <x-secondary-button class="px-8" @click="showRegistrarCasoModal = false">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </form>

    </div>
</div>