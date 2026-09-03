@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Lotes</h1>
    <a href="{{ route('lotes.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus me-1"></i>Nuevo lote
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Productor</th>
                        <th>Tipo de maíz</th>
                        <th>Sesión</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lotes as $lote)
                    <tr>
                        <td>{{ $lote->productor->nombre ?? '—' }} {{ $lote->productor->apellido ?? '' }}</td>
                        <td>{{ $lote->tipoMaiz->nombre ?? '—' }}</td>
                        <td>{{ $lote->sesion_id ?? '—' }}</td>
                        <td>{{ number_format($lote->cantidad_kg, 2) }} kg</td>
                        <td>
                            <span class="badge {{ $lote->estado === 'procesado' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($lote->estado ?? 'pendiente') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('lotes.edit', $lote->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('lotes.destroy', $lote->id) }}" data-confirm-delete="¿Deseas eliminar este lote?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No hay lotes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection