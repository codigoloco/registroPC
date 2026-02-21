@once
    @push('scripts')
        @vite('resources/js/asignarTecnico.js')
    @endpush
@endonce

<div x-show="showAsignarTecnicoModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
    x-data="asignarTecnico()">

    <!-- Fondo Oscuro -->
    <div x-show="showAsignarTecnicoModal" class="fixed inset-0 transform transition-all"
        @click="showAsignarTecnicoModal = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showAsignarTecnicoModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between">
            <span class="text-lg font-bold">{{ __('Asignar Técnico a Caso') }}</span>
            <button @click="showAsignarTecnicoModal = false" class="text-white hover:text-gray-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('casos.asignar-tecnico') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
                <!-- Buscador de Caso -->
                <div>
                    <x-label value="Seleccionar Caso" class="mb-1" />
                    <div class="relative">
                        <x-input 
                            type="text" 
                            x-model="searchCaso" 
                            @focus="showCasosList = true"
                            @click.away="showCasosList = false"
                            placeholder="Buscar ID o Cliente..." 
                            class="w-full" 
                            autocomplete="off"
                            required
                        />
                        <input type="hidden" name="id_caso" :value="selectedCasoId">
                        
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
                    </div>
                </div>

                <!-- Selección de Técnico -->
                <div>
                    <x-label value="Asignar a Técnico (Soporte)" class="mb-1" />
                    <select name="id_usuario" 
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required>
                        <option value="">{{ __('Seleccione un técnico...') }}</option>
                        <template x-for="tecnico in tecnicos" :key="tecnico.id">
                            <option :value="tecnico.id" x-text="tecnico.name + ' ' + (tecnico.lastname || '')"></option>
                        </template>
                    </select>
                </div>

                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-sm text-blue-700 dark:text-blue-300">
                    <p>
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Al asignar un técnico, el estatus del caso cambiará automáticamente a "Asignado".') }}
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-end gap-3 border-t border-gray-200 dark:border-gray-600">
                <x-secondary-button @click="showAsignarTecnicoModal = false">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800" ::disabled="!selectedCasoId">
                    {{ __('Asignar') }}
                </x-button>
            </div>
        </form>
    </div>
</div>
