@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="bi bi-bell me-2 text-primary"></i>Alertas</h1>
    <a href="{{ route('alertas.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus me-1"></i>Nueva alerta
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Lote</th>
                        <th>Tipo</th>
                        <th>Nivel</th>
                        <th>Mensaje</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alertas as $alerta)
                    <tr>
                        <td>{{ $alerta->lote->sesion_id ?? 'Lote #' . $alerta->lote_id }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $alerta->tipo_alerta)) }}</td>
                        <td>
                            <span class="badge {{ $alerta->nivel == 'alta' ? 'bg-danger' : ($alerta->nivel == 'media' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                {{ ucfirst($alerta->nivel) }}
                            </span>
                        </td>
                        <td>{{ $alerta->mensaje }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('alertas.edit', $alerta->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('alertas.destroy', $alerta->id) }}" data-confirm-delete="¿Deseas eliminar esta alerta?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No hay alertas registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection