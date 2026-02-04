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
                    {{ __('MODIFICAR CASO') }}
                </x-button>

                <x-button @click="showDocumentarModal = true"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Documentar Caso') }}
                </x-button>


                <div />
            </div>

            <!-- Modal Component: Crear Caso -->
            <x-crear-caso-modal />

            <!-- Modal Component: Registrar Caso (Nuevo) -->
            <x-registrar-caso-modal />

            <!-- Modal Component: Documentar Caso -->
            <x-documentar-caso-modal />


        </div>
</x-app-layout>