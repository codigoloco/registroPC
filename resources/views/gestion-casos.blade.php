<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Casos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            x-data="{ showModal: false, showDocumentarModal: false, showRegistrarCasoModal: false, showCrearCasoModal: false }">

            <!-- Botones para abrir los modales -->
            <div class="flex flex-wrap justify-center gap-4">
                <x-button @click="showCrearCasoModal = true"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Crear Caso') }}
                </x-button>

                <x-button @click="showRegistrarCasoModal = true"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Consultar / Modificar Caso') }}
                </x-button>

                <x-button @click="showDocumentarModal = true"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Documentar Caso') }}
                </x-button>
            </div>

            <!-- Tabla de Casos Registrados -->
            <div
                class="mt-12 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            {{ __('Listado de Casos Registrados') }}
                        </h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-blue-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('ID') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Cliente') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Técnico') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Descripción Falla') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Estatus') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        {{ __('Fecha') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($casos as $caso)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                            #{{ $caso->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $caso->cliente->nombre ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $caso->tecnico->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                            {{ $caso->descripcion_falla }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($caso->estatus == 'espera') bg-yellow-100 text-yellow-800 
                                                    @elseif($caso->estatus == 'asignado') bg-blue-100 text-blue-800
                                                    @elseif($caso->estatus == 'reparado') bg-green-100 text-green-800
                                                    @elseif($caso->estatus == 'entregado') bg-gray-100 text-gray-800
                                                    @endif">
                                                {{ ucfirst($caso->estatus) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $caso->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                            {{ __('No hay casos registrados actualmente.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6">
                        {{ $casos->links() }}
                    </div>
                </div>
            </div>

            <!-- Modal Component: Crear Caso -->
            <x-crear-caso-modal />

            <!-- Modal Component: Registrar Caso (Nuevo) -->
            <x-registrar-caso-modal />

            <!-- Modal Component: Documentar Caso -->
            <x-documentar-caso-modal />


        </div>
</x-app-layout>