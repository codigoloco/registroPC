/**
 * Lógica del Dashboard para Reportes y Gráficas
 */

let myChart = null;

export function initDashboard() {
    // Inicialización si es necesaria
}

/**
 * Genera el reporte basado en los filtros y el tipo de visualización
 */
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

    if(!initialState) return; // Guard clause

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

    // Chart.js should be available globally if loaded via cdn or via import
    // If using Vite and import Chart from 'chart.js/auto', we might need to handle it differently
    // For now, keeping the global Chart expectation if it's in the template
    if (typeof Chart !== 'undefined') {
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Total',
                    data: data.data,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)', // Blue 500 with opacity
                    borderColor: 'rgba(30, 64, 175, 1)',   // Blue 800
                    borderWidth: 2,
                    borderRadius: 4
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

// Global exposure
window.generarReporte = generarReporte;
