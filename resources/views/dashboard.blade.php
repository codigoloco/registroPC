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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let myChart = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize flatpickr or custom date logic if needed
        });

        async function generarReporte(tipoVisualizacion) {
            const tipoReporte = document.getElementById('tipoReporte').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;

            // UI Elements
            const chartContainer = document.getElementById('chartContainer');
            const tableContainer = document.getElementById('tableContainer');
            const initialState = document.getElementById('initialState');
            const chartTitle = document.getElementById('chartTitle');
            const tableTitle = document.getElementById('tableTitle');
            const tableBody = document.getElementById('tableBody');

            // Reset UI
            initialState.classList.add('hidden');
            chartContainer.classList.add('hidden');
            tableContainer.classList.add('hidden');

            try {
                // Fetch Data
                const response = await fetch(`/api/reportes/data?tipoReporte=${tipoReporte}&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`);
                const data = await response.json();

                if (tipoVisualizacion === 'grafica') {
                    mostrarGrafica(data, tipoReporte, chartContainer, chartTitle);
                } else {
                    mostrarTabla(data, tipoReporte, tableContainer, tableTitle, tableBody);
                }

            } catch (error) {
                console.error('Error fetching data:', error);
                alert('Hubo un error al generar el reporte.');
            }
        }

        function mostrarGrafica(data, tipo, container, title) {
            container.classList.remove('hidden');
            title.textContent = `Gráfica: ${formatTitle(tipo)}`;

            const ctx = document.getElementById('reportChart').getContext('2d');
            
            if (myChart) {
                myChart.destroy();
            }

            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Total',
                        data: data.data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        function mostrarTabla(data, tipo, container, title, body) {
            container.classList.remove('hidden');
            title.textContent = `Tabla: ${formatTitle(tipo)}`;
            body.innerHTML = '';

            data.labels.forEach((label, index) => {
                const row = `
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            ${label}
                        </td>
                        <td class="px-6 py-4">
                            ${data.data[index]}
                        </td>
                    </tr>
                `;
                body.innerHTML += row;
            });
        }

        function formatTitle(slug) {
            const titles = {
                'recibidos_atencion': 'Recibidos por Tipo de Atención',
                'recibidos_tipo_equipo': 'Recibidos por Tipo de Equipo',
                'entregados_atencion': 'Entregados por Tipo de Atención',
                'entregados_tipo_equipo': 'Entregados por Tipo de Equipo',
                'piezas_soporte': 'Piezas utilizadas en Soporte'
            };
            return titles[slug] || slug;
        }
    </script>
</x-app-layout>
