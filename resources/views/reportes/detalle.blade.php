
@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('reportes.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="page-title mb-0">
        <i class="bi bi-clipboard-data me-2 text-primary"></i>Sesión: {{ $sesionId }}
    </h1>
    <div class="ms-auto d-flex gap-2">
        <a href="{{ route('reportes.pdf', $sesionId) }}" class="btn btn-danger btn-sm" target="_blank">
            <i class="bi bi-file-earmark-pdf me-1"></i>PDF
        </a>
        <a href="{{ route('reportes.excel', $sesionId) }}" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i>Excel
        </a>
    </div>
</div>

{{-- Tarjetas de resumen --}}
@if($resumen)
<div class="row g-3 mb-4">
    @foreach([
        ['Kg total',        $resumen['kg_total'].' kg',         'bi-box-seam',         'text-success', '#d1e7dd'],
        ['RPM promedio',    $resumen['rpm_promedio'],            'bi-arrow-repeat',     'text-primary', '#cfe2ff'],
        ['Productividad',   $resumen['kg_hora_promedio'].' kg/h','bi-graph-up-arrow',   'text-warning', '#fff3cd'],
        ['Duración',        $resumen['duracion_min'].' min',     'bi-clock',            'text-info',    '#cff4fc'],
        ['Temp. máx.',      $resumen['temp_max'].'°C',           'bi-thermometer-half', 'text-danger',  '#f8d7da'],
        ['Lecturas',        $resumen['total_lecturas'],          'bi-database',         'text-secondary','#e2e3e5'],
    ] as [$label, $valor, $icon, $color, $bg])
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center h-100" style="background:{{ $bg }}15">
            <div class="card-body py-3">
                <i class="bi {{ $icon }} fs-4 {{ $color }}"></i>
                <div class="fw-bold mt-1">{{ $valor }}</div>
                <small class="text-muted">{{ $label }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Tabla de lecturas --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-semibold">Lecturas de la sesión</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height:420px; overflow-y:auto;">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th>#</th>
                        <th>Hora</th>
                        <th>RPM</th>
                        <th>Kg procesados</th>
                        <th>Kg/hora</th>
                        <th>Temperatura</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lecturas as $i => $l)
                    <tr>
                        <td class="text-muted">{{ $i + 1 }}</td>
                        <td class="small">{{ $l->created_at->format('H:i:s') }}</td>
                        <td>{{ number_format($l->rpm, 1) }}</td>
                        <td>{{ number_format($l->kg_procesados, 2) }} kg</td>
                        <td>{{ number_format($l->kg_hora, 1) }}</td>
                        <td>{{ $l->temperatura ?? 0 }}°C</td>
                        <td>
                            @if($l->estado_motor === 'ON')
                                <span class="badge bg-success">ON</span>
                            @elseif($l->estado_motor === 'ALERTA')
                                <span class="badge bg-danger">ALERTA</span>
                            @else
                                <span class="badge bg-secondary">OFF</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
