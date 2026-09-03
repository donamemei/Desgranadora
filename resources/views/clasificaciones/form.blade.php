@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('clasificaciones.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
    <h1 class="page-title mb-0"><i class="bi bi-clipboard-check me-2 text-primary"></i>{{ isset($clasificacion) ? 'Editar clasificación' : 'Nueva clasificación' }}</h1>
</div>

<div class="card border-0 shadow-sm modern-card">
    <div class="card-body">
        <form method="POST" action="{{ isset($clasificacion) ? route('clasificaciones.update', $clasificacion->id) : route('clasificaciones.store') }}">
            @csrf
            @if(isset($clasificacion))
            @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Lote</label>
                    <select name="lote_id" class="form-select" required>
                        <option value="">Seleccione un lote</option>
                        @foreach($lotes as $lote)
                        <option value="{{ $lote->id }}" {{ old('lote_id', $clasificacion->lote_id ?? '') == $lote->id ? 'selected' : '' }}>
                            {{ $lote->sesion_id ?? 'Lote #' . $lote->id }} - {{ $lote->productor->nombre ?? '' }} {{ $lote->productor->apellido ?? '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Categoría final</label>
                    <select name="categoria" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="primera" {{ old('categoria', $clasificacion->categoria ?? '') == 'primera' ? 'selected' : '' }}>Primera</option>
                        <option value="segunda" {{ old('categoria', $clasificacion->categoria ?? '') == 'segunda' ? 'selected' : '' }}>Segunda</option>
                        <option value="desechos" {{ old('categoria', $clasificacion->categoria ?? '') == 'desechos' ? 'selected' : '' }}>Desechos</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Primera (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="porcentaje_primera" class="form-control" value="{{ old('porcentaje_primera', $clasificacion->porcentaje_primera ?? 0) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Segunda (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="porcentaje_segunda" class="form-control" value="{{ old('porcentaje_segunda', $clasificacion->porcentaje_segunda ?? 0) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Desechos (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="porcentaje_desechos" class="form-control" value="{{ old('porcentaje_desechos', $clasificacion->porcentaje_desechos ?? 0) }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="4">{{ old('observaciones', $clasificacion->observaciones ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('clasificaciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection