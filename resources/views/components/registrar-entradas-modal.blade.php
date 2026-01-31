<div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
    
    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showModal" class="fixed inset-0 transform transition-all" x-on:click="showModal = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showModal" class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        <!-- Encabezado del Formulario (Dentro del modal) -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center shadow-sm">
            <span class="font-bold text-lg mr-4 bg-blue-700 px-3 py-1 rounded">CU 008</span>
            <span class="text-lg font-semibold">{{ __('Registrar Salida de Equipo') }}</span>
        </div>

        <div class="p-8 space-y-8">
            
            <!-- Sección: Consultar Caso / Cliente -->
            <div>
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">{{ __('Consultar Caso / Cliente') }}</h3>
                <div class="flex flex-wrap items-end gap-4">
                    <div class="w-full md:w-1/4">
                        <x-label for="id_caso" value="{{ __('ID Caso') }}" class="sr-only" />
                        <x-input id="id_caso" type="text" placeholder="{{ __('ID Caso') }}" class="w-full" />
                    </div>
                    <div class="w-full md:w-1/4">
                        <x-label for="id_cliente" value="{{ __('ID Cliente') }}" class="sr-only" />
                        <x-input id="id_cliente" type="text" placeholder="{{ __('ID Cliente') }}" class="w-full" />
                    </div>
                    <div>
                        <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                            {{ __('Consultar Cliente') }}
                        </x-button>
                    </div>
                </div>
            </div>

            <!-- Sección: Detalles del Caso -->
            <div>
                 <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">{{ __('Detalles del Caso') }}</h3>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-label for="estado_caso" value="{{ __('Estado del Caso') }}" class="mb-1" />
                        <x-input id="estado_caso" type="text" class="w-full bg-gray-50 dark:bg-gray-900" readonly />
                    </div>
                    <div>
                        <x-label for="cliente_nombre" value="{{ __('Cliente') }}" class="mb-1" />
                        <x-input id="cliente_nombre" type="text" placeholder="ORCO" class="w-full" />
                    </div>
                     <div>
                        <x-label for="equipo_info" value="{{ __('Equipo (Serial/Modelo)') }}" class="mb-1" />
                        <x-input id="equipo_info" type="text" placeholder="{{ __('Equipo (Serial/Modelo)') }}" class="w-full" />
                    </div>
                 </div>
            </div>

            <!-- Sección: Generar / Validar -->
            <div>
                 <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">{{ __('Generar / Validar') }}</h3>
                 <div class="space-y-6">
                    <label for="validar_estatus" class="inline-flex items-center cursor-pointer">
                        <x-checkbox id="validar_estatus" checked />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Validar Estatus de Entrega') }}</span>
                    </label>

                    <div class="flex flex-wrap gap-4">
                        <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                            {{ __('Generar Nota de Entrega') }}
                        </x-button>
                        <x-secondary-button>
                            {{ __('Imprimir Nota') }}
                        </x-secondary-button>
                    </div>
                 </div>
            </div>
        </div>

        <!-- Footer de Acciones -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
            <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                {{ __('Guardar') }}
            </x-button>
            <x-secondary-button class="px-10" @click="showModal = false">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </div>

    </div>
</div>
