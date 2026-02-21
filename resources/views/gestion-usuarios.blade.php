<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            x-data="{ showModal: false, showCrearModal: false, showAuditoriaModal: false }">

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
            <div class="flex flex-wrap justify-center gap-4">
                <x-button @click="showCrearModal = true"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('CREAR USUARIO') }}
                </x-button>

                <x-button @click="showModal = true"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('MODIFICAR USUARIO') }}
                </x-button>
            </div>

            <!-- Tabla de Usuarios Registrados -->
            <x-data-table
                title="Listado de Usuarios Registrados"
                :headers="[
                    ['label' => 'ID'],
                    ['label' => 'Nombre Completo'],
                    ['label' => 'Email'],
                    ['label' => 'Rol'],
                    ['label' => 'Estatus'],
                    ['label' => 'Fecha Registro'],
                ]"
                :paginator="$users"
                search-placeholder="Buscar usuarios..."
                empty-message="No hay usuarios registrados actualmente."
            >
                <x-slot:icon>
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </x-slot:icon>
                @foreach ($users as $user)
                    <tr data-searchable class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                            {{ $user->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                            {{ $user->name }} {{ $user->lastname }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 capitalize text-center">
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded text-xs font-semibold">
                                {{ $user->rol->nombre ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($user->id_estatus == 1) bg-green-100 text-green-800 
                                    @else bg-red-100 text-red-800 
                                    @endif">
                                {{ $user->id_estatus == 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                @endforeach
            </x-data-table>

            <!-- Modal: User Management -->
            <x-user-management-modal :roles="$roles" :users="$users" />

            <!-- Modal: Crear Usuario -->
            <x-crear-usuario-modal :roles="$roles" />

        </div>
    </div>
</x-app-layout>