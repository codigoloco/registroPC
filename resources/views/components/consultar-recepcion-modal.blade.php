@once
    @push('scripts')
        @vite('resources/js/consultarRecepcion.js')
    @endpush
@endonce

<div x-show="showConsultarModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
    x-data="consultarRecepcion()">

    <!-- Fondo Oscuro -->
    <div x-show="showConsultarModal" class="fixed inset-0 transform transition-all"
        x-on:click="showConsultarModal = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showConsultarModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-4xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Consulta / Modificar Registro de Recepción') }}</span>
            <button @click="showConsultarModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('recepcion.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id_caso" :value="idCasoSearch">
            <div class="p-8 space-y-8">
                <!-- Buscador de Caso -->
                <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-blue-200 dark:border-blue-900">
                    <div class="max-w-md mx-auto relative">
                        <x-label value="Buscar Caso (ID o Nombre Cliente)"
                            class="mb-2 text-center font-bold text-blue-600 dark:text-blue-400" />
                        <div class="flex gap-2">
                            <div class="flex-grow relative">
                                <x-input 
                                    type="text" 
                                    placeholder="Escriba para buscar..." 
                                    class="w-full" 
                                    x-model="searchCasoInput"
                                    @focus="showCasosList = true"
                                    @click.away="showCasosList = false"
                                    @keyup.enter="buscarPorCaso()"
                                    autocomplete="off"
                                />
                                
                                <div x-show="showCasosList && filteredCasos.length > 0" 
                                     class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg max-h-48 overflow-y-auto">
                                    <template x-for="caso in filteredCasos" :key="caso.id">
                                        <div @click="selectCasoParaBusqueda(caso)" 
                                             class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors">
                                            <div class="flex justify-between items-center text-sm">
                                                <span class="font-bold text-blue-600 dark:text-blue-400" x-text="'#' + caso.id"></span>
                                                <span class="text-[10px] px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 capitalize" x-text="caso.estatus"></span>
                                            </div>
                                            <div class="text-xs text-gray-700 dark:text-gray-300 font-medium" x-text="caso.cliente.nombre + ' ' + (caso.cliente.apellido || '')"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <x-button type="button" @click="buscarPorCaso()"
                                class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800">
                                <span x-show="!loading">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                            </x-button>
                        </div>
                        <template x-if="error">
                            <p class="text-red-500 text-xs mt-2 text-center" x-text="error"></p>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Sección Recepción -->
                    <div class="space-y-4">
                        <h3
                            class="font-bold text-gray-800 dark:text-gray-100 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                            <span
                                class="bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 p-1 rounded">01</span>
                            {{ __('Datos de Recepción') }}
                            <span class="ml-auto text-xs font-normal text-gray-500"
                                x-text="'Fecha: ' + recepcion.fecha_recepcion"></span>
                        </h3>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-label value="ID Equipo" class="mb-1" />
                                <div class="relative">
                                    <x-input 
                                        type="text" 
                                        x-model="searchEquipo" 
                                        @focus="showEquiposList = true"
                                        @click.away="showEquiposList = false"
                                        placeholder="Serial, Modelo o Tipo..." 
                                        class="w-full h-9" 
                                        autocomplete="off"
                                        required
                                    />
                                    <input type="hidden" name="id_equipo" :value="recepcion.id_equipo">
                                    
                                    <div x-show="showEquiposList && filteredEquipos.length > 0" 
                                         class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg max-h-48 overflow-y-auto">
                                        <template x-for="equipo in filteredEquipos" :key="equipo.id">
                                            <div @click="selectEquipo(equipo)" 
                                                 class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors">
                                                <div class="flex justify-between items-center text-sm">
                                                    <span class="font-bold text-blue-600 dark:text-blue-400" x-text="equipo.tipo.nombre + ' ' + equipo.modelo.nombre"></span>
                                                    <span class="text-[10px] px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 font-mono" x-text="equipo.serial_equipo"></span>
                                                </div>
                                                <div class="text-[10px] text-gray-500" x-text="'ID: ' + equipo.id"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-label value="Tipo de Atención" />
                                    <select name="tipo_atencion" x-model="recepcion.tipo_atencion"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-9"
                                        required>
                                        <option value="presupuesto">Presupuesto</option>
                                        <option value="garantia">Garantía</option>
                                    </select>
                                </div>
                                <div>
                                    <x-label value="Pago Realizado" />
                                    <select name="pago" x-model="recepcion.pago"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-9">
                                        <option value="">Seleccione...</option>
                                        <option value="si">Si</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <x-label value="Falla Técnica" />
                                <textarea name="falla_tecnica" x-model="recepcion.falla_tecnica"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-20"
                                    required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Sección Salida -->
                    <div class="space-y-4">
                        <h3
                            class="font-bold text-gray-800 dark:text-gray-100 border-b dark:border-gray-700 pb-2 flex items-center gap-2">
                            <span
                                class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 p-1 rounded">02</span>
                            {{ __('Datos de Salida') }}
                            <span class="ml-auto text-xs font-normal text-gray-500"
                                x-text="'Fecha: ' + recepcion.fecha_salida"></span>
                        </h3>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-label value="Entregado por" />
                                <select name="deposito" x-model="recepcion.deposito"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-9">
                                    <option value="Tecnico">Técnico</option>
                                    <option value="Deposito">Depósito</option>
                                </select>
                            </div>
                        </div>

                        <div
                            class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-900 rounded-lg">
                            <p class="text-sm text-yellow-700 dark:text-yellow-400">
                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Modifique los campos necesarios y presione Guardar para actualizar el registro completo.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
                <x-button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                    {{ __('Guardar Cambios') }}
                </x-button>
                <x-secondary-button class="px-10" @click="showConsultarModal = false">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </form>
    </div>
</div>