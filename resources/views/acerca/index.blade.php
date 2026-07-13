@extends('layouts.app')
@section('content')

<h1 class="page-title">
    <i class="bi bi-info-circle me-2 text-primary"></i>Acerca del proyecto
</h1>

<div class="row g-4">

    {{-- Descripción del proyecto --}}
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:56px;height:56px;background:#0d6efd20">
                        <i class="bi bi-gear-wide-connected text-primary fs-3"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0" style="font-size:15px">Sistema de Maquinaria para el Desgranado</h5>
                        <div class="text-muted small">y Aprovechamiento de Residuos del Maíz</div>
                    </div>
                </div>

                <p class="small text-muted" style="line-height:1.7">
                    Sistema integral que combina una máquina desgranadora eléctrica con sensores IoT y
                    un software web de monitoreo en tiempo real. Permite registrar, visualizar y exportar
                    datos de producción (RPM, kg procesados, productividad) durante cada sesión de operación.
                </p>

                <hr class="my-3">

                <div class="row g-3">
                    @foreach([
                        ['bi-building','Instituto','Instituto Técnico — La Paz, Bolivia'],
                        ['bi-calendar3','Año','2024'],
                        ['bi-mortarboard','Carrera','Técnico Superior en Informática'],
                        ['bi-cpu','Tecnologías','Laravel · Arduino · ESP8266 · MySQL · Chart.js'],
                    ] as [$icon,$label,$valor])
                    <div class="col-6">
                        <div class="small text-muted mb-1">
                            <i class="bi {{ $icon }} me-1"></i>{{ $label }}
                        </div>
                        <div class="small fw-medium">{{ $valor }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Integrantes --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-people me-2 text-primary"></i>Equipo de desarrollo
                </h6>
            </div>
            <div class="card-body">
                @foreach([
                    ['I1','Integrante 1','Hardware y sensores',   'Diseño mecánico, construcción, Arduino',       '#cfe2ff','#052c65'],
                    ['I2','Integrante 2','Software web',          'Laravel, dashboard, API REST, reportes',       '#d1e7dd','#0a3622'],
                    ['I3','Integrante 3','Análisis y documentación','FODA, marco teórico, informe, presentación', '#fff3cd','#664d03'],
                ] as [$ini,$nombre,$rol,$desc,$bg,$color])
                <div class="d-flex gap-3 mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                         style="width:44px;height:44px;background:{{ $bg }};color:{{ $color }};font-size:13px">
                        {{ $ini }}
                    </div>
                    <div>
                        <div class="small fw-semibold">{{ $nombre }}</div>
                        <div class="small text-primary">{{ $rol }}</div>
                        <div class="small text-muted" style="font-size:11px">{{ $desc }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Objetivos --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-bullseye me-2 text-primary"></i>Objetivos del proyecto
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background:#0d6efd10;border-left:3px solid #0d6efd">
                            <div class="small fw-semibold mb-1">Objetivo general</div>
                            <div class="small text-muted">Diseñar e implementar un sistema de monitoreo digital para el desgranado de maíz que mejore la productividad y registre los datos de operación en tiempo real.</div>
                        </div>
                    </div>
                    @foreach([
                        ['Construir','Desarrollar la máquina desgranadora con sensores de RPM y peso integrados.'],
                        ['Monitorear','Implementar el sistema web con dashboard en tiempo real y control de acceso por roles.'],
                        ['Documentar','Generar reportes exportables en PDF y Excel con los datos de cada sesión de producción.'],
                    ] as [$titulo,$desc])
                    <div class="col-md-2-dot-6">
                        <div class="p-3 rounded-3 h-100" style="background:#19875410;border-left:3px solid #198754">
                            <div class="small fw-semibold mb-1">{{ $titulo }}</div>
                            <div class="small text-muted">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection