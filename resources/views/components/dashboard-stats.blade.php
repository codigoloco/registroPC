<div>
    <h3 class="section-title mb-4">Visualización de Datos</h3>
    
    {{-- Chart Container --}}
    <div id="chartContainer" class="hidden bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <h4 id="chartTitle" class="text-center text-sm font-semibold text-gray-600 mb-4">Gráfica de Reporte</h4>
        <div class="chart-container" style="height: 400px; position: relative; background: #fff;">
            <canvas id="reportChart"></canvas>
        </div>
    </div>

    {{-- Table Container --}}
    <div id="tableContainer" class="hidden bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-50">
            <h4 id="tableTitle" class="text-sm font-semibold text-gray-600">Tabla de Datos</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="stats-table w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Concepto / Etiqueta</th>
                        <th class="px-6 py-3">Total / Valor</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Dynamic Rows -->
                </tbody>
            </table>
        </div>
    </div>

    {{-- Initial State Message --}}
    <div id="initialState" class="text-center p-8 text-gray-500">
        <p>Seleccione un tipo de reporte y haga clic en "Generar" para visualizar los datos.</p>
    </div>
</div>
