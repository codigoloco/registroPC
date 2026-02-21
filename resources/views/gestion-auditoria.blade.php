<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Auditoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ showModal: false, showAuditoriaModal: false }">
            
            <!-- Botones para abrir los modales -->
            <div class="flex flex-wrap justify-center gap-4">
                <x-button @click="showAuditoriaModal = true" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3">
                    {{ __('Consultar Auditoria') }}
                </x-button>
                <!-- Usar mismo estilo azul que el botón de consulta para consistencia -->
                <a href="{{ route('recepcion.pdf') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3 rounded">
                    {{ __('PDF - Registro Recepción') }}
                </a>
                <a href="{{ route('salidas.pdf') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3 rounded">
                    {{ __('PDF - Registro Salidas') }}
                </a>
                <a href="{{ route('estadisticas.pdf') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 text-lg px-8 py-3 rounded">
                    {{ __('PDF - Estadísticas') }}
                </a>
            
            <div/>            
        </div>

        <x-consultar-auditoria-modal />        

    </div>
</x-app-layout>
