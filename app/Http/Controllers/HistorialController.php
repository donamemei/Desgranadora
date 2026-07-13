<?php

namespace App\Http\Controllers;
use App\Models\Lectura;
use Illuminate\View\View;

class HistorialController extends Controller
{
    public function index(): View
    {
        $sesiones = Lectura::selectRaw('
                sesion_id,
                COUNT(*) as total_lecturas,
                ROUND(MAX(kg_procesados),2) as kg_total,
                ROUND(AVG(rpm),1) as rpm_promedio,
                ROUND(AVG(kg_hora),1) as kg_hora_promedio,
                MIN(created_at) as inicio,
                MAX(created_at) as fin
            ')
            ->whereNotNull('sesion_id')
            ->groupBy('sesion_id')
            ->orderByDesc('inicio')
            ->paginate(12);

        return view('historial.index', compact('sesiones'));
    }
}