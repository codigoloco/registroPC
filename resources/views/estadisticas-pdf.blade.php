<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Gráficas y Estadísticas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        h1 { text-align: center; }
        .content-wrapper { 
            width: 700px;
            margin: 0 auto;
        }
        .chart { width: 100%; height: 350px; margin-bottom: 2em; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="content-wrapper">
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
                        data: {!! json_encode($data['data']) !!}.map(v => Number(v) || 0),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(30, 64, 175, 1)',
                        borderWidth: 1,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false, // Desactivar animaciones para PDF
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            // Dar un tiempo mínimo para renderizar el canvas antes de imprimir
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
    </div>
</body>
</html>