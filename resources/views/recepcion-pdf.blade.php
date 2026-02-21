<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Recepciones de Equipo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 1em; }
        th, td { border: 1px solid #666; padding: 4px; }
        th { background: #eee; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Registro de Recepciones de Equipo</h1>
    <p>Generado el {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID Caso</th>
                <th>Cliente</th>
                <th>Equipo</th>
                <th>Tipo Atención</th>
                <th>Falla</th>
                <th>Técnico Recep.</th>
                <th>Fecha Recepción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recepciones as $r)
                <tr>
                    <td>{{ $r->id_caso }}</td>
                    <td>{{ $r->caso->cliente->nombre ?? 'N/A' }} {{ $r->caso->cliente->apellido ?? '' }}</td>
                    <td>{{ optional($r->equipo->tipo)->nombre }} / {{ optional($r->equipo->modelo)->nombre }}</td>
                    <td>{{ ucfirst($r->tipo_atencion) }}</td>
                    <td>{{ $r->falla_tecnica }}</td>
                    <td>{{ optional($r->usuarioRecepcion)->name ?? 'N/A' }}</td>
                    <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
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