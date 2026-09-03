<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\Models\Lote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClasificacionController extends Controller
{
    public function index(): View
    {
        $clasificaciones = Clasificacion::with('lote.productor', 'lote.tipoMaiz')->orderByDesc('created_at')->paginate(10);

        return view('clasificaciones.index', compact('clasificaciones'));
    }

    public function create(): View
    {
        $lotes = Lote::with(['productor', 'tipoMaiz'])->orderByDesc('fecha_recepcion')->get();

        return view('clasificaciones.form', compact('lotes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'categoria' => 'required|in:primera,segunda,desechos',
            'porcentaje_primera' => 'required|numeric|min:0|max:100',
            'porcentaje_segunda' => 'required|numeric|min:0|max:100',
            'porcentaje_desechos' => 'required|numeric|min:0|max:100',
            'observaciones' => 'nullable|string',
        ]);

        $data['usuario_id'] = Auth::id();

        Clasificacion::create($data);

        return redirect()->route('clasificaciones.index')->with('success', 'Clasificación registrada correctamente.');
    }

    public function edit(int $id): View
    {
        $clasificacion = Clasificacion::findOrFail($id);
        $lotes = Lote::with(['productor', 'tipoMaiz'])->orderByDesc('fecha_recepcion')->get();

        return view('clasificaciones.form', compact('clasificacion', 'lotes'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $clasificacion = Clasificacion::findOrFail($id);

        $data = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'categoria' => 'required|in:primera,segunda,desechos',
            'porcentaje_primera' => 'required|numeric|min:0|max:100',
            'porcentaje_segunda' => 'required|numeric|min:0|max:100',
            'porcentaje_desechos' => 'required|numeric|min:0|max:100',
            'observaciones' => 'nullable|string',
        ]);

        $data['usuario_id'] = Auth::id();

        $clasificacion->update($data);

        return redirect()->route('clasificaciones.index')->with('success', 'Clasificación actualizada correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $clasificacion = Clasificacion::findOrFail($id);
        $clasificacion->delete();

        return redirect()->route('clasificaciones.index')->with('success', 'Clasificación eliminada.');
    }
}
