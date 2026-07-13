@extends('layouts.app')
@section('content')

<h1 class="page-title">
    <i class="bi bi-gear-wide me-2 text-primary"></i>La máquina desgranadora
</h1>

<div class="row g-4">

    {{-- Ficha técnica --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-clipboard-data me-2 text-primary"></i>Ficha técnica
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tbody>
                        @foreach([
                            ['Tipo',              'Desgranadora eléctrica de maíz'],
                            ['Motor',             '1/4 HP — 220V monofásico'],
                            ['RPM del rotor',     '300 – 600 RPM (operación normal)'],
                            ['RPM de alerta',     'Mayor a 800 RPM'],
                            ['Capacidad',         '20 – 50 kg / hora'],
                            ['Peso del equipo',   'Aprox. 15 kg'],
                            ['Alimentación',      '220V — 50/60 Hz'],
                            ['Sensores',          'Hall (RPM) + Celda de carga (peso)'],
                            ['Microcontrolador',  'Arduino Uno + ESP8266 NodeMCU'],
                            ['Comunicación',      'WiFi 2.4GHz — HTTP REST'],
                        ] as [$key, $val])
                        <tr>
                            <td class="text-muted small fw-medium" style="width:45%">{{ $key }}</td>
                            <td class="small">{{ $val }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Estados del sistema --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-traffic-light me-2 text-primary"></i>Estados del motor
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                    <span class="badge bg-success px-3 py-2">ON</span>
                    <div>
                        <div class="small fw-medium">En operación</div>
                        <div class="small text-muted">Motor funcionando con RPM dentro del rango normal.</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                    <span class="badge bg-danger px-3 py-2">ALERTA</span>
                    <div>
                        <div class="small fw-medium">RPM fuera de rango</div>
                        <div class="small text-muted">El rotor superó 800 RPM. Detener y revisar la carga.</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 py-2">
                    <span class="badge bg-secondary px-3 py-2">OFF</span>
                    <div>
                        <div class="small fw-medium">Motor apagado</div>
                        <div class="small text-muted">Sesión finalizada o máquina en espera.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-shield-check me-2 text-success"></i>Mantenimiento recomendado
                </h6>
            </div>
            <div class="card-body">
                @foreach([
                    ['Semanal',  'Limpiar residuos de grano del rotor y la tolva.'],
                    ['Mensual',  'Verificar tensión de la correa y alineación de poleas.'],
                    ['Mensual',  'Lubricar rodamientos con grasa industrial.'],
                    ['Trimestral','Revisar conexiones eléctricas y estado del cableado.'],
                ] as [$freq, $tarea])
                <div class="d-flex gap-3 mb-2">
                    <span class="badge bg-primary-subtle text-primary-emphasis" style="height:fit-content;white-space:nowrap">{{ $freq }}</span>
                    <span class="small text-muted">{{ $tarea }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
