@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Reportes de sesiones
    </h1>
</div>

@if($sesiones->isEmpty())
    <div class="alert alert-info d-flex align-items-center gap-2">
        <i class="bi bi-info-circle fs-5"></i>
        <span>No hay sesiones registradas aún. El sistema guardará sesiones automáticamente cuando el Arduino comience a enviar datos.</span>
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sesión</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th class="text-end">Kg total</th>
                            <th class="text-end">RPM prom.</th>
                            <th class="text-end">kg/hora prom.</th>
                            <th class="text-end">Lecturas</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sesiones as $s)
                        <tr>
                            <td>
                                <a href="{{ route('reportes.detalle', $s->sesion_id) }}"
                                   class="fw-semibold text-decoration-none">
                                    {{ $s->sesion_id }}
                                </a>
                            </td>
                            <td class="text-muted small">
                                {{ \Carbon\Carbon::parse($s->inicio)->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-muted small">
                                {{ \Carbon\Carbon::parse($s->fin)->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-end fw-semibold">{{ $s->kg_total }} kg</td>
                            <td class="text-end">{{ $s->rpm_promedio }}</td>
                            <td class="text-end">{{ $s->kg_hora_promedio }}</td>
                            <td class="text-end">
                                <span class="badge bg-secondary rounded-pill">{{ $s->total_lecturas }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('reportes.detalle', $s->sesion_id) }}"
                                       class="btn btn-outline-primary" title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('reportes.pdf', $s->sesion_id) }}"
                                       class="btn btn-outline-danger" title="Descargar PDF" target="_blank">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                    <a href="{{ route('reportes.excel', $s->sesion_id) }}"
                                       class="btn btn-outline-success" title="Descargar Excel">
                                        <i class="bi bi-file-earmark-excel"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($sesiones->hasPages())
            <div class="card-footer bg-white">
                {{ $sesiones->links() }}
            </div>
        @endif
    </div>
@endif

@endsection