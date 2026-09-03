@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-people me-2 text-primary"></i>Gestión de usuarios
    </h1>
    <a href="{{ route('usuarios.crear') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i>Nuevo usuario
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Registrado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $u)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-500"
                                    style="width:34px;height:34px;background:var(--bs-primary-bg-subtle);
                                            color:var(--bs-primary-text-emphasis);font-size:13px;flex-shrink:0">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <span class="fw-medium">{{ $u->name }}</span>
                                @if($u->id === auth()->id())
                                <span class="badge bg-light text-muted border" style="font-size:10px">Tú</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-muted small">{{ $u->email }}</td>
                        <td>
                            @php
                            $colores = [
                            'administrador' => 'text-bg-primary',
                            'supervisor' => 'text-bg-info',
                            'operador' => 'text-bg-success',
                            ];
                            @endphp
                            <span class="badge {{ $colores[$u->rol] ?? 'text-bg-secondary' }}">
                                {{ ucfirst($u->rol) }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('usuarios.editar', $u->id) }}"
                                    class="btn btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($u->id !== auth()->id())
                                <form method="POST" action="{{ route('usuarios.destroy', $u->id) }}"
                                    data-confirm-delete="¿Deseas eliminar al usuario {{ $u->name }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-people fs-4 d-block mb-2"></i>
                            No hay usuarios registrados aún.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($usuarios->hasPages())
    <div class="card-footer bg-white">{{ $usuarios->links() }}</div>
    @endif
</div>

@endsection