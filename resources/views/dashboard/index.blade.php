@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard en tiempo real
    </h1>
    <div class="d-flex align-items-center gap-2">
        <span class="badge rounded-pill bg-light text-dark border" id="badge-estado">
            <span class="spinner-grow spinner-grow-sm text-secondary me-1" id="spinner-conectando"></span>
            <span id="texto-estado">Conectando...</span>
        </span>
        <span class="text-muted small" id="ultima-actualizacion">—</span>
    </div>
</div>

{{-- ─── TARJETAS DE MÉTRICAS ─────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- RPM --}}
    <div class="col-6 col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">RPM actual</p>
                        <h2 class="fw-bold mb-0" id="val-rpm">
                            {{ $ultimaLectura ? $ultimaLectura->rpm : '0' }}
                        </h2>
                        <small class="text-muted">rev/min</small>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:42px;height:42px;background:#e9f0fb">
                        <i class="bi bi-arrow-repeat text-primary fs-5"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height:4px">
                    <div class="progress-bar bg-primary" id="bar-rpm"
                         style="width:{{ $ultimaLectura ? min(($ultimaLectura->rpm/800)*100,100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- KG PROCESADOS --}}
    <div class="col-6 col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Kg procesados</p>
                        <h2 class="fw-bold mb-0" id="val-kg">
                            {{ $ultimaLectura ? $ultimaLectura->kg_procesados : '0' }}
                        </h2>
                        <small class="text-muted">en sesión actual</small>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:42px;height:42px;background:#e8f5e9">
                        <i class="bi bi-box-seam text-success fs-5"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height:4px">
                    <div class="progress-bar bg-success" id="bar-kg" style="width:0%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- KG / HORA --}}
    <div class="col-6 col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Productividad</p>
                        <h2 class="fw-bold mb-0" id="val-kgh">
                            {{ $ultimaLectura ? $ultimaLectura->kg_hora : '0' }}
                        </h2>
                        <small class="text-muted">kg / hora</small>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:42px;height:42px;background:#fff3e0">
                        <i class="bi bi-graph-up-arrow text-warning fs-5"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height:4px">
                    <div class="progress-bar bg-warning" id="bar-kgh" style="width:0%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ESTADO MOTOR --}}
    <div class="col-6 col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Estado motor</p>
                        <h4 class="fw-bold mb-1" id="val-estado">
                            {{ $ultimaLectura ? $ultimaLectura->estado_motor : 'OFF' }}
                        </h4>
                        <small class="text-muted" id="val-temp">
                            Temp: {{ $ultimaLectura ? $ultimaLectura->temperatura.'°C' : '—' }}
                        </small>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         id="icono-motor"
                         style="width:42px;height:42px;background:#f8d7da">
                        <i class="bi bi-power text-danger fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge fs-6 px-3 py-2" id="badge-motor" style="background:#dc3545">
                        APAGADO
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ─── GRÁFICAS ───────────────────────────────────────────────────────── --}}
<div class="row g-3">

    {{-- Gráfica RPM en tiempo real --}}
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">
                        <i class="bi bi-activity me-2 text-primary"></i>RPM en tiempo real
                    </h6>
                    <small class="text-muted">Últimos 30 registros</small>
                </div>
            </div>
            <div class="card-body">
                <canvas id="grafica-rpm" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Gráfica Kg procesados --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">
                        <i class="bi bi-bar-chart me-2 text-success"></i>Kg procesados
                    </h6>
                    <small class="text-muted">Sesión actual</small>
                </div>
            </div>
            <div class="card-body">
                <canvas id="grafica-kg" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Panel de información de sesión --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex flex-wrap gap-4 align-items-center">
                <div>
                    <span class="text-muted small">Sesión activa</span>
                    <div class="fw-semibold" id="val-sesion">
                        {{ $sesionActiva ?? 'Sin sesión activa' }}
                    </div>
                </div>
                <div>
                    <span class="text-muted small">Kg procesados hoy</span>
                    <div class="fw-semibold">{{ round($kgHoy, 2) }} kg</div>
                </div>
                <div>
                    <span class="text-muted small">Sesiones hoy</span>
                    <div class="fw-semibold">{{ $sesionesHoy }}</div>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('reportes.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-file-earmark-bar-graph me-1"></i>Ver reportes
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
{{-- Chart.js desde CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
// ─── Configuración de las gráficas ───────────────────────────────────────

const ctxRpm = document.getElementById('grafica-rpm').getContext('2d');
const ctxKg  = document.getElementById('grafica-kg').getContext('2d');

// Gráfica de línea — RPM en tiempo real
const graficaRpm = new Chart(ctxRpm, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'RPM',
            data: [],
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.08)',
            borderWidth: 2,
            pointRadius: 2,
            fill: true,
            tension: 0.4,
        }]
    },
    options: {
        responsive: true,
        animation: { duration: 300 },
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { maxTicksLimit: 6, font: { size: 11 } }, grid: { display: false } },
            y: { min: 0, max: 900, ticks: { font: { size: 11 } } }
        }
    }
});

// Gráfica de barras — kg acumulados por minuto
const graficaKg = new Chart(ctxKg, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Kg/hora',
            data: [],
            backgroundColor: 'rgba(25, 135, 84, 0.7)',
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        animation: { duration: 300 },
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { maxTicksLimit: 8, font: { size: 11 } }, grid: { display: false } },
            y: { min: 0, ticks: { font: { size: 11 } } }
        }
    }
});

// ─── Helpers de UI ───────────────────────────────────────────────────────

function actualizarEstadoMotor(estado) {
    const badge   = document.getElementById('badge-motor');
    const icono   = document.getElementById('icono-motor');
    const valEst  = document.getElementById('val-estado');
    valEst.textContent = estado;

    const config = {
        'ON':     { bg: '#198754', texto: 'EN OPERACIÓN',  iconoBg: '#d1e7dd', icono: 'text-success' },
        'OFF':    { bg: '#6c757d', texto: 'APAGADO',       iconoBg: '#f8d7da', icono: 'text-danger'  },
        'ALERTA': { bg: '#dc3545', texto: '⚠ ALERTA',     iconoBg: '#fff3cd', icono: 'text-warning' },
    };
    const c = config[estado] || config['OFF'];
    badge.textContent        = c.texto;
    badge.style.background   = c.bg;
    icono.style.background   = c.iconoBg;
}

function actualizarBadgeConexion(ok) {
    const badge   = document.getElementById('badge-estado');
    const spinner = document.getElementById('spinner-conectando');
    const texto   = document.getElementById('texto-estado');
    if (ok) {
        badge.className = 'badge rounded-pill bg-success text-white';
        spinner.style.display = 'none';
        texto.textContent = 'Conectado';
    } else {
        badge.className = 'badge rounded-pill bg-danger text-white';
        spinner.style.display = 'inline-block';
        texto.textContent = 'Sin señal';
    }
}

function agregarPuntoGrafica(grafica, label, valor, maxPuntos = 30) {
    grafica.data.labels.push(label);
    grafica.data.datasets[0].data.push(valor);
    if (grafica.data.labels.length > maxPuntos) {
        grafica.data.labels.shift();
        grafica.data.datasets[0].data.shift();
    }
    grafica.update();
}

// ─── Polling principal — se ejecuta cada 2 segundos ──────────────────────

async function actualizarDashboard() {
    try {
        const res  = await fetch('/api/lectura/ultimo');
        const data = await res.json();

        if (!data.ok) { actualizarBadgeConexion(false); return; }

        actualizarBadgeConexion(true);

        // Actualizar tarjetas numéricas
        document.getElementById('val-rpm').textContent  = data.rpm.toFixed(1);
        document.getElementById('val-kg').textContent   = data.kg_procesados.toFixed(2);
        document.getElementById('val-kgh').textContent  = data.kg_hora.toFixed(1);
        document.getElementById('val-temp').textContent = `Temp: ${data.temperatura}°C`;
        document.getElementById('val-sesion').textContent = data.sesion_id ?? '—';

        // Barras de progreso (RPM max 800, kg asume max 50 kg sesión)
        document.getElementById('bar-rpm').style.width  = `${Math.min((data.rpm / 800) * 100, 100)}%`;
        document.getElementById('bar-kg').style.width   = `${Math.min((data.kg_procesados / 50) * 100, 100)}%`;
        document.getElementById('bar-kgh').style.width  = `${Math.min((data.kg_hora / 50) * 100, 100)}%`;

        // Estado del motor con color
        actualizarEstadoMotor(data.estado_motor);

        // Timestamp de última actualización
        const ahora = new Date();
        document.getElementById('ultima-actualizacion').textContent =
            `Actualizado: ${ahora.toLocaleTimeString('es-BO')}`;

        // Agregar puntos a las gráficas
        const hora = ahora.toLocaleTimeString('es-BO', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        agregarPuntoGrafica(graficaRpm, hora, data.rpm);
        agregarPuntoGrafica(graficaKg,  hora, data.kg_hora, 20);

    } catch (err) {
        actualizarBadgeConexion(false);
        console.error('Error al actualizar dashboard:', err);
    }
}

// Ejecuta inmediatamente y luego cada 2 segundos
actualizarDashboard();
setInterval(actualizarDashboard, 2000);
</script>
@endpush
