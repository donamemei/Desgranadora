@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="page-title mb-0">
        <i class="bi bi-person-{{ $usuario ? 'gear' : 'plus' }} me-2 text-primary"></i>
        {{ $usuario ? 'Editar usuario' : 'Nuevo usuario' }}
    </h1>
</div>

<div class="card border-0 shadow-sm" style="max-width:540px">
    <div class="card-body p-4">
        <form method="POST" action="{{ $usuario ? route('usuarios.update', $usuario->id) : route('usuarios.guardar') }}">
            @csrf
            @if($usuario) @method('PUT') @endif

            {{-- Nombre --}}
            <div class="mb-3">
                <label class="form-label fw-medium small">Nombre completo</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $usuario?->name) }}"
                       placeholder="Ej: Juan Pérez" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label fw-medium small">Correo electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $usuario?->email) }}"
                       placeholder="usuario@ejemplo.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Rol --}}
            <div class="mb-3">
                <label class="form-label fw-medium small">Rol</label>
                <select name="rol" class="form-select @error('rol') is-invalid @enderror" required>
                    <option value="">— Selecciona un rol —</option>
                    @foreach(['administrador', 'supervisor', 'operador'] as $r)
                        <option value="{{ $r }}"
                            {{ old('rol', $usuario?->rol) === $r ? 'selected' : '' }}>
                            {{ ucfirst($r) }}
                        </option>
                    @endforeach
                </select>
                @error('rol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text small text-muted mt-1">
                    <strong>Administrador:</strong> acceso total ·
                    <strong>Supervisor:</strong> dashboard + reportes ·
                    <strong>Operador:</strong> solo dashboard
                </div>
            </div>

            {{-- Contraseña --}}
            <div class="mb-3">
                <label class="form-label fw-medium small">
                    Contraseña
                    @if($usuario)
                        <span class="text-muted fw-normal">(dejar vacío para no cambiar)</span>
                    @endif
                </label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Mínimo 8 caracteres"
                       {{ $usuario ? '' : 'required' }}>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div class="mb-4">
                <label class="form-label fw-medium small">Confirmar contraseña</label>
                <input type="password" name="password_confirmation"
                       class="form-control"
                       placeholder="Repite la contraseña"
                       {{ $usuario ? '' : 'required' }}>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    {{ $usuario ? 'Guardar cambios' : 'Crear usuario' }}
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection