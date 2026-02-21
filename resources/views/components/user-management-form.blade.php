@props(['roles'])
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
                    <x-input type="text" placeholder="Buscar por correo o nombre..." class="w-full pl-10" x-model="searchEmail"
                        @focus="showEmailList = true"
                        @click.away="setTimeout(() => showEmailList = false, 200)"
                        @keyup.enter="showEmailList = false; buscarUsuario()"
                        autocomplete="off" />

                    <!-- Dropdown de correos -->
                    <div x-show="showEmailList && filteredEmails.length > 0"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                        <template x-for="userItem in filteredEmails" :key="userItem.email">
                            <div @click="selectEmail(userItem)"
                                 class="px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="userItem.email"></span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400" x-text="userItem.name + ' ' + (userItem.lastname || '')"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-button type="button" @click="showEmailList = false; buscarUsuario()"
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
                    <x-input type="text" name="name" placeholder="Nombre" class="w-full" x-model="user.name" x-imask="'text'" required />
                </div>
                <div>
                    <x-label value="Apellido" class="mb-1" />
                    <x-input type="text" name="lastname" placeholder="Apellido" class="w-full" x-model="user.lastname" x-imask="'text'"
                        required />
                </div>

                {{-- Row 2 --}}
                <div>
                    <x-label value="Correo Electrónico" class="mb-1" />
                    <x-input type="email" placeholder="Correo Electrónico" class="w-full bg-gray-100 cursor-not-allowed"
                        x-model="user.email" readonly />
                </div>
                <div x-data="{ show: false }">
                    <x-label value="Nueva Contraseña (Opcional)" class="mb-1" />
                    <div class="relative">
                        <x-input ::type="show ? 'text' : 'password'" name="password" placeholder="********" class="w-full pr-10" />
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ __('La contraseña debe tener al menos 8 caracteres.') }}</p>
                </div>

                {{-- Row 3 --}}
                <div x-data="{ show: false }">
                    <x-label value="Confirmar Nueva Contraseña" class="mb-1" />
                    <div class="relative">
                        <x-input ::type="show ? 'text' : 'password'" name="password_confirmation" placeholder="********" class="w-full pr-10" />
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ __('La contraseña debe tener al menos 8 caracteres.') }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <x-label value="Rol / Permiso" class="mb-2" />
                    <select name="id_rol" x-model="user.id_rol" required
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10">
                        <option value="">{{ __('Seleccione un rol...') }}</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}">{{ ucfirst($rol->nombre) }}</option>
                        @endforeach
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