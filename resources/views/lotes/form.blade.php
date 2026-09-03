@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('lotes.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
    <h1 class="page-title mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>{{ isset($lote) ? 'Editar lote' : 'Nuevo lote' }}</h1>
</div>

<div class="card border-0 shadow-sm modern-card">
    <div class="card-body">
        <form method="POST" action="{{ isset($lote) ? route('lotes.update', $lote->id) : route('lotes.store') }}">
            @csrf
            @if(isset($lote))
            @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Productor</label>
                    <select name="productor_id" class="form-select" required>
                        <option value="">Seleccione un productor</option>
                        @foreach($productores as $productor)
                        <option value="{{ $productor->id }}" {{ old('productor_id', $lote->productor_id ?? '') == $productor->id ? 'selected' : '' }}>
                            {{ $productor->nombre }} {{ $productor->apellido }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de maíz</label>
                    <select name="tipo_maiz_id" class="form-select" required>
                        <option value="">Seleccione un tipo</option>
                        @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_maiz_id', $lote->tipo_maiz_id ?? '') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sesión</label>
                    <input type="text" name="sesion_id" class="form-control" value="{{ old('sesion_id', $lote->sesion_id ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha recepción</label>
                    <input type="date" name="fecha_recepcion" class="form-control" value="{{ old('fecha_recepcion', $lote->fecha_recepcion ?? date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cantidad (kg)</label>
                    <input type="number" step="0.01" min="0" name="cantidad_kg" class="form-control" value="{{ old('cantidad_kg', $lote->cantidad_kg ?? 0) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="pendiente" {{ old('estado', $lote->estado ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="procesado" {{ old('estado', $lote->estado ?? '') == 'procesado' ? 'selected' : '' }}>Procesado</option>
                        <option value="alerta" {{ old('estado', $lote->estado ?? '') == 'alerta' ? 'selected' : '' }}>Alerta</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $lote->observaciones ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('lotes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection