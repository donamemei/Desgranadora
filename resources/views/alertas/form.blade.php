@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('alertas.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
    <h1 class="page-title mb-0"><i class="bi bi-bell me-2 text-primary"></i>{{ isset($alerta) ? 'Editar alerta' : 'Nueva alerta' }}</h1>
</div>

<div class="card border-0 shadow-sm modern-card">
    <div class="card-body">
        <form method="POST" action="{{ isset($alerta) ? route('alertas.update', $alerta->id) : route('alertas.store') }}">
            @csrf
            @if(isset($alerta))
            @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Lote</label>
                    <select name="lote_id" class="form-select" required>
                        <option value="">Seleccione un lote</option>
                        @foreach($lotes as $lote)
                        <option value="{{ $lote->id }}" {{ old('lote_id', $alerta->lote_id ?? '') == $lote->id ? 'selected' : '' }}>
                            {{ $lote->sesion_id ?? 'Lote #' . $lote->id }} - {{ $lote->productor->nombre ?? '' }} {{ $lote->productor->apellido ?? '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de alerta</label>
                    <select name="tipo_alerta" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="rpm_alto" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'rpm_alto' ? 'selected' : '' }}>RPM alto</option>
                        <option value="temperatura_alta" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'temperatura_alta' ? 'selected' : '' }}>Temperatura alta</option>
                        <option value="desechos_alto" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'desechos_alto' ? 'selected' : '' }}>Desechos alto</option>
                        <option value="produccion_baja" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'produccion_baja' ? 'selected' : '' }}>Producción baja</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nivel</label>
                    <select name="nivel" class="form-select" required>
                        <option value="baja" {{ old('nivel', $alerta->nivel ?? '') == 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ old('nivel', $alerta->nivel ?? '') == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta" {{ old('nivel', $alerta->nivel ?? '') == 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Leída</label>
                    <select name="leida" class="form-select">
                        <option value="0" {{ old('leida', $alerta->leida ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('leida', $alerta->leida ?? 0) == 1 ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Mensaje</label>
                    <textarea name="mensaje" class="form-control" rows="4" required>{{ old('mensaje', $alerta->mensaje ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('alertas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection