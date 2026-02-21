<div class="mb-8">
    <h3 class="section-title">Filtros de Reporte y Fechas</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
        {{-- Report Selection --}}
        <div>
           <x-label value="Tipo de Reporte" class="mb-2" />
           <select id="tipoReporte" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full">
                <option value="recibidos_atencion">Recibidos por tipo de atención</option>
                <option value="recibidos_tipo_equipo">Recibidos por Tipo de equipo</option>
                <option value="entregados_atencion">Entregados por tipo de atención</option>
                <option value="entregados_tipo_equipo">Entregados por Tipo de equipo</option>
                <option value="piezas_soporte">Piezas/Atención por Soporte</option>
           </select>
        </div>

        {{-- Date Filters --}}
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="w-full">
                <x-label value="Fecha Inicio" class="mb-2" />
                <x-input type="date" id="fechaInicio" class="w-full" />
            </div>
            <div class="w-full">
                <x-label value="Fecha Fin" class="mb-2" />
                <x-input type="date" id="fechaFin" class="w-full" />
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-wrap gap-4 pt-4 border-t border-gray-100">
        <x-button onclick="generarReporte('grafica')" class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-none shadow-sm">
            {{ __('Generar Gráfica') }}
        </x-button>
        <x-secondary-button onclick="generarReporte('estadistica')" class="border-blue-200 text-blue-700 hover:bg-blue-50">
            {{ __('Generar Estadística') }}
        </x-secondary-button>
    </div>
</div>
