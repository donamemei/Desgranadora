@extends('layouts.app')
@section('content')

<h1 class="page-title">
    <i class="bi bi-pie-chart me-2 text-primary"></i>Estadísticas generales
</h1>

{{-- Tarjetas resumen --}}
<div class="row g-3 mb-4">
    @foreach([
        ['Kg total histórico',    $stats['kg_total_historico'].' kg',  'bi-box-seam',        '#d1e7dd','#0a3622'],
        ['Sesiones registradas',  $stats['total_sesiones'],            'bi-collection',       '#cfe2ff','#052c65'],
        ['RPM promedio global',   $stats['rpm_promedio_global'],       'bi-arrow-repeat',     '#fff3cd','#664d03'],
        ['Productividad prom.',   $stats['kg_hora_promedio'].' kg/h',  'bi-graph-up-arrow',   '#d1e7dd','#0a3622'],
        ['Temp. máx. registrada', $stats['temp_max_registrada'].'°C',  'bi-thermometer-half', '#f8d7da','#58151c'],
        ['Total de lecturas',     number_format($stats['total_lecturas']), 'bi-database',     '#e2e3e5','#41464b'],
    ] as [$label, $valor, $icon, $bg, $color])
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center h-100" style="background:{{ $bg }}20">
            <div class="card-body py-3">
                <i class="bi {{ $icon }} fs-4" style="color:{{ $color }}"></i>
                <div class="fw-bold mt-1 fs-5">{{ $valor }}</div>
                <small class="text-muted" style="font-size:11px">{{ $label }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Tabla de últimos 6 meses --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3 pb-0">
        <h6 class="fw-semibold mb-0">
            <i class="bi bi-calendar3 me-2 text-primary"></i>Producción por mes (últimos 6 meses)
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mes</th>
                        <th class="text-end">Kg máx. sesión</th>
                        <th class="text-end">Sesiones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['por_mes'] as $m)
                    <tr>
                        <td class="fw-medium">{{ \Carbon\Carbon::createFromFormat('Y-m', $m->mes)->translatedFormat('F Y') }}</td>
                        <td class="text-end">{{ $m->kg }} kg</td>
                        <td class="text-end">
                            <span class="badge bg-primary rounded-pill">{{ $m->sesiones }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="bi bi-bar-chart d-block fs-4 mb-2"></i>
                            Sin datos registrados aún.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
