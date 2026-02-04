<div>
    <!-- Sección: Consultar Usuario -->
    <div>
        <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">
            {{ __('Consultar Usuario') }}
        </h3>
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-2/3 relative">
                <x-label value="Correo Electrónico" class="mb-1" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <x-input type="text" placeholder="Ingrese Correo" class="w-full pl-10" x-model="searchEmail"
                        @keyup.enter="buscarUsuario()" />
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-button type="button" @click="buscarUsuario()"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                    <span x-show="!loading">{{ __('Consultar') }}</span>
                    <span x-show="loading">{{ __('Buscando...') }}</span>
                </x-button>
            </div>
        </div>
        <template x-if="error">
            <p class="text-red-500 text-xs mt-2" x-text="error"></p>
        </template>
    </div>

    <!-- Sección: Detalles del Usuario -->
    <div class="mt-8">
        <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">
            {{ __('Detalles del Usuario') }}
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Personal Info --}}
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Row 1 --}}
                <div>
                    <x-label value="Nombre" class="mb-1" />
                    <x-input type="text" name="name" placeholder="Nombre" class="w-full" x-model="user.name" required />
                </div>
                <div>
                    <x-label value="Apellido" class="mb-1" />
                    <x-input type="text" name="lastname" placeholder="Apellido" class="w-full" x-model="user.lastname"
                        required />
                </div>

                {{-- Row 2 --}}
                <div>
                    <x-label value="Correo Electrónico" class="mb-1" />
                    <x-input type="email" placeholder="Correo Electrónico" class="w-full bg-gray-100 cursor-not-allowed"
                        x-model="user.email" readonly />
                </div>
                <div>
                    <x-label value="Nueva Contraseña (Opcional)" class="mb-1" />
                    <x-input type="password" name="password" placeholder="********" class="w-full" />
                </div>

                {{-- Row 3 --}}
                <div>
                    <x-label value="Confirmar Nueva Contraseña" class="mb-1" />
                    <x-input type="password" name="password_confirmation" placeholder="********" class="w-full" />
                </div>
            </div>

            {{-- Right Column: Roles --}}
            <div class="space-y-4">
                <div>
                    <x-label value="Rol / Permiso" class="mb-2" />
                    <select name="role" x-model="user.role" required
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                        <option value="">{{ __('Seleccione un rol...') }}</option>
                        <option value="Recepcionista">Recepcionista</option>
                        <option value="Soporte">Soporte</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                </div>

                <div>
                    <x-label value="Estatus" class="mb-2" />
                    <select name="id_estatus" x-model="user.id_estatus" required
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                        <option value="3">Vacaciones</option>
                        <option value="4">Jubilado</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>