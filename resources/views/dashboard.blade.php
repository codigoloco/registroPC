<x-app-layout>
    @push('styles')
        @vite(['resources/css/dashboard.css'])
    @endpush

    @push('scripts')
        @vite(['resources/js/dashboard.js'])
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dashboard-card glass-panel">
                {{-- Header --}}
                <div class="dashboard-header">
                    <h2>Generar Gráficas y Estadística</h2>
                    <p>Generación de Reportes, Selección de Fechas y Exportación de Datos</p>
                </div>

                <div class="p-4 md:p-8">
                    {{-- Filters Section Component --}}
                    <x-dashboard-filters />

                    {{-- Visualization Section Component --}}
                    <div class="mt-8">
                        <x-dashboard-stats />
                    </div>

                    {{-- Bottom Actions --}}
                    <div class="flex justify-center gap-4 mt-8 pt-6">
                        <x-button class="bg-blue-800 hover:bg-blue-700 border-none">
                            Guardar Configuración
                        </x-button>
                        <x-secondary-button>
                            Restablecer Filtros
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
