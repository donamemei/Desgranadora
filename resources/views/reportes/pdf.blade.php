<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Desgranado — {{ $sesionId }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #212529; }

        /* Encabezado */
        .header { background: #0d6efd; color: white; padding: 14px 20px; margin-bottom: 16px; }
        .header h1 { font-size: 16px; font-weight: bold; }
        .header p  { font-size: 9px; opacity: .85; margin-top: 3px; }

        /* Resumen */
        .resumen-grid { display: table; width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .resumen-cell { display: table-cell; width: 16.66%; border: 1px solid #dee2e6;
                        padding: 8px 10px; text-align: center; }
        .resumen-cell .label { font-size: 8px; color: #6c757d; text-transform: uppercase; letter-spacing: .04em; }
        .resumen-cell .valor { font-size: 14px; font-weight: bold; color: #0d6efd; margin-top: 2px; }

        /* Tabla de datos */
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #0d6efd; color: white; font-size: 9px;
            padding: 6px 8px; text-align: left; text-transform: uppercase; letter-spacing: .04em;
        }
        td { padding: 5px 8px; border-bottom: 0.5px solid #e9ecef; font-size: 9px; }
        tr:nth-child(even) td { background: #f8f9fa; }
        tr:last-child td { border-bottom: none; }

        .estado-on     { color: #198754; font-weight: bold; }
        .estado-off    { color: #6c757d; }
        .estado-alerta { color: #dc3545; font-weight: bold; }

        /* Pie de página */
        .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #dee2e6;
                  font-size: 8px; color: #adb5bd; display: flex; justify-content: space-between; }
    </style>
</head>
<body>

{{-- ENCABEZADO --}}
<div class="header">
    <h1>Sistema de Desgranado y Aprovechamiento de Residuos del Maíz</h1>
    <p>Reporte de sesión: {{ $sesionId }} &nbsp;|&nbsp; Generado: {{ now()->format('d/m/Y H:i') }}</p>
</div>

{{-- RESUMEN --}}
@if($resumen)
<div class="resumen-grid">
    <div class="resumen-cell">
        <div class="label">Kg total</div>
        <div class="valor">{{ $resumen['kg_total'] }}</div>
    </div>
    <div class="resumen-cell">
        <div class="label">RPM promedio</div>
        <div class="valor">{{ $resumen['rpm_promedio'] }}</div>
    </div>
    <div class="resumen-cell">
        <div class="label">RPM máximo</div>
        <div class="valor">{{ $resumen['rpm_max'] }}</div>
    </div>
    <div class="resumen-cell">
        <div class="label">Productividad</div>
        <div class="valor">{{ $resumen['kg_hora_promedio'] }} kg/h</div>
    </div>
    <div class="resumen-cell">
        <div class="label">Duración</div>
        <div class="valor">{{ $resumen['duracion_min'] }} min</div>
    </div>
    <div class="resumen-cell">
        <div class="label">Temp. máx.</div>
        <div class="valor">{{ $resumen['temp_max'] }}°C</div>
    </div>
</div>
@endif

{{-- TABLA DE LECTURAS --}}
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha y hora</th>
            <th>RPM</th>
            <th>Kg procesados</th>
            <th>Kg / hora</th>
            <th>Temperatura</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lecturas as $i => $l)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $l->created_at->format('d/m/Y H:i:s') }}</td>
            <td>{{ number_format($l->rpm, 1) }}</td>
            <td>{{ number_format($l->kg_procesados, 2) }} kg</td>
            <td>{{ number_format($l->kg_hora, 1) }} kg/h</td>
            <td>{{ $l->temperatura ?? 0 }}°C</td>
            <td class="estado-{{ strtolower($l->estado_motor) }}">
                {{ $l->estado_motor }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- PIE --}}
<div class="footer">
    <span>Instituto Técnico — Proyecto Desgranadora de Maíz 2024</span>
    <span>Sesión {{ $sesionId }} &nbsp;|&nbsp; {{ $lecturas->count() }} lecturas registradas</span>
</div>

</body>
</html>
