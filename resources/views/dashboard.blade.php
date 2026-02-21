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
                    <p>Generación de Reportes con selección de Fechas</p>
                </div>

                <div class="p-4 md:p-8">
                    {{-- Filters Section Component --}}
                    <x-dashboard-filters />

                    {{-- Visualization Section Component --}}
                    <div class="mt-8">
                        <x-dashboard-stats />
                    </div>


                </div>
            </div>
        </div>
    </div>
    {{-- Scripts específicos del dashboard manejados por Vite --}}
</x-app-layout>
