@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-1"><i class="bi bi-cart-check me-2 text-primary"></i>Ventas</h1>
        <p class="text-muted small mb-0">Registro de maíz comercializado por lote.</p>
    </div>
    <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus me-1"></i>Nueva venta
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Kilos vendidos</div>
                <div class="fs-4 fw-semibold">{{ number_format($kilosVendidos, 2, ',', '.') }} kg</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Ingresos registrados</div>
                <div class="fs-4 fw-semibold">{{ number_format($totalVendido, 2, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Lote</th>
                        <th>Comprador</th>
                        <th>Cantidad</th>
                        <th>Precio/kg</th>
                        <th>Total</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                    <tr>
                        <td class="text-muted small">{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                        <td>
                            <div class="fw-medium">{{ $venta->lote->sesion_id ?: 'Lote #' . $venta->lote_id }}</div>
                            <div class="text-muted small">{{ $venta->lote->tipoMaiz->nombre }}</div>
                        </td>
                        <td>{{ $venta->comprador }}</td>
                        <td>{{ number_format($venta->cantidad_kg, 2, ',', '.') }} kg</td>
                        <td>{{ number_format($venta->precio_kg, 2, ',', '.') }}</td>
                        <td class="fw-semibold">{{ number_format($venta->total, 2, ',', '.') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('ventas.destroy', $venta->id) }}" data-confirm-delete="¿Deseas eliminar esta venta?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Eliminar"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No hay ventas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($ventas->hasPages())
    <div class="card-footer bg-white">{{ $ventas->links() }}</div>
    @endif
</div>
@endsection
