<div x-show="showRecepcionModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
    
    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showRecepcionModal" class="fixed inset-0 transform transition-all" x-on:click="showRecepcionModal = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showRecepcionModal" class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-3xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Registrar Recepción de Equipo') }}</span>
            <button @click="showRecepcionModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Columna Izquierda: Consultar Caso -->
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-lg">{{ __('Consultar Caso') }}</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <x-label value="ID Caso" class="mb-1 text-gray-700" />
                            <x-input type="text" placeholder="ID Caso" class="w-full" />
                        </div>

                        <div class="flex gap-2 items-end">
                            <div class="flex-grow">
                                <x-input type="text" placeholder="ID Técnico Asignado" class="w-full" />
                            </div>
                            <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                                {{ __('Consultar') }}
                            </x-button>
                        </div>

                         <div class="mt-2">
                            <label class="flex items-center cursor-pointer">
                                <x-checkbox />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Titular por posesión de equipo</span>
                            </label>
                        </div>

                        <div class="flex flex-wrap gap-2 mt-6">
                            <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-xs px-4">
                                {{ __('Generar Nota Recepción') }}
                            </x-button>
                            <x-secondary-button class="text-xs px-4">
                                {{ __('Pago Diagnóstico') }}
                            </x-secondary-button>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Asignar Técnico -->
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-lg">{{ __('Asignar Técnico') }}</h3>
                    <div class="space-y-4">
                        <x-input type="text" placeholder="Entradas" class="w-full" />
                        <x-input type="text" class="w-full" />
                        <!-- Empty space filler to match height if needed -->
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
            <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                {{ __('Guardar') }}
            </x-button>
            <x-secondary-button class="px-10" @click="showRecepcionModal = false">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </div>

    </div>
</div>
