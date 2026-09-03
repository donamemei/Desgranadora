@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="bi bi-clipboard-check me-2 text-primary"></i>Clasificaciones</h1>
    <a href="{{ route('clasificaciones.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus me-1"></i>Nueva clasificación
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Lote</th>
                        <th>Productor</th>
                        <th>Categoría</th>
                        <th>Primera</th>
                        <th>Segunda</th>
                        <th>Desechos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clasificaciones as $clasificacion)
                    <tr>
                        <td>{{ $clasificacion->lote->sesion_id ?? 'Lote #' . $clasificacion->lote_id }}</td>
                        <td>{{ $clasificacion->lote->productor->nombre ?? '—' }} {{ $clasificacion->lote->productor->apellido ?? '' }}</td>
                        <td>
                            <span class="badge {{ $clasificacion->categoria == 'primera' ? 'bg-success' : ($clasificacion->categoria == 'segunda' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ ucfirst($clasificacion->categoria) }}
                            </span>
                        </td>
                        <td>{{ $clasificacion->porcentaje_primera }}%</td>
                        <td>{{ $clasificacion->porcentaje_segunda }}%</td>
                        <td>{{ $clasificacion->porcentaje_desechos }}%</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('clasificaciones.edit', $clasificacion->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('clasificaciones.destroy', $clasificacion->id) }}" data-confirm-delete="¿Deseas eliminar esta clasificación?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No hay clasificaciones registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection