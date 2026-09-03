@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('tipos-maiz.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
    <h1 class="page-title mb-0"><i class="bi bi-basket me-2 text-primary"></i>{{ isset($tipo) ? 'Editar tipo de maíz' : 'Nuevo tipo de maíz' }}</h1>
</div>

<div class="card border-0 shadow-sm modern-card">
    <div class="card-body">
        <form method="POST" action="{{ isset($tipo) ? route('tipos-maiz.update', $tipo->id) : route('tipos-maiz.store') }}">
            @csrf
            @if(isset($tipo))
            @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tipo->nombre ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Categoría</label>
                    <select name="categoria" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="duro" {{ old('categoria', $tipo->categoria ?? '') == 'duro' ? 'selected' : '' }}>Duro</option>
                        <option value="blando" {{ old('categoria', $tipo->categoria ?? '') == 'blando' ? 'selected' : '' }}>Blando</option>
                        <option value="general" {{ old('categoria', $tipo->categoria ?? '') == 'general' ? 'selected' : '' }}>General</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4">{{ old('descripcion', $tipo->descripcion ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('tipos-maiz.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection