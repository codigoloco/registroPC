<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Entrega de Equipo</title>
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
            text-align: center;
            padding: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('img/logo.png') }}" class="logo-img" alt="Logo VIT">
            <div class="rif-text">RIF G-20009381-1</div>
        </div>
        <div class="date-container">
            FECHA: {{ $salida->created_at->format('d/m/Y') }}.
        </div>
        <div class="clear"></div>
    </div>

    <div class="title">NOTA DE ENTREGA DE EQUIPO</div>

    <div class="intro-text">
        <center>
            Por medio de la presente se hace constar que el equipo abajo mencionado ha sido entregado<br>
            por parte del personal de la empresa al usuario.
        </center>
    </div>

    <div class="section-title">EQUIPO A REPARAR</div>
    <table>
        <tr>
            <th>Modelo:</th>
            <th>Serial:</th>
            <th>Caso:</th>
            <th>Garantia:</th>
        </tr>
        <tr>
            <td>{{ optional($salida->equipo->tipo)->nombre ?? '' }} {{ optional($salida->equipo->modelo)->nombre ?? '' }}</td>
            <td>{{ optional($salida->equipo)->serial_equipo ?? '' }}</td>
            <td>{{ $salida->caso->id }}</td>
            <td style="text-transform: uppercase;">
                @if($salida->caso && $salida->caso->recepcionDeEquipo && strtolower($salida->caso->recepcionDeEquipo->tipo_atencion) === 'garantia')
                    SI
                @else
                    NO
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">DATOS DEL CLIENTE<br>{{ strtoupper($salida->caso->cliente->nombre . ' ' . $salida->caso->cliente->apellido) }}</div>
    <table>
        <tr>
            <th>Persona de Contacto</th>
            <th>Cedula</th>
            <th>Telefonos</th>
        </tr>
        <tr>
            <td>{{ strtoupper($salida->caso->cliente->nombre . ' ' . $salida->caso->cliente->apellido) }}</td>
            <td style="text-transform: uppercase;">{{ $salida->caso->cliente->tipo_cliente ?? 'V' }}-{{ $salida->caso->cliente->cedula }}</td>
            <td>{{ $salida->caso->cliente->telefono_1 }}{{ $salida->caso->cliente->telefono_2 ? ' / ' . $salida->caso->cliente->telefono_2 : '' }} /</td>
        </tr>
    </table>

    <div class="observacion">
        Observacion: 
        @if($salida->caso && $salida->caso->documentacion && $salida->caso->documentacion->count() > 0)
            @foreach($salida->caso->documentacion as $doc)
                {{ $doc->observacion }} / 
            @endforeach
        @endif
    </div>

    <div class="importante">
        IMPORTANTE:<br>
        1. La recepcion del equipo en el Centro de Soporte Tecnico genera un cobro por una hora de servicio correspondiente al diagnostico del equipo.<br>
        2. Solo el titular del equipo esta autorizado para la entrega del equipo, para el retiro del equipo si el titular no puede asistir debe notificar al<br>
        0800 infovit de la persona autorizada a retirar el equipo con la nota de recepcion.<br>
        3. Los equipos sin garantía serán reparados luego de conformado el pago por la pieza presupuestada.<br>
        4. Después de 90 dias, Venezolana de Industria Tecnologica , c.a (VIT) tendra derecho a disponer del equipo y de sus partes como<br>
        retribucion convencional de los gastos de reparacion o revision por presupuesto, cuidado, deposito y prejuicios que ha generado el<br>
        incumplimiento en el retiro del equipo o pieza reparada o devuelta, sin que el mismo tenga derecho a indemnización alguna.<br>
        5. El límite de garantía será de tres (3) meses a partir de la fecha de reparacion del equipo, sin embargo Venezolana de Industria<br>
        Tecnológica , c.a (VIT) , se reserva el derecho de reducirla en equipos expuestos a uso muy intenso.<br>
    </div>

    <div class="footer-note">Para Información Adicional o reportar algun inconveniente.</div>

    <div class="signatures-header">Firman conformes:</div>
    <div class="signatures">
        <div class="sig-col">
            ENTREGA
            <div class="sig-line"></div>
            {{ optional($salida->usuarioEntrega)->name ?? '' }} {{ optional($salida->usuarioEntrega)->lastname ?? '' }}
        </div>
        <div class="sig-col">
            RECIBE
            <div class="sig-line"></div>
            {{ strtoupper($salida->caso->cliente->nombre . ' ' . $salida->caso->cliente->apellido) }}
        </div>
    </div>

    <div class="footer-box">
        Gracias por Preferirnos.
    </div>
    
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
