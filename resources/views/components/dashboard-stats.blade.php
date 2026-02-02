<div>
    <h3 class="section-title">Visualización de Datos</h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Chart --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <h4 class="text-center text-sm font-semibold text-gray-600 mb-4">Gráfica de Barras - Casos Mensuales</h4>
            <div class="chart-container" style="height: 300px; position: relative; background: #fff;">
                <canvas id="statsChart"></canvas>
            </div>
        </div>

        {{-- Stats Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-50">
                <h4 class="text-sm font-semibold text-gray-600">Tabla de Estadísticas</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Creados</th>
                            <th>Cerrados</th>
                            <th>Promedio Días</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Enero</td>
                            <td>70</td>
                            <td>14</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Febrero</td>
                            <td>55</td>
                            <td>44</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Marzo</td>
                            <td>54</td>
                            <td>25</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Abril</td>
                            <td>55</td>
                            <td>25</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Mayo</td>
                            <td>75</td>
                            <td>25</td>
                            <td>0.00%</td>
                        </tr>
                        <tr>
                            <td>Junio</td>
                            <td>48</td>
                            <td>27</td>
                            <td>0.00%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
