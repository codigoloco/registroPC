<div x-show="showCrearCasoModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">

    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showCrearCasoModal" class="fixed inset-0 transform transition-all"
        x-on:click="showCrearCasoModal = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showCrearCasoModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
        x-data="initCrearCasoModal()">

        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Crear Caso') }}</span>
            <button @click="showCrearCasoModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('casos.save') }}" method="POST">
            @csrf
            <div class="p-8 space-y-6">

                <!-- Detalles del Caso -->
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Detalles del Caso') }}
                    </h3>

                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md space-y-4">

                        <!-- Cliente Search -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Cedula Cliente</label>
                            <div class="col-span-2 relative">
                                <x-input type="text" name="id_cliente" class="w-full" x-model="searchCedula"
                                    @keyup.enter="buscarCliente()" @blur="buscarCliente()"
                                    placeholder="Ingresa Cedula/RIF" required />
                                <button type="button" @click="buscarCliente()"
                                    class="absolute right-2 top-1.5 text-blue-500 hover:text-blue-700 focus:outline-none">
                                    <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p x-show="error"
                            class="text-sm text-red-600 font-bold text-center bg-red-100 dark:bg-red-900/30 p-2 rounded"
                            x-text="error"></p>
                        <p x-show="cliente"
                            class="text-sm text-green-700 font-bold text-center bg-green-100 dark:bg-green-900/30 p-2 rounded"
                            x-text="'✓ Cliente: ' + cliente.nombre + ' ' + (cliente.apellido || '')"></p>

                        <!-- Falla Reportada -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Descripción Falla</label>
                            <div class="col-span-2">
                                <x-input type="text" name="descripcion_falla" class="w-full" maxlength="100" required />
                            </div>
                        </div>

                        <!-- Pieza Sugerida -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Pieza Sugerida</label>
                            <div class="col-span-2">
                                <x-input type="text" name="pieza_sugerida" class="w-full" maxlength="100"
                                    placeholder="Opcional" />
                            </div>
                        </div>

                        <!-- Piezas Seleccionadas (Select) -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Piezas Disponibles</label>
                            <div class="col-span-2">
                                <select name="id_pieza_soporte" 
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10"
                                    :disabled="loadingPiezas">
                                    <option value="" x-show="loadingPiezas">Cargando piezas...</option>
                                    <option value="" x-show="!loadingPiezas">Seleccione una pieza</option>
                                    <template x-for="pieza in piezas" :key="pieza.id">
                                        <option :value="pieza.id" x-text="pieza.nombre"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <!-- Forma de Atención (Select) -->
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Forma de Atención</label>
                            <div class="col-span-2">
                                <select name="forma_de_atencion"
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
                                <select name="estatus"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                                    <option value="asignado">Asignado</option>
                                    <option value="espera" selected>Espera</option>
                                    <option value="reparado">Reparado</option>
                                    <option value="entregado">Entregado</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div
                class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
                <x-button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-8"
                    ::disabled="!cliente">
                    {{ __('Guardar') }}
                </x-button>
                <x-secondary-button class="px-8" @click="showCrearCasoModal = false">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </form>

    </div>
</div>