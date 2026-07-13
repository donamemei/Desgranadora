@extends('layouts.app')
@section('content')

<h1 class="page-title">
    <i class="bi bi-clock-history me-2 text-primary"></i>Historial de sesiones
</h1>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sesión</th>
                        <th>Fecha</th>
                        <th>Duración</th>
                        <th class="text-end">Kg total</th>
                        <th class="text-end">RPM prom.</th>
                        <th class="text-end">kg/h prom.</th>
                        <th class="text-center">Reporte</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiones as $s)
                    @php
                        $inicio = \Carbon\Carbon::parse($s->inicio);
                        $fin    = \Carbon\Carbon::parse($s->fin);
                        $durMin = $inicio->diffInMinutes($fin);
                    @endphp
                    <tr>
                        <td>
                            <span class="fw-medium small">{{ $s->sesion_id }}</span>
                        </td>
                        <td class="text-muted small">{{ $inicio->format('d/m/Y') }}</td>
                        <td>
                            @if($durMin < 60)
                                <span class="badge bg-light text-dark border">{{ $durMin }} min</span>
                            @else
                                <span class="badge bg-light text-dark border">{{ floor($durMin/60) }}h {{ $durMin%60 }}min</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold">{{ $s->kg_total }} kg</td>
                        <td class="text-end">{{ $s->rpm_promedio }}</td>
                        <td class="text-end">{{ $s->kg_hora_promedio }} kg/h</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('reportes.pdf', $s->sesion_id) }}"
                                   class="btn btn-outline-danger" title="PDF" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                                <a href="{{ route('reportes.excel', $s->sesion_id) }}"
                                   class="btn btn-outline-success" title="Excel">
                                    <i class="bi bi-file-earmark-excel"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-clock-history d-block fs-3 mb-2"></i>
                            No hay sesiones registradas aún.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($sesiones->hasPages())
        <div class="card-footer bg-white">{{ $sesiones->links() }}</div>
    @endif
</div>

@endsection
