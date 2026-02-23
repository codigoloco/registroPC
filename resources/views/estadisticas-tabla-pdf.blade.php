<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Estadístico - Tabla de Datos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; margin: 30px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2563eb; padding-bottom: 15px; }
        .header h1 { margin: 0; color: #1e3a8a; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px 8px; text-align: left; }
        th { background-color: #f3f4f6; color: #1f2937; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        tr:nth-child(even) { background-color: #fafafa; }
        
        .summary-box { margin-top: 30px; padding: 15px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 4px; }
        .summary-box p { margin: 5px 0; font-size: 12px; }
        .total-row { font-weight: bold; background-color: #eff6ff !important; }
        
        .footer { position: fixed; bottom: 20px; width: 100%; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
        
        @php
            $titles = [
                'recibidos_atencion' => 'Equipos Recibidos por Tipo de Atención',
                'recibidos_tipo_equipo' => 'Equipos Recibidos por Categoría',
                'entregados_atencion' => 'Equipos Entregados por Tipo de Atención',
                'entregados_tipo_equipo' => 'Equipos Entregados por Categoría',
                'piezas_soporte' => 'Uso de Piezas y Repuestos en Soporte'
            ];
            $nombreReporte = $titles[$tipoReporte] ?? $tipoReporte;
        @endphp
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte Estadístico de Recepción</h1>
        <p>{{ $nombreReporte }}</p>
        <div style="margin-top: 10px; font-size: 10px;">
            Filtro: {{ $fechaInicio ? "Desde $fechaInicio" : 'Inicio de los tiempos' }} 
            hasta {{ $fechaFin ? $fechaFin : date('d/m/Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Categoría / Descripción</th>
                <th style="text-align: right;">Cantidad / Total</th>
                <th style="text-align: right;">Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @php $totalGeneral = collect($data['data'])->sum(); @endphp
            @foreach($data['labels'] as $index => $label)
                @php 
                    $valor = $data['data'][$index];
                    $porcentaje = $totalGeneral > 0 ? round(($valor / $totalGeneral) * 100, 2) : 0;
                @endphp
                <tr>
                    <td>{{ $label }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($valor, 0) }}</td>
                    <td style="text-align: right;">{{ $porcentaje }}%</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td>TOTAL GENERAL</td>
                <td style="text-align: right;">{{ number_format($totalGeneral, 0) }}</td>
                <td style="text-align: right;">100%</td>
            </tr>
        </tfoot>
    </table>

    <div class="summary-box">
        <p><strong>Nota Informativa:</strong> Este documento contiene los datos consolidados extraídos directamente de la base de datos del sistema.</p>
        <p>Generado el: {{ date('d/m/Y H:i A') }}</p>
    </div>

    <div class="footer">
        Registro PC - Sistema de Control y Seguimiento Técnicos
    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
