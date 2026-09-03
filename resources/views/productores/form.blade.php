@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('productores.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
    <h1 class="page-title mb-0"><i class="bi bi-person-badge me-2 text-primary"></i>{{ isset($productor) ? 'Editar productor' : 'Nuevo productor' }}</h1>
</div>

<div class="card border-0 shadow-sm modern-card">
    <div class="card-body">
        <form method="POST" action="{{ isset($productor) ? route('productores.update', $productor->id) : route('productores.store') }}">
            @csrf
            @if(isset($productor))
            @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $productor->nombre ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $productor->apellido ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cédula</label>
                    <input type="text" name="cedula" class="form-control" value="{{ old('cedula', $productor->cedula ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $productor->telefono ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Municipio</label>
                    <input type="text" name="municipio" class="form-control" value="{{ old('municipio', $productor->municipio ?? 'Ucureña') }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Dirección</label>
                    <textarea name="direccion" class="form-control" rows="3">{{ old('direccion', $productor->direccion ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('productores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection