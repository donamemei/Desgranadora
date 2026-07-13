<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lectura;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LecturaController extends Controller
{
    /**
     * POST /api/lectura
     *
     * Recibe el JSON del Arduino y lo guarda en la BD.
     * El Arduino llama a este endpoint cada ~2 segundos.
     *
     * Ejemplo de body esperado:
     * {
     *   "rpm": 450.5,
     *   "kg_procesados": 3.72,
     *   "kg_hora": 22.3,
     *   "temperatura": 38.1,
     *   "estado_motor": "ON",
     *   "sesion_id": "SES-20241015-001"
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'rpm'           => 'required|numeric|min:0|max:2000',
            'kg_procesados' => 'required|numeric|min:0',
            'kg_hora'       => 'required|numeric|min:0',
            'temperatura'   => 'nullable|numeric|min:0|max:200',
            'estado_motor'  => ['required', 'string', Rule::in(['ON', 'OFF', 'ALERTA'])],
            'sesion_id'     => 'required|string|max:30',
        ]);

        $lectura = Lectura::create($data);

        return response()->json([
            'ok'         => true,
            'id'         => $lectura->id,
            'guardado_a' => $lectura->created_at->toTimeString(),
        ], 201);
    }

    /**
     * GET /api/lectura/ultimo
     *
     * Devuelve la lectura más reciente.
     * El dashboard JavaScript llama a este endpoint cada 2 segundos
     * con setInterval para actualizar las tarjetas y gráficas.
     */
    public function ultimo(): JsonResponse
    {
        $lectura = Lectura::latest()->first();

        if (! $lectura) {
            return response()->json([
                'ok'            => false,
                'mensaje'       => 'Sin datos aún',
                'rpm'           => 0,
                'kg_procesados' => 0,
                'kg_hora'       => 0,
                'temperatura'   => 0,
                'estado_motor'  => 'OFF',
                'sesion_id'     => null,
                'timestamp'     => null,
            ]);
        }

        return response()->json([
            'ok'            => true,
            'id'            => $lectura->id,
            'rpm'           => $lectura->rpm,
            'kg_procesados' => $lectura->kg_procesados,
            'kg_hora'       => $lectura->kg_hora,
            'temperatura'   => $lectura->temperatura ?? 0,
            'estado_motor'  => $lectura->estado_motor,
            'sesion_id'     => $lectura->sesion_id,
            'timestamp'     => $lectura->created_at->toDateTimeString(),
        ]);
    }

    /**
     * GET /api/lectura/sesion/{sesion_id}
     *
     * Devuelve todas las lecturas de una sesión específica.
     * Usado por las gráficas históricas y los reportes PDF/Excel.
     *
     * Ejemplo: GET /api/lectura/sesion/SES-20241015-001
     */
    public function porSesion(string $sesionId): JsonResponse
    {
        $lecturas = Lectura::deSesion($sesionId)
            ->orderBy('created_at')
            ->get([
                'id', 'rpm', 'kg_procesados', 'kg_hora',
                'temperatura', 'estado_motor', 'created_at',
            ]);

        return response()->json([
            'ok'       => true,
            'sesion'   => $sesionId,
            'total'    => $lecturas->count(),
            'resumen'  => Lectura::resumenSesion($sesionId),
            'lecturas' => $lecturas,
        ]);
    }

    /**
     * GET /api/sesiones
     *
     * Devuelve la lista de sesiones únicas registradas.
     * Usado en la vista de Reportes para mostrar el historial.
     */
    public function sesiones(): JsonResponse
    {
        $sesiones = Lectura::selectRaw('
                sesion_id,
                COUNT(*) as total_lecturas,
                MAX(kg_procesados) as kg_total,
                ROUND(AVG(rpm), 1) as rpm_promedio,
                MIN(created_at) as inicio,
                MAX(created_at) as fin
            ')
            ->whereNotNull('sesion_id')
            ->groupBy('sesion_id')
            ->orderByDesc('inicio')
            ->get();

        return response()->json([
            'ok'      => true,
            'total'   => $sesiones->count(),
            'sesiones' => $sesiones,
        ]);
    }
}
