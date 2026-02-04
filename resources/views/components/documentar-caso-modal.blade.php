<div x-show="showDocumentarModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">
    
    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showDocumentarModal" class="fixed inset-0 transform transition-all" x-on:click="showDocumentarModal = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showDocumentarModal" class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Documentar Caso') }}</span>
            <button @click="showDocumentarModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-8 space-y-8">
            
            <!-- Consultar Pieza -->
            <div>
                 <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Consultar Pieza') }}</h3>
                 <div class="flex gap-4">
                     <div class="flex-grow">
                         <x-input type="text" placeholder="Consultar Pieza por ID" class="w-full" />
                     </div>
                     <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                        {{ __('Solicitar Pieza') }}
                     </x-button>
                 </div>
                 <div class="mt-4 border-b border-gray-200 dark:border-gray-700 border-dashed"></div>
            </div>

            <!-- Detalles del Caso -->
            <div>
                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Documentar Uso de Pieza') }}</h3>
                
                <div class="grid grid-cols-3 gap-4 mb-4 items-center">
                    <label class="text-sm text-gray-600 dark:text-gray-400 font-medium">Pieza (ID):</label>
                    <div class="col-span-2">
                        <x-input type="number" name="id_pieza_soporte" placeholder="ID Pieza Soporte" class="w-full" required />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4 items-center">
                    <label class="text-sm text-gray-600 dark:text-gray-400 font-medium">Cantidad:</label>
                    <div class="col-span-2">
                         <x-input type="number" name="cantidad" placeholder="Cantidad" class="w-full" min="1" required />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4 items-center">
                    <label class="text-sm text-gray-600 dark:text-gray-400 font-medium">Observación:</label>
                    <div class="col-span-2">
                        <textarea name="observacion" placeholder="Observación (Opcional)" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-24"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
            <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                {{ __('Guardar Cambios') }}
            </x-button>
            <x-secondary-button class="px-10" @click="showDocumentarModal = false">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </div>

    </div>
</div>
