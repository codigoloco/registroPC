<div class="mb-8">
    <h3 class="section-title">Filtros de Reporte y Fechas</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
        {{-- Date Filters --}}
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="w-full">
                <x-label value="Fecha Inicio" class="mb-2" />
                <x-input type="date" class="w-full" />
            </div>
            <div class="w-full">
                <x-label value="Fecha Fin" class="mb-2" />
                <x-input type="date" class="w-full" />
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-6">
        {{-- Graph Type --}}
        <div>
            <x-label value="Tipo Gráfica" class="mb-3" />
            <div class="checkbox-group">
                <label class="flex items-center">
                    <x-checkbox checked />
                    <span class="ml-2 text-sm text-gray-600">Casos Creados</span>
                </label>
                <label class="flex items-center">
                    <x-checkbox />
                    <span class="ml-2 text-sm text-gray-600">Fallas Reportadas</span>
                </label>
                <label class="flex items-center">
                    <x-checkbox />
                    <span class="ml-2 text-sm text-gray-600">Casos Cerrados</span>
                </label>
            </div>
        </div>

        {{-- Role Filter --}}
        <div>
            <x-label value="Ver por Rol" class="mb-3" />
            <div class="checkbox-group">
                <label class="flex items-center">
                    <x-checkbox />
                    <span class="ml-2 text-sm text-gray-600">Administrador</span>
                </label>
                <label class="flex items-center">
                    <x-checkbox checked />
                    <span class="ml-2 text-sm text-gray-600">Supervisor</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-wrap gap-4 pt-4 border-t border-gray-100">
        <x-button class="bg-blue-800 hover:bg-blue-700 active:bg-blue-900 border-none">
            Generar Estadística
        </x-button>
        <x-secondary-button>
            Administrador
        </x-secondary-button>
        <x-secondary-button>
            Exportar Reporte (PDF/XLSX)
        </x-secondary-button>
    </div>
</div>
