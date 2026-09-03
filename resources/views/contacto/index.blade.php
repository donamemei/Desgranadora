@extends('layouts.app')
@section('content')

<h1 class="page-title">
    <i class="bi bi-telephone me-2 text-primary"></i>Contacto y soporte
</h1>

<div class="row g-4">

    {{-- Tarjetas de contacto del equipo --}}
    @foreach([
    ['60725402','Integrante 1','Hardware y sensores', '#cfe2ff','#052c65','bi-cpu', 'Problemas con la máquina, sensores o Arduino'],
    ['60759610','Integrante 2','Sistema web', '#d1e7dd','#0a3622','bi-code-slash', 'Problemas con el software, dashboard o reportes'],
    ['60723393','Integrante 3','Documentación', '#fff3cd','#664d03','bi-file-text', 'Consultas sobre el proyecto, informe o datos'],
    ] as [$ini,$nombre,$rol,$bg,$color,$icon,$especialidad])
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold mx-auto mb-3"
                    style="width:56px;height:56px;background:{{ $bg }};color:{{ $color }};font-size:16px">
                    {{ $ini }}
                </div>
                <h6 class="fw-semibold mb-0">{{ $nombre }}</h6>
                <div class="small text-primary mb-3">{{ $rol }}</div>
                <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                    <i class="bi {{ $icon }} text-muted"></i>
                    <span class="small text-muted">{{ $especialidad }}</span>
                </div>
                <div class="small text-muted p-2 rounded-2" style="background:{{ $bg }}60">
                    Contactar al Integrante para soporte en su área
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Info del instituto --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-building me-2 text-primary"></i>Instituto técnico "Federico Alvarez Plata"
                </h6>
            </div>
            <div class="card-body">
                @foreach([
                ['bi-geo-alt', 'Ubicación', 'Cochabamba, Bolivia'],
                ['bi-calendar3', 'Gestión', '2026'],
                ['bi-mortarboard','Carrera', 'Técnico Superior en Informática'],
                ['bi-clock', 'Horario', 'Lunes a Viernes — 18:00 - 22:00'],
                ] as [$icon,$label,$valor])
                <div class="d-flex gap-3 mb-3 align-items-center">
                    <div class="rounded-2 d-flex align-items-center justify-content-center"
                        style="width:32px;height:32px;background:#0d6efd15;flex-shrink:0">
                        <i class="bi {{ $icon }} text-primary"></i>
                    </div>
                    <div>
                        <div class="small text-muted" style="font-size:11px">{{ $label }}</div>
                        <div class="small fw-medium">{{ $valor }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Soporte técnico --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-headset me-2 text-primary"></i>Guía de soporte
                </h6>
            </div>
            <div class="card-body">
                @foreach([
                ['bi-bug', 'danger', 'Error en el sistema web', 'Contactar a Donny Ortega — Software'],
                ['bi-exclamation-triangle','warning','Alerta de la máquina', 'Detener operación. Contactar a Daniel Maita — Hardware'],
                ['bi-gear','info','Problema con la máquina', 'Verificar sensores y conexiones. Contactar a Daniel Maita — Hardware'],
                ['bi-file-earmark-x', 'secondary','Problema con reportes', 'Verificar que hay sesiones en la BD. Contactar a Donny Ortega — Software'],
                ['bi-wifi-off', 'dark', 'Sin datos en el dashboard', 'Verificar WiFi del Arduino. Contactar a Daniel Maita — Hardware'],
                ] as [$icon,$color,$problema,$accion])
                <div class="d-flex gap-3 mb-3 align-items-start">
                    <i class="bi {{ $icon }} text-{{ $color }} mt-1" style="font-size:16px;flex-shrink:0"></i>
                    <div>
                        <div class="small fw-semibold">{{ $problema }}</div>
                        <div class="small text-muted">{{ $accion }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection