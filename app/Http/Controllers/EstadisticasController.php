<?php

namespace App\Http\Controllers;
use App\Models\Lectura;
use Illuminate\View\View;

class EstadisticasController extends Controller
{
    public function index(): View
    {
        $stats = [
            'kg_total_historico'   => round(Lectura::max('kg_procesados') ?? 0, 2),
            'total_sesiones'       => Lectura::distinct('sesion_id')->count('sesion_id'),
            'rpm_promedio_global'  => round(Lectura::avg('rpm') ?? 0, 1),
            'kg_hora_promedio'     => round(Lectura::where('estado_motor','ON')->avg('kg_hora') ?? 0, 1),
            'temp_max_registrada'  => round(Lectura::max('temperatura') ?? 0, 1),
            'total_lecturas'       => Lectura::count(),
            // Por mes (últimos 6 meses)
            'por_mes' => Lectura::selectRaw("DATE_FORMAT(created_at,'%Y-%m') as mes, MAX(kg_procesados) as kg, COUNT(DISTINCT sesion_id) as sesiones")
                ->groupBy('mes')->orderBy('mes','desc')->limit(6)->get(),
        ];
        return view('estadisticas.index', compact('stats'));
    }
}