<div x-show="showDocumentarModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">

    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showDocumentarModal" class="fixed inset-0 transform transition-all"
        x-on:click="showDocumentarModal = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showDocumentarModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-data="{
            searchId: '',
            caso: null,
            piezas: [],
            loading: false,
            error: '',
            entries: [{ piece: '', qty: 1 }],
            init() {
                fetch('/piezas')
                    .then(response => response.json())
                    .then(data => this.piezas = data);
            },
            buscarCaso() {
                if (!this.searchId) return;
                this.loading = true;
                this.error = '';
                fetch(`/casos/search/${this.searchId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            this.error = 'Caso no encontrado.';
                            this.caso = null;
                        } else {
                            this.caso = data;
                        }
                    })
                    .catch(err => {
                        this.error = 'Error en la búsqueda';
                        this.caso = null;
                    })
                    .finally(() => this.loading = false);
            }
        }">

        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Documentar Caso') }}</span>
            <button @click="showDocumentarModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('casos.documentar') }}" method="POST">
            @csrf
            <div class="p-8 space-y-8">

                <!--Caso -->
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 text-base">{{ __('Caso') }}</h3>
                    <div class="flex gap-4 relative">
                        <div class="flex-grow">
                            <x-input type="text" name="id_caso" x-model="searchId" @keyup.enter="buscarCaso()"
                                placeholder="ID del Caso (Ej: 1001)" class="w-full" required />
                        </div>
                        <button type="button" @click="buscarCaso()"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            {{ __('Consultar') }}
                        </button>
                    </div>
                    <p x-show="error" class="text-xs text-red-500 mt-2" x-text="error"></p>
                    <div x-show="caso" class="mt-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg text-sm space-y-1">
                        <p class="font-bold text-blue-600">Cliente: <span
                                class="font-normal text-gray-700 dark:text-gray-300"
                                x-text="caso.cliente.nombre + ' ' + (caso.cliente.apellido || '')"></span></p>
                        <p class="font-bold text-blue-600">Descripción: <span
                                class="font-normal text-gray-700 dark:text-gray-300"
                                x-text="caso.descripcion_falla"></span></p>
                    </div>
                    <div class="mt-4 border-b border-gray-200 dark:border-gray-700 border-dashed"></div>
                </div>

                <!-- Detalles del Caso -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 dark:text-gray-100 text-base">
                            {{ __('Documentar Uso de Pieza / Servicio') }}
                        </h3>
                        <button type="button" @click="entries.push({ piece: '', qty: 1 })"
                            class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            {{ __('Añadir') }}
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(entry, index) in entries" :key="index">
                            <div
                                class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700 relative">
                                <button type="button" x-show="entries.length > 1" @click="entries.splice(index, 1)"
                                    class="absolute top-2 right-2 text-red-500 hover:text-red-700 transition-colors"
                                    title="Eliminar fila">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                    <div>
                                        <x-label value="Pieza / Servicio" class="mb-1 text-xs" />
                                        <select name="id_pieza_soporte[]" x-model="entry.piece"
                                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10"
                                            required>
                                            <option value="">{{ __('Seleccione...') }}</option>
                                            <template x-for="p in piezas" :key="p.id">
                                                <option :value="p.id" x-text="p.nombre"></option>
                                            </template>
                                        </select>
                                    </div>
                                    <div>
                                        <x-label value="Cantidad" class="mb-1 text-xs" />
                                        <x-input type="number" name="cantidad[]" x-model="entry.qty"
                                            placeholder="Cantidad" class="w-full" min="1" required />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="mt-6">
                        <x-label value="Observación General" class="mb-1" />
                        <textarea name="observacion" placeholder="Observación (Opcional)"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-24"></textarea>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div
                class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
                <x-button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10"
                    ::disabled="!caso">
                    {{ __('Guardar Cambios') }}
                </x-button>
                <x-secondary-button class="px-10" @click="showDocumentarModal = false">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </form>

    </div>
</div>