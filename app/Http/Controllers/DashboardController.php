<?php

namespace App\Http\Controllers;

use App\Models\Lectura;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal.
     * Los datos en tiempo real los carga JavaScript via /api/lectura/ultimo.
     * Aquí solo pasamos datos iniciales para que la página no inicie vacía.
     */
    public function index(): View
    {
        // Última lectura para mostrar valores iniciales al cargar la página
        $ultimaLectura = Lectura::latest()->first();

        // Sesión activa (última sesión con motor ON)
        $sesionActiva = Lectura::where('estado_motor', 'ON')
            ->latest()
            ->value('sesion_id');

        // Estadísticas rápidas del día de hoy
        $hoy = today();
        $kgHoy = Lectura::whereDate('created_at', $hoy)->max('kg_procesados') ?? 0;
        $sesionesHoy = Lectura::whereDate('created_at', $hoy)
            ->distinct('sesion_id')
            ->count('sesion_id');

        return view('dashboard.index', compact(
            'ultimaLectura',
            'sesionActiva',
            'kgHoy',
            'sesionesHoy',
        ));
    }
}
