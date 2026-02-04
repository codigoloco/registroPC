<div x-show="showRegistrarCasoModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
    
    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showRegistrarCasoModal" class="fixed inset-0 transform transition-all" x-on:click="showRegistrarCasoModal = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showRegistrarCasoModal" class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Registrar / Modificar Caso') }}</span>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Consultar Caso -->
            <div>
                 <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-3 text-base">{{ __('Consultar Caso') }}</h3>
                 <div class="flex gap-4">
                     <div class="flex-grow">
                         <x-input type="text" placeholder="Serial" class="w-full" />
                     </div>
                     <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                        {{ __('Modificar') }}
                     </x-button>
                 </div>
            </div>

            <!-- Detalles del Caso -->
            <div>
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Detalles del Caso') }}</h3>
                
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md space-y-4">
                    
                    <!-- Serial -->
                    <div class="grid grid-cols-3 gap-4 items-center">
                        <label class="text-sm text-gray-700 dark:text-gray-300">Cliente</label>
                        <div class="col-span-2">
                             <x-input type="text" class="w-full" />
                        </div>
                    </div>

                    <!-- Modelo + Tipo (Row) -->
                    <div class="grid grid-cols-3 gap-4 items-center">
                        <label class="text-sm text-gray-700 dark:text-gray-300">Modelo</label>
                         <div class="col-span-2 flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">Tipo</span>
                             <x-input type="text" class="w-full" />
                        </div>
                    </div>

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
                             <x-input type="text" name="pieza_sugerida" class="w-full" maxlength="100" placeholder="Opcional" />
                        </div>
                    </div>

                     <!-- Forma de Atención (Select) -->
                    <div class="grid grid-cols-3 gap-4 items-center">
                        <label class="text-sm text-gray-700 dark:text-gray-300">Forma de Atención</label>
                         <div class="col-span-2">
                             <select name="forma_de_atencion" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                                <option value="encomienda">Encomienda</option>
                                <option value="presencial">Presencial</option>
                             </select>
                        </div>
                    </div>

                    <!-- Estatus (Select) -->
                    <div class="grid grid-cols-3 gap-4 items-center">
                        <label class="text-sm text-gray-700 dark:text-gray-300">Estatus</label>
                         <div class="col-span-2">
                             <select name="estatus" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                                <option value="asignado">Asignado</option>
                                <option value="espera">Espera</option>
                                <option value="reparado">Reparado</option>
                                <option value="entregado">Entregado</option>
                             </select>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
            <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-8">
                {{ __('Guardar') }}
            </x-button>
            <x-secondary-button class="px-8" @click="showRegistrarCasoModal = false">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </div>

    </div>
</div>
