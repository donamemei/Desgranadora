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
        body {
            background: linear-gradient(135deg, #f3f8ff 0%, #eefaf6 45%, #fff9ee 100%);
            font-family: 'Segoe UI', sans-serif;
            transition: background .3s ease;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(148, 163, 184, 0.18);
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            box-shadow: inset -1px 0 0 rgba(15, 23, 42, 0.04);
        }

        .sidebar .nav-link {
            color: #495057;
            padding: .65rem 1.2rem;
            border-radius: 12px;
            margin: 2px 8px;
            font-size: .88rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
        }

        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #e0f2fe, #ecfeff);
            color: #0f766e;
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.25);
        }

        .sidebar .nav-link i {
            width: 18px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sidebar-section {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: #64748b;
            padding: 12px 20px 6px;
            margin-top: 4px;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(148, 163, 184, 0.2);
            padding: 12px 14px;
            background: rgba(248, 250, 252, 0.6);
        }

        .main-content {
            padding: 2rem;
            animation: fadeInUp .35s ease;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1.5rem;
        }

        .modern-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
            transition: transform .2s ease, box-shadow .2s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.12);
        }

        .btn {
            transition: all .2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            border: none;
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.22);
        }

        .btn-outline-secondary {
            border-radius: 50rem;
        }

        .form-control,
        .form-select,
        .form-check-input {
            border-radius: 12px;
            border-color: #dbe3ef;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.18);
        }

        .alert {
            border-radius: 14px;
            border: none;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    {{-- PWA --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d6efd">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Desgranadora">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
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
            {{-- Badge estado Arduino --}}
            <div class="d-flex align-items-center gap-1" id="estado-arduino">
                <span class="badge rounded-pill" id="badge-conexion"
                    style="background:#6c757d;transition:background .3s;font-size:11px">
                    <span class="spinner-grow spinner-grow-sm me-1" id="spinner-estado"
                        style="width:7px;height:7px"></span>
                    <span id="texto-conexion">Conectando...</span>
                </span>
            </div>
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
                    <li class="nav-item">
                        <a href="{{ route('productores.index') }}"
                            class="nav-link {{ request()->routeIs('productores.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i> Productores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tipos-maiz.index') }}"
                            class="nav-link {{ request()->routeIs('tipos-maiz.*') ? 'active' : '' }}">
                            <i class="bi bi-basket-fill"></i> Tipos de maíz
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('lotes.index') }}"
                            class="nav-link {{ request()->routeIs('lotes.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i> Lotes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('clasificaciones.index') }}"
                            class="nav-link {{ request()->routeIs('clasificaciones.*') ? 'active' : '' }}">
                            <i class="bi bi-clipboard-check"></i> Clasificación
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('alertas.index') }}"
                            class="nav-link {{ request()->routeIs('alertas.*') ? 'active' : '' }}">
                            <i class="bi bi-bell"></i> Alertas
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

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteTitle">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>Confirmar eliminación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="confirmDeleteMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                        <i class="bi bi-trash me-1"></i>Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const deleteModalElement = document.getElementById('confirmDeleteModal');
        const deleteModal = deleteModalElement ? new bootstrap.Modal(deleteModalElement) : null;
        let formToDelete = null;

        document.querySelectorAll('form[data-confirm-delete]').forEach(form => {
            form.addEventListener('submit', event => {
                if (formToDelete === form) return;

                event.preventDefault();
                formToDelete = form;
                document.getElementById('confirmDeleteMessage').textContent = form.dataset.confirmDelete;
                deleteModal.show();
            });
        });

        document.getElementById('confirmDeleteButton')?.addEventListener('click', () => {
            if (!formToDelete) return;

            const form = formToDelete;
            formToDelete = null;
            deleteModal.hide();
            form.submit();
        });

        deleteModalElement?.addEventListener('hidden.bs.modal', () => {
            formToDelete = null;
        });
    </script>
    <script>
        function actualizarReloj() {
            const a = new Date();
            const el = document.getElementById('reloj');
            if (el) el.textContent = a.toLocaleTimeString('es-BO', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
        actualizarReloj();
        setInterval(actualizarReloj, 1000);
    </script>
    <script>
        async function verificarEstadoArduino() {
            try {
                const res = await fetch('/api/estado');
                const data = await res.json();

                const badge = document.getElementById('badge-conexion');
                const texto = document.getElementById('texto-conexion');
                const spinner = document.getElementById('spinner-estado');

                if (!badge) return;

                const colores = {
                    online: '#198754',
                    advertencia: '#ffc107',
                    offline: '#dc3545',
                    nunca: '#6c757d',
                };

                badge.style.background = colores[data.estado] || '#6c757d';
                texto.textContent = data.etiqueta;
                spinner.style.display = data.estado === 'online' ? 'inline-block' : 'none';

            } catch (err) {
                const badge = document.getElementById('badge-conexion');
                const texto = document.getElementById('texto-conexion');
                if (badge) badge.style.background = '#dc3545';
                if (texto) texto.textContent = 'Sin conexión';
            }
        }

        verificarEstadoArduino();
        setInterval(verificarEstadoArduino, 3000);
    </script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('[PWA] Registrado:', reg.scope))
                    .catch(err => console.error('[PWA] Error:', err));
            });
        }
    </script>
    @stack('scripts')
</body>

</html>