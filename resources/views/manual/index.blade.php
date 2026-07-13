@extends('layouts.app')
@section('content')

<h1 class="page-title">
    <i class="bi bi-book me-2 text-primary"></i>Manual de uso
</h1>

<div class="row g-4">

    {{-- Inicio rápido --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-lightning me-2 text-warning"></i>Inicio rápido — paso a paso
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach([
                        ['1','bi-power',           'primary', 'Encender la máquina',     'Presiona el botón físico del panel de control. El LED verde se encenderá y el Arduino se conectará al WiFi automáticamente.'],
                        ['2','bi-speedometer2',    'success', 'Verificar el dashboard',  'Abre el Dashboard en el sistema. En pocos segundos verás los datos de RPM y estado actualizándose en tiempo real.'],
                        ['3','bi-box-seam',        'warning', 'Iniciar el desgranado',   'Carga las mazorcas por la tolva de entrada. El sistema comenzará a registrar el peso del grano procesado automáticamente.'],
                        ['4','bi-eye',             'info',    'Monitorear la operación', 'Observa el dashboard. Si el badge cambia a ALERTA (rojo), detén la máquina y revisa si hay atasco o sobrecarga.'],
                        ['5','bi-stop-circle',     'danger',  'Finalizar la sesión',     'Presiona el botón para apagar la máquina. El sistema guardará los datos finales de la sesión automáticamente.'],
                        ['6','bi-file-earmark-pdf','secondary','Exportar el reporte',    'Ve a Reportes o Historial, busca la sesión recién terminada y descarga el PDF o Excel con el resumen completo.'],
                    ] as [$num, $icon, $color, $titulo, $desc])
                    <div class="col-md-4">
                        <div class="d-flex gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                                 style="width:36px;height:36px;background:var(--bs-{{ $color }});font-size:14px">
                                {{ $num }}
                            </div>
                            <div>
                                <div class="small fw-semibold mb-1">
                                    <i class="bi {{ $icon }} me-1"></i>{{ $titulo }}
                                </div>
                                <div class="small text-muted" style="line-height:1.5">{{ $desc }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Qué significa cada color --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-palette me-2 text-primary"></i>¿Qué significa cada color?
                </h6>
            </div>
            <div class="card-body">
                @foreach([
                    ['bg-success','EN OPERACIÓN', 'El motor está encendido y funcionando con normalidad. RPM dentro del rango correcto.'],
                    ['bg-danger', 'ALERTA',        'Las RPM superaron el límite seguro (800 RPM). Apagar y revisar inmediatamente.'],
                    ['bg-secondary','APAGADO',     'El motor está detenido. La sesión terminó o aún no ha comenzado.'],
                ] as [$bg, $estado, $desc])
                <div class="d-flex gap-3 mb-3 align-items-start">
                    <span class="badge {{ $bg }} px-2 py-2 mt-1" style="min-width:90px;text-align:center">{{ $estado }}</span>
                    <span class="small text-muted" style="line-height:1.6">{{ $desc }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Solución de problemas --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-tools me-2 text-danger"></i>Solución de problemas frecuentes
                </h6>
            </div>
            <div class="card-body">
                @foreach([
                    ['El dashboard no se actualiza',    'Verificar que el Arduino esté encendido y conectado al WiFi. Revisar el LED de estado.'],
                    ['RPM muestra 0 con motor encendido','El sensor Hall puede estar desalineado. Verificar la distancia al imán (máx. 3mm).'],
                    ['El peso no cambia',               'Verificar que la celda de carga no está bloqueada por residuos. Reiniciar la tara.'],
                    ['Badge en ALERTA constantemente',  'Reducir la velocidad de alimentación de mazorcas. Posible atasco en el rotor.'],
                ] as [$problema, $solucion])
                <div class="mb-3">
                    <div class="small fw-semibold text-danger mb-1">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $problema }}
                    </div>
                    <div class="small text-muted ms-3" style="line-height:1.5">{{ $solucion }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Roles --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-people me-2 text-primary"></i>¿Qué puede hacer cada usuario?
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Función</th>
                                <th class="text-center">Administrador</th>
                                <th class="text-center">Supervisor</th>
                                <th class="text-center">Operador</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach([
                                ['Ver dashboard en tiempo real',   true,  true,  true],
                                ['Ver historial de sesiones',      true,  true,  false],
                                ['Exportar reportes PDF / Excel',  true,  true,  false],
                                ['Gestionar usuarios del sistema', true,  false, false],
                                ['Cambiar roles de usuarios',      true,  false, false],
                            ] as [$func, $adm, $sup, $ope])
                            <tr>
                                <td class="small">{{ $func }}</td>
                                @foreach([$adm,$sup,$ope] as $val)
                                <td class="text-center">
                                    @if($val)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @else
                                        <i class="bi bi-x-circle text-muted"></i>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
