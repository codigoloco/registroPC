<div>
    <!-- Sección: Consultar Usuario -->
    <div>
        <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">{{ __('Consultar Usuario') }}</h3>
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/3 relative">
                <x-label value="Usuario ID / Email" class="mb-1" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <x-input type="text" placeholder="Ingrese ID o Correo" class="w-full pl-10" />
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-button class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                    {{ __('Consultar') }}
                </x-button>
                <x-secondary-button>
                    {{ __('Eliminar Usuario') }}
                </x-secondary-button>
                <x-secondary-button>
                    {{ __('Asignar Roles') }}
                </x-secondary-button>
            </div>
        </div>
    </div>

    <!-- Sección: Detalles del Usuario -->
    <div class="mt-8">
        <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">{{ __('Detalles del Usuario') }}</h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Personal Info --}}
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Row 1 --}}
                <div>
                    <x-label value="Nombre" class="mb-1" />
                    <x-input type="text" placeholder="Nombre" class="w-full" />
                </div>
                <div>
                    <x-label value="Apellido" class="mb-1" />
                    <x-input type="text" placeholder="Apellido" class="w-full" />
                </div>

                {{-- Row 2 --}}
                <div>
                    <x-label value="Correo Electrónico" class="mb-1" />
                    <x-input type="email" placeholder="Correo Electrónico" class="w-full" />
                </div>
                <div>
                    <x-label value="Contraseña" class="mb-1" />
                    <x-input type="password" placeholder="********" class="w-full" />
                </div>

                {{-- Row 3 --}}
                <div>
                    <x-label value="Confirmar Contraseña" class="mb-1" />
                    <x-input type="password" placeholder="********" class="w-full" />
                </div>
            </div>

            {{-- Right Column: Roles --}}
            <div>
                <x-label value="Roles" class="mb-2" />
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700 h-full">
                    <div class="space-y-3">
                        <label class="flex items-center cursor-pointer">
                            <x-checkbox checked />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Administrador</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <x-checkbox />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Supervisor</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <x-checkbox />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Técnico</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
