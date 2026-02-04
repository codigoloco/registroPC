<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestion Equipos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            x-data="{ showModal: false, showEquipoModal: false, showModificarModal: false, showRecepcionModal: false, showConsultarModal: false}">

            <!-- Mensajes de Estado (Éxito/Error) -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md flex justify-between items-center rounded-r-lg transition-opacity duration-500"
                    x-transition:leave="opacity-0">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-700 hover:text-green-900">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-md rounded-r-lg">
                    <div class="flex items-center mb-2">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-bold">{{ __('¡Atención! Hay algunos errores:') }}</p>
                    </div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Botones para abrir los modales -->
            <div class="flex flex-col items-center gap-6">
                <!-- Fila 1: Equipos -->
                <div class="flex flex-wrap justify-center gap-4 w-full">
                    <x-button @click="showEquipoModal = true"
                        class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                        {{ __('REGISTRAR EQUIPO') }}
                    </x-button>

                    <x-button @click="showModificarModal = true"
                        class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                        {{ __('MODIFICAR EQUIPO') }}
                    </x-button>
                </div>

                <!-- Fila 2: Procesos -->
                <div class="flex flex-wrap justify-center gap-4 w-full">
                    <x-button @click="showRecepcionModal = true"
                        class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                        {{ __('REGISTRAR RECEPCIÓN DE EQUIPOS') }}
                    </x-button>

                    <x-button @click="showModal = true"
                        class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                        {{ __('REGISTRAR SALIDA DE EQUIPO') }}
                    </x-button>
                </div>

                <!-- Fila 3: Consultas -->
                <div class="flex flex-wrap justify-center gap-4 w-full">
                    <x-button @click="showConsultarModal = true"
                        class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                        {{ __('CONSULTA / MODIFICAR REGISTRO DE RECEPCIÓN') }}
                    </x-button>
                </div>
            </div>

            <!-- Tabla de Equipos Registrados -->
            <div
                class="mt-12 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2zm0 0h2a2 2 0 002-2v-4a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 002 2h2m-6-12l-2 2L9 3" />
                            </svg>
                            {{ __('Equipos Registrados') }}
                        </h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-blue-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('ID') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Serial') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Tipo') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Modelo') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Fecha Registro') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($equipos as $equipo)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{ $equipo->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            <span
                                                class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-md font-mono">
                                                {{ $equipo->serial_equipo }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $equipo->tipo->nombre ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $equipo->modelo->nombre ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $equipo->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                            {{ __('No hay equipos registrados actualmente.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6">
                        {{ $equipos->links() }}
                    </div>
                </div>
            </div>

            <!-- Modal Component: Recepción -->
            <x-registrar-recepcion-equipo-modal />

            <!-- Modal Component: Salida -->
            <x-registrar-entradas-modal />

            <!-- Modal Component: Registrar Equipo -->
            <x-registrar-equipo-modal />

            <!-- Modal Component: Modificar Equipo -->
            <x-modificar-equipo-modal />

            <!-- Modal Component: Consulta / Modificar Registro -->
            <x-consultar-recepcion-modal />

        </div>
    </div>
</x-app-layout>