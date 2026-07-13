<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema Desgranadora - {{ $title ?? 'Panel' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }

        .sidebar {
            min-height: calc(100vh - 56px);
            background: #ffffff;
            border-right: 1px solid #dee2e6;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #495057;
            padding: .55rem 1.2rem;
            border-radius: 8px;
            margin: 2px 8px;
            font-size: .88rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background .12s;
        }
        .sidebar .nav-link:hover { background: #e9f0fb; color: #0d6efd; }
        .sidebar .nav-link.active { background: #0d6efd; color: #ffffff; font-weight: 500; }
        .sidebar .nav-link i { width: 18px; text-align: center; font-size: 15px; flex-shrink: 0; }
        .sidebar-section {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #adb5bd;
            padding: 10px 20px 4px;
            margin-top: 4px;
        }
        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid #dee2e6;
            padding: 12px 10px;
        }
        .main-content { padding: 2rem; }
        .page-title { font-size: 1.4rem; font-weight: 600; color: #212529; margin-bottom: 1.5rem; }
    </style>
    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3" style="position:sticky;top:0;z-index:1030">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
        <i class="bi bi-gear-wide-connected fs-5"></i>
        Sistema Desgranadora
    </a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-white-50 small d-none d-md-inline">
            <i class="bi bi-clock me-1"></i><span id="reloj"></span>
        </span>
        <span class="text-white small">
            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
            <span class="badge bg-white text-primary ms-1" style="font-size:10px">
                {{ ucfirst(auth()->user()->rol) }}
            </span>
        </span>
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light">
                <i class="bi bi-box-arrow-right me-1"></i>Salir
            </button>
        </form>
    </div>
</nav>

<div class="container-fluid">
<div class="row">

{{-- SIDEBAR --}}
<nav class="col-md-2 sidebar d-none d-md-flex flex-column p-0">

    {{-- Principal --}}
    <div class="sidebar-section">Principal</div>
    <ul class="nav flex-column px-0">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        @if(auth()->user()->puedeVerReportes())
        <li class="nav-item">
            <a href="{{ route('reportes.index') }}"
               class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Reportes
            </a>
        </li>
        @endif

        @if(auth()->user()->puedeGestionarUsuarios())
        <li class="nav-item">
            <a href="{{ route('usuarios.index') }}"
               class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Usuarios
            </a>
        </li>
        @endif
    </ul>

    {{-- Operación --}}
    <div class="sidebar-section">Operación</div>
    <ul class="nav flex-column px-0">
        <li class="nav-item">
            <a href="{{ route('estadisticas.index') }}"
               class="nav-link {{ request()->routeIs('estadisticas.*') ? 'active' : '' }}">
                <i class="bi bi-pie-chart"></i> Estadísticas
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('historial.index') }}"
               class="nav-link {{ request()->routeIs('historial.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Historial
            </a>
        </li>
    </ul>

    {{-- Información --}}
    <div class="sidebar-section">Información</div>
    <ul class="nav flex-column px-0">
        <li class="nav-item">
            <a href="{{ route('maquina.index') }}"
               class="nav-link {{ request()->routeIs('maquina.*') ? 'active' : '' }}">
                <i class="bi bi-gear-wide"></i> La máquina
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('manual.index') }}"
               class="nav-link {{ request()->routeIs('manual.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Manual de uso
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('acerca.index') }}"
               class="nav-link {{ request()->routeIs('acerca.*') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i> Acerca del proyecto
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('contacto.index') }}"
               class="nav-link {{ request()->routeIs('contacto.*') ? 'active' : '' }}">
                <i class="bi bi-telephone"></i> Contacto
            </a>
        </li>
    </ul>

    {{-- Footer del sidebar --}}
    <div class="sidebar-footer">
        <div class="small fw-semibold text-truncate">{{ auth()->user()->name }}</div>
        <div class="small text-muted">{{ ucfirst(auth()->user()->rol) }}</div>
    </div>

</nav>

{{-- CONTENIDO --}}
<main class="col-md-10 main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function actualizarReloj(){
        const a = new Date();
        const el = document.getElementById('reloj');
        if(el) el.textContent = a.toLocaleTimeString('es-BO',{hour:'2-digit',minute:'2-digit',second:'2-digit'});
    }
    actualizarReloj();
    setInterval(actualizarReloj, 1000);
</script>
@stack('scripts')
</body>
</html>
