<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Salidas de Equipo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 1em; }
        th, td { border: 1px solid #666; padding: 4px; }
        th { background: #eee; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Registro de Salidas de Equipo</h1>
    <p>Generado el {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID Caso</th>
                <th>Cliente</th>
                <th>Equipo</th>
                <th>Depósito</th>
                <th>Técnico Entrega</th>
                <th>Fecha Salida</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidas as $s)
                <tr>
                    <td>{{ $s->id_caso }}</td>
                    <td>{{ $s->caso->cliente->nombre ?? 'N/A' }} {{ $s->caso->cliente->apellido ?? '' }}</td>
                    <td>{{ optional($s->equipo->tipo)->nombre }} / {{ optional($s->equipo->modelo)->nombre }}</td>
                    <td>{{ ucfirst($s->deposito) }}</td>
                    <td>{{ optional($s->usuarioEntrega)->name ?? 'N/A' }}</td>
                    <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // abrir diálogo de impresión automáticamente
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>