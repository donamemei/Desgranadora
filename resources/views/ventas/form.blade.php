@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('ventas.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
    <h1 class="page-title mb-0"><i class="bi bi-cart-check me-2 text-primary"></i>{{ isset($venta) ? 'Editar venta' : 'Nueva venta' }}</h1>
</div>

<div class="card border-0 shadow-sm modern-card">
    <div class="card-body">
        <form method="POST" action="{{ isset($venta) ? route('ventas.update', $venta->id) : route('ventas.store') }}">
            @csrf
            @if(isset($venta)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Lote vendido</label>
                    <select name="lote_id" class="form-select @error('lote_id') is-invalid @enderror" required>
                        <option value="">Seleccione un lote</option>
                        @foreach($lotes as $lote)
                        <option value="{{ $lote->id }}" {{ old('lote_id', $venta->lote_id ?? '') == $lote->id ? 'selected' : '' }}>
                            {{ $lote->sesion_id ?: 'Lote #' . $lote->id }} · {{ $lote->productor->nombre }} {{ $lote->productor->apellido }} · {{ $lote->tipoMaiz->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('lote_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha de venta</label>
                    <input type="date" name="fecha_venta" class="form-control @error('fecha_venta') is-invalid @enderror" value="{{ old('fecha_venta', isset($venta) ? $venta->fecha_venta->format('Y-m-d') : date('Y-m-d')) }}" required>
                    @error('fecha_venta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Comprador</label>
                    <input type="text" name="comprador" class="form-control @error('comprador') is-invalid @enderror" value="{{ old('comprador', $venta->comprador ?? '') }}" placeholder="Nombre del comprador" required>
                    @error('comprador')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cantidad (kg)</label>
                    <input type="number" name="cantidad_kg" class="form-control @error('cantidad_kg') is-invalid @enderror" value="{{ old('cantidad_kg', $venta->cantidad_kg ?? '') }}" min="0.01" step="0.01" required>
                    @error('cantidad_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Precio por kg</label>
                    <input type="number" name="precio_kg" class="form-control @error('precio_kg') is-invalid @enderror" value="{{ old('precio_kg', $venta->precio_kg ?? '') }}" min="0" step="0.01" required>
                    @error('precio_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Método de pago</label>
                    <select name="metodo_pago" class="form-select">
                        <option value="">Seleccione una opción</option>
                        @foreach(['efectivo' => 'Efectivo', 'transferencia' => 'Transferencia', 'credito' => 'Crédito'] as $value => $label)
                        <option value="{{ $value }}" {{ old('metodo_pago', $venta->metodo_pago ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Observaciones</label>
                    <input type="text" name="observaciones" class="form-control" value="{{ old('observaciones', $venta->observaciones ?? '') }}" placeholder="Notas de la venta">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Guardar venta</button>
                <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
