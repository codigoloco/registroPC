<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Casos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            x-data="{
                showModal: false,
                showDocumentarModal: false,
                showRegistrarCasoModal: false,
                showCrearCasoModal: false,
                showAsignarTecnicoModal: false,
                showAssignedCasesModal: false,
                assignedCount: 0,
                async init() {
                    // obtener cantidad inicial de casos asignados para mostrar en el badge
                    try {
                        const response = await axios.get('/casos/asignados');
                        this.assignedCount = response.data.length;
                    } catch (e) {
                        console.error('No se pudo cargar el conteo de casos asignados', e);
                    }
                }
            }">

            <!-- Botones para abrir los modales -->
            <div class="flex flex-wrap justify-center gap-4">
                <x-button @click="showCrearCasoModal = true"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Crear Caso') }}
                </x-button>
                @if(!(Auth::user()->rol && strtolower(Auth::user()->rol->nombre) === 'soporte'))
                    <x-button @click="showAsignarTecnicoModal = true"
                        class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                        {{ __('Asignar Técnico') }}
                    </x-button>

                    <x-button @click="showRegistrarCasoModal = true"
                        class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                        {{ __('Consultar / Modificar Caso') }}
                    </x-button>
                @endif

                <x-button @click="showDocumentarModal = true"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Documentar Caso') }}
                </x-button>

                <!-- botón para mostrar casos asignados al técnico o todos si es admin -->
                <x-button @click="showAssignedCasesModal = true; $dispatch('refresh-assigned-cases')"
                    class="bg-green-600 hover:bg-green-700 active:bg-green-800 border-green-600 focus:ring-green-500 text-lg px-8 py-3 flex items-center">
                    {{ __('Mis Casos') }}
                    <span x-show="assignedCount > 0" x-text="assignedCount"
                        class="ml-2 inline-block bg-white text-green-600 text-xs font-semibold px-2 py-0.5 rounded-full"></span>
                </x-button>
            </div>

            <!-- Tabla de Casos Registrados -->
            <x-data-table
                title="Listado de Casos Registrados"
                :headers="[
                    ['label' => 'ID'],
                    ['label' => 'Cliente'],
                    ['label' => 'Técnico'],
                    ['label' => 'Descripción Falla'],
                    ['label' => 'Estatus'],
                    ['label' => 'Fecha'],
                ]"
                :paginator="$casos"
                search-placeholder="Buscar casos..."
                empty-message="No hay casos registrados actualmente."
            >
                <x-slot:icon>
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </x-slot:icon>
                @foreach ($casos as $caso)
                    <tr data-searchable class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
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
                @endforeach
            </x-data-table>

            <!-- Modal Component: Crear Caso -->
            <x-crear-caso-modal />

            <!-- Modal Component: Registrar Caso (Nuevo) -->
            @if(!(Auth::user()->rol && strtolower(Auth::user()->rol->nombre) === 'soporte'))
                <x-registrar-caso-modal />
            @endif

            <!-- Modal Component: Documentar Caso -->
            <x-documentar-caso-modal />

            <!-- Modal Component: Asignar Técnico -->
            @if(!(Auth::user()->rol && strtolower(Auth::user()->rol->nombre) === 'soporte'))
                <x-asignar-tecnico-modal />
            @endif

            <!-- Modal Component: Casos Asignados -->
            <x-casos-asignados-modal />


        </div>
</x-app-layout>