@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="bi bi-people me-2 text-primary"></i>Productores</h1>
    <a href="{{ route('productores.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i>Nuevo productor
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Municipio</th>
                        <th>Teléfono</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productores as $productor)
                    <tr>
                        <td>{{ $productor->nombre }} {{ $productor->apellido }}</td>
                        <td>{{ $productor->cedula }}</td>
                        <td>{{ $productor->municipio }}</td>
                        <td>{{ $productor->telefono ?? '—' }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('productores.edit', $productor->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('productores.destroy', $productor->id) }}" data-confirm-delete="¿Deseas eliminar este productor?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No hay productores registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection