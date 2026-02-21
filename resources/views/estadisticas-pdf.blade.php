<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Gráficas y Estadísticas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        .chart { width: 100%; height: 300px; margin-bottom: 2em; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Reporte de Gráficas y Estadísticas</h1>
    <p style="text-align:center;">{{ $fechaInicio ? "Desde $fechaInicio" : '' }} {{ $fechaFin ? "hasta $fechaFin" : '' }}</p>

    <div class="chart">
        <canvas id="chart"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($data['labels']) !!},
                    datasets: [{
                        label: 'Total',
                        data: {!! json_encode($data['data']) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(30, 64, 175, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            // automatic print when loaded
            window.print();
        });
    </script>
</body>
</html>