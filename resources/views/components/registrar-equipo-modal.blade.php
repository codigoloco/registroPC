<div x-show="showEquipoModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
    
    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showEquipoModal" class="fixed inset-0 transform transition-all" x-on:click="showEquipoModal = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showEquipoModal" class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        <!-- Encabezado del Formulario -->
        <div class="bg-blue-700 text-white px-6 py-4 flex justify-center items-center shadow-sm">
            <span class="text-xl font-bold">{{ __('Modificar Equipo') }}</span>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Sección: Consultar Cliente -->
            <div>
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('Consultar Cliente') }}</h3>
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex-grow">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <x-input type="text" placeholder="{{ __('Serial') }}" class="w-full pl-10" />
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <x-button class="bg-blue-700 hover:bg-blue-800 active:bg-blue-900 border-blue-700">
                            {{ __('Modificar') }}
                        </x-button>
                        <x-button class="bg-blue-700 hover:bg-blue-800 active:bg-blue-900 border-blue-700">
                            {{ __('Eliminar') }}
                        </x-button>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700">

            <!-- Sección: Detalles del Equipo -->
            <div>
                 <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('Detalles del Equipo') }}</h3>
                 <div class="grid grid-cols-1 gap-6">
                    <!-- Serial -->
                    <div>
                        <x-label value="Serial del Equipo" class="mb-1" />
                        <x-input type="text" name="serial_equipo" placeholder="Serial" class="w-full" required />
                    </div>
                    
                    <!-- Modelo -->
                    <div>
                         <x-label value="ID Modelo" class="mb-1" />
                         <x-input type="text" name="id_modelo" placeholder="ID Modelo" class="w-full" required />
                    </div>

                    <!-- Tipo -->
                    <div>
                         <x-label value="ID Tipo de Equipo" class="mb-1" />
                         <select name="id_tipo" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" required>
                            <option value="">{{ __('Seleccione Tipo') }}</option>
                            <option value="PC">PC</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Impresora">Impresora</option>
                         </select>
                    </div>
                 </div>
            </div>
        </div>

        <!-- Footer de Acciones -->
        <div class="bg-white dark:bg-gray-800 px-6 pb-8 flex justify-center gap-4">
            <x-button class="bg-blue-700 hover:bg-blue-800 active:bg-blue-900 border-blue-700 px-8 py-2 text-base">
                {{ __('Guardar') }}
            </x-button>
            <x-button class="bg-blue-700 hover:bg-blue-800 active:bg-blue-900 border-blue-700 px-8 py-2 text-base" @click="showEquipoModal = false">
                {{ __('Cancelar') }}
            </x-button>
        </div>

    </div>
</div>
