<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestion Equipos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ showModal: false, showEquipoModal: false, showRecepcionModal: false}">
            
            <!-- Botones para abrir los modales -->
            <div class="flex flex-wrap justify-center gap-4">
                <x-button @click="showRecepcionModal = true" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Registrar Recepción') }}
                </x-button>
 
                <x-button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Registrar Salida de Equipo') }}
                </x-button>

                <x-button @click="showEquipoModal = true" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Modificar Equipo') }}
                </x-button>
            </div>
            
            <!-- Modal Component: Recepción -->
            <x-registrar-recepcion-equipo-modal />

            <!-- Modal Component: Salida -->
            <x-registrar-entradas-modal />
            
            <!-- Modal Component: Registrar Equipo -->
            <x-registrar-equipo-modal />

        </div>
    </div>
</x-app-layout>