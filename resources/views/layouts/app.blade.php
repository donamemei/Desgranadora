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
        :root {
            --maiz-gold: #d9a817;
            --maiz-deep: #b38408;
            --hoja-green: #4e713e;
            --hoja-dark: #35452c;
            --cream-light: #fffdf4;
            --cream-border: #ddd5b8;
        }

        body {
            background: linear-gradient(135deg, #f7efcf 0%, #f5f2df 46%, #e7efdc 100%);
            font-family: 'Segoe UI', sans-serif;
            transition: background .3s ease;
        }

        .navbar.bg-primary {
            background: linear-gradient(110deg, var(--hoja-dark), var(--hoja-green)) !important;
            box-shadow: 0 4px 16px rgba(53, 69, 44, .18);
        }

        .text-primary {
            color: var(--maiz-deep) !important;
        }

        .bg-primary {
            background-color: var(--hoja-green) !important;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background: rgba(255, 253, 244, 0.82);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(188, 164, 78, 0.22);
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            box-shadow: inset -1px 0 0 rgba(104, 91, 38, 0.05);
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
            background: linear-gradient(135deg, #fff4c9, #f1f4dc);
            color: var(--hoja-dark);
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--maiz-gold), #edc94c);
            color: var(--hoja-dark);
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(166, 119, 10, .2);
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
            color: #817641;
            padding: 12px 20px 6px;
            margin-top: 4px;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(188, 164, 78, 0.22);
            padding: 12px 14px;
            background: rgba(247, 241, 213, 0.58);
        }

        .main-content {
            padding: 2rem;
            animation: fadeInUp .35s ease;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--hoja-dark);
            margin-bottom: 1.5rem;
        }

        .modern-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(83, 76, 31, 0.1);
            border: 1px solid rgba(188, 164, 78, 0.2);
            transition: transform .2s ease, box-shadow .2s ease;
            background: rgba(255, 253, 244, 0.84);
        }

        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(83, 76, 31, 0.15);
        }

        .btn {
            transition: all .2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--hoja-green), #6c934f);
            border: none;
            box-shadow: 0 10px 22px rgba(61, 94, 46, .2);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--hoja-dark);
        }

        .btn-outline-secondary {
            border-radius: 50rem;
        }

        .form-control,
        .form-select,
        .form-check-input {
            border-radius: 12px;
            border-color: var(--cream-border);
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:focus {
            border-color: var(--maiz-gold);
            box-shadow: 0 0 0 0.2rem rgba(217, 168, 23, .18);
        }

        .alert {
            border-radius: 14px;
            border: none;
            box-shadow: 0 8px 18px rgba(83, 76, 31, .08);
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
                    <li class="nav-item">
                        <a href="{{ route('ventas.index') }}"
                            class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                            <i class="bi bi-cart-check"></i> Ventas
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