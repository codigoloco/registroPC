<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Recepción de Equipo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }
        .header {
            width: 100%;
            margin-bottom: 20px;
        }
        .logo-container {
            float: left;
            width: 40%;
            text-align: left;
        }
        .logo-img {
            max-width: 180px;
            height: auto;
        }
        .rif-text {
            font-size: 8px;
            font-weight: bold;
            margin-top: 5px;
            text-align: left;
        }
        .date-container {
            float: right;
            width: 40%;
            text-align: right;
            font-weight: bold;
            font-size: 12px;
            padding-top: 30px;
        }
        .clear {
            clear: both;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 30px 0 20px 0;
        }
        .intro-text {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px 2px;
            text-align: center;
            font-size: 10px;
        }
        th {
            background-color: #d9d9d9;
            font-weight: bold;
        }
        td {
            font-weight: bold;
        }
        .observacion {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 20px;
        }
        .importante {
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .signatures-header {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 15px;
        }
        .signatures {
            width: 100%;
            margin-top: 10px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }
        .sig-col {
            display: inline-block;
            width: 45%;
        }
        .sig-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 50px auto 5px auto;
        }
        .footer-note {
            font-size: 6px;
            margin-top: 15px;
            margin-bottom: 2px;
        }
        .footer-box {
            background-color: #d9d9d9;
            border: 1px solid #000;
            text-align: center;
            padding: 15px;
            font-weight: bold;
        }
        .footer-box div:nth-child(1) { font-size: 18px; margin-bottom: 3px; }
        .footer-box div:nth-child(2) { font-size: 18px; }
        .footer-box div:nth-child(3) { font-size: 16px; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('img/logo.png') }}" class="logo-img" alt="Logo VIT">
            
            <div class="rif-text">RIF G-20009381-1</div>
        </div>
        <div class="date-container">
            FECHA: {{ $recepcion->created_at->format('d/m/Y') }}.
        </div>
        <div class="clear"></div>
    </div>

    <div class="title">NOTA DE RECEPCION DE EQUIPO</div>

    <div class="intro-text">
        Por medio de la presente se hace constar que el equipo abajo mencionado ha sido entregado<br>
        por parte del usuario al personal de la empresa.
    </div>

    <div class="section-title">EQUIPO A REPARAR</div>
    <table>
        <tr>
            <th>Modelo:</th>
            <th>Serial:</th>
            <th>Caso:</th>
            <th>Garantia:</th>
            <th>Tecnico:</th>
        </tr>
        <tr>
            <td>{{ optional($recepcion->equipo->tipo)->nombre ?? '' }} {{ optional($recepcion->equipo->modelo)->nombre ?? '' }}</td>
            <td>{{ optional($recepcion->equipo)->serial_equipo ?? '' }}</td>
            <td>#{{ $recepcion->caso->id }}</td>
            <td style="text-transform: uppercase;">{{ strtolower($recepcion->tipo_atencion) === 'garantia' ? 'SI' : 'NO' }}</td>
            <td>{{ optional($recepcion->tecnicoAsignado)->name ?? '' }} {{ optional($recepcion->tecnicoAsignado)->lastname ?? '' }}</td>
        </tr>
    </table>

    <div class="section-title">DATOS DEL CLIENTE<br>{{ strtoupper($recepcion->caso->cliente->nombre . ' ' . $recepcion->caso->cliente->apellido) }}</div>
    <table>
        <tr>
            <th>Persona de Contacto</th>
            <th>Cedula</th>
            <th>Telefonos</th>
        </tr>
        <tr>
            <td>{{ strtoupper($recepcion->caso->cliente->nombre . ' ' . $recepcion->caso->cliente->apellido) }}</td>
            <td style="text-transform: uppercase;">{{ $recepcion->caso->cliente->tipo_cliente ?? 'V' }}-{{ $recepcion->caso->cliente->cedula }}</td>
            <td>
                @if($recepcion->caso->cliente->contactos->count() > 0)
                    {{ $recepcion->caso->cliente->contactos->pluck('telefono_cliente')->implode(' / ') }}
                @else
                    N/A
                @endif
            </td>
        </tr>
    </table>

    <div class="observacion">
        Observacion: {{ $recepcion->falla_tecnica }}
    </div>

    <div class="importante">
        IMPORTANTE:<br>
        Solo el titular del equipo esta autorizado para la entrega y retiro del mismo.<br>
        Debe entregar la presente nota de entrega, factura del equipo y cédula de identidad.<br>
        Los equipos sin garantía serán reparados luego de confirmado el pago por la pieza presupuestada.<br>
        NO SE ENTREGARAN EQUIPOS A TERCEROS.<br>
    </div>

    <div class="signatures-header">Firman conformes:</div>
    <div class="signatures">
        <div class="sig-col">
            ENTREGA
            <div class="sig-line"></div>
            {{ strtoupper($recepcion->caso->cliente->nombre . ' ' . $recepcion->caso->cliente->apellido) }}
        </div>
        <div class="sig-col">
            RECIBE
            <div class="sig-line"></div>
            {{ optional($recepcion->usuarioRecepcion)->name ?? '' }} {{ optional($recepcion->usuarioRecepcion)->lastname ?? '' }}
        </div>
    </div>

    <div class="footer-note">Para Información Adicional o reportar algun inconveniente.</div>
    <div class="footer-box">
        <div>0800-INFOVIT</div>
        <div>0800-4636848</div>
        <div>Gracias por Preferirnos.</div>
    </div>
    
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
