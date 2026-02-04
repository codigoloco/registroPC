<div x-show="showCrearModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">

    <!-- Fondo Oscuro -->
    <div x-show="showCrearModal" class="fixed inset-0 transform transition-all" x-on:click="showCrearModal = false"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showCrearModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-4xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center shadow-sm justify-between">
            <span class="text-lg font-semibold">{{ __('Crear Nuevo Usuario') }}</span>
            <button @click="showCrearModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('users.save') }}" method="POST">
            @csrf
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Left Column: Personal Info --}}
                    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label value="Nombre" class="mb-1" />
                            <x-input type="text" name="name" placeholder="Nombre" class="w-full" required />
                        </div>
                        <div>
                            <x-label value="Apellido" class="mb-1" />
                            <x-input type="text" name="lastname" placeholder="Apellido" class="w-full" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-label value="Correo Electrónico" class="mb-1" />
                            <x-input type="email" name="email" placeholder="correo@ejemplo.com" class="w-full"
                                required />
                        </div>
                        <div>
                            <x-label value="Contraseña" class="mb-1" />
                            <x-input type="password" name="password" placeholder="********" class="w-full" required />
                        </div>
                        <div>
                            <x-label value="Confirmar Contraseña" class="mb-1" />
                            <x-input type="password" name="password_confirmation" placeholder="********" class="w-full"
                                required />
                        </div>
                    </div>

                    {{-- Right Column: Roles --}}
                    <div class="space-y-4">
                        <div>
                            <x-label value="Rol / Permiso" class="mb-2 font-bold" />
                            <select name="role"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10"
                                required>
                                <option value="">{{ __('Seleccione un rol...') }}</option>
                                <option value="Recepcionista">Recepcionista</option>
                                <option value="Soporte">Soporte</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>

                        <div>
                            <x-label value="Estatus" class="mb-2 font-bold" />
                            <select name="id_estatus"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10"
                                required>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                                <option value="3">Vacaciones</option>
                                <option value="4">Jubilado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
                <x-button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                    {{ __('Crear Usuario') }}
                </x-button>
                <x-secondary-button class="px-10" @click="showCrearModal = false">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </form>

    </div>
</div>