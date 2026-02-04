<div x-show="showEquipoModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">

    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showEquipoModal" class="fixed inset-0 transform transition-all" x-on:click="showEquipoModal = false"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showEquipoModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <!-- Encabezado del Formulario -->
        <div class="bg-blue-700 text-white px-6 py-4 flex justify-center items-center shadow-sm">
            <span class="text-xl font-bold">{{ __('Registrar Equipo') }}</span>
        </div>

        <form action="{{ route('equipos.save') }}" method="POST">
            @csrf
            <div class="p-8 space-y-6">

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
                            <x-label value="Modelo" class="mb-1" />
                            <x-input type="text" name="nombre_modelo" placeholder="Nombre del Modelo" class="w-full"
                                required />
                        </div>

                        <!-- Tipo -->
                        <div>
                            <x-label value="Tipo de Equipo" class="mb-1" />
                            <select name="nombre_tipo"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full"
                                required>
                                <option value="">{{ __('Seleccione Tipo') }}</option>
                                <option value="Servidor">Servidor</option>
                                <option value="PC">PC</option>
                                <option value="Laptop">Laptop</option>
                                <option value="TodoEnUno">TodoEnUno</option>
                                <option value="MiniPC">MiniPC</option>
                                <option value="MiniPortatil">MiniPortatil</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Monitor">Monitor</option>
                                <option value="Accesorios">Accesorios</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer de Acciones -->
            <div class="bg-white dark:bg-gray-800 px-6 pb-8 flex justify-center gap-4">
                <x-button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 active:bg-blue-900 border-blue-700 px-8 py-2 text-base">
                    {{ __('Guardar') }}
                </x-button>
                <x-button type="button"
                    class="bg-blue-700 hover:bg-blue-800 active:bg-blue-900 border-blue-700 px-8 py-2 text-base"
                    @click="showEquipoModal = false">
                    {{ __('Cancelar') }}
                </x-button>
            </div>
        </form>

    </div>
</div>