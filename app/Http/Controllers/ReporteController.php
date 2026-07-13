<?php

namespace App\Http\Controllers;

use App\Exports\LecturasExport;
use App\Models\Lectura;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class ReporteController extends Controller
{
    /**
     * GET /reportes
     * Lista todas las sesiones registradas.
     */
    public function index(): View
    {
        $sesiones = Lectura::selectRaw('
                sesion_id,
                COUNT(*)                        AS total_lecturas,
                ROUND(MAX(kg_procesados), 2)    AS kg_total,
                ROUND(AVG(rpm), 1)              AS rpm_promedio,
                ROUND(MAX(rpm), 1)              AS rpm_max,
                ROUND(AVG(kg_hora), 2)          AS kg_hora_promedio,
                MIN(created_at)                 AS inicio,
                MAX(created_at)                 AS fin
            ')
            ->whereNotNull('sesion_id')
            ->groupBy('sesion_id')
            ->orderByDesc('inicio')
            ->paginate(15);

        return view('reportes.index', compact('sesiones'));
    }

    /**
     * GET /reportes/sesion/{sesion_id}
     * Detalle completo de una sesión (tabla + mini gráfica).
     */
    public function detalle(string $sesionId): View
    {
        $lecturas = Lectura::deSesion($sesionId)
            ->orderBy('created_at')
            ->get();

        abort_if($lecturas->isEmpty(), 404, 'Sesión no encontrada.');

        $resumen = Lectura::resumenSesion($sesionId);

        return view('reportes.detalle', compact('lecturas', 'resumen', 'sesionId'));
    }

    /**
     * GET /reportes/pdf/{sesion_id}
     * Descarga el reporte de la sesión como PDF.
     */
    public function exportPDF(string $sesionId): Response
    {
        $lecturas = Lectura::deSesion($sesionId)->orderBy('created_at')->get();
        abort_if($lecturas->isEmpty(), 404, 'Sesión no encontrada.');

        $resumen = Lectura::resumenSesion($sesionId);

        $pdf = Pdf::loadView('reportes.pdf', compact('lecturas', 'resumen', 'sesionId'))
                  ->setPaper('a4', 'landscape')
                  ->setOption('defaultFont', 'sans-serif');

        $nombreArchivo = 'reporte-desgranado-' . str_replace(['/', ':'], '-', $sesionId) . '.pdf';

        return $pdf->download($nombreArchivo);
    }

    /**
     * GET /reportes/excel/{sesion_id}
     * Descarga el reporte de la sesión como Excel (.xlsx).
     */
    public function exportExcel(string $sesionId): BinaryFileResponse
    {
        abort_if(
            Lectura::deSesion($sesionId)->doesntExist(),
            404,
            'Sesión no encontrada.'
        );

        $nombreArchivo = 'reporte-desgranado-' . str_replace(['/', ':'], '-', $sesionId) . '.xlsx';

        return Excel::download(new LecturasExport($sesionId), $nombreArchivo);
    }
}
