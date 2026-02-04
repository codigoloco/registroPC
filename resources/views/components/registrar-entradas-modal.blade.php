<div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">

    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showModal" class="fixed inset-0 transform transition-all" x-on:click="showModal = false"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <!-- Encabezado del Formulario (Dentro del modal) -->
        <div class="bg-blue-600 text-white px-6 py-4 flex justify-center items-center shadow-sm">
            <span class="text-xl font-bold">{{ __('Registrar Salida de Equipo') }}</span>
        </div>

        <div class="p-8">
            <div class="max-w-md mx-auto space-y-6">
                <!-- ID Caso -->
                <div>
                    <x-label value="ID Caso" class="mb-1" />
                    <x-input type="text" name="id_caso" placeholder="ID Caso" class="w-full" required />
                </div>

                <!-- Usuario Entrega -->
                <div>
                    <x-label value="ID Usuario Entrega" class="mb-1" />
                    <x-input type="text" name="id_usuario_entrega" placeholder="ID Usuario" class="w-full" required />
                </div>

                <!-- Entregado por -->
                <div>
                    <x-label value="Entregado por" class="mb-1" />
                    <select name="deposito"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                        <option value="Tecnico">Técnico</option>
                        <option value="Deposito">Depósito</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Footer de Acciones -->
        <div
            class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
            <x-button
                class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                {{ __('Guardar') }}
            </x-button>
            <x-secondary-button class="px-10" @click="showModal = false">
                {{ __('Cancelar') }}
            </x-secondary-button>
        </div>

    </div>
</div>