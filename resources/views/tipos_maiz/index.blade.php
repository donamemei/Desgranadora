@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="bi bi-basket me-2 text-primary"></i>Tipos de maíz</h1>
    <a href="{{ route('tipos-maiz.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus me-1"></i>Nuevo tipo
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tipos as $tipo)
                    <tr>
                        <td>{{ $tipo->nombre }}</td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ ucfirst($tipo->categoria) }}</span></td>
                        <td>{{ Str::limit($tipo->descripcion ?? 'Sin descripción', 80) }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('tipos-maiz.edit', $tipo->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('tipos-maiz.destroy', $tipo->id) }}" data-confirm-delete="¿Deseas eliminar este tipo de maíz?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No hay tipos de maíz registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection