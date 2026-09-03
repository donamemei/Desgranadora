<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Lote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertaController extends Controller
{
    public function index(): View
    {
        $alertas = Alerta::with('lote.productor', 'lote.tipoMaiz')->orderByDesc('created_at')->paginate(10);

        return view('alertas.index', compact('alertas'));
    }

    public function create(): View
    {
        $lotes = Lote::with(['productor', 'tipoMaiz'])->orderByDesc('fecha_recepcion')->get();

        return view('alertas.form', compact('lotes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'tipo_alerta' => 'required|string|max:50',
            'mensaje' => 'required|string',
            'nivel' => 'required|in:baja,media,alta',
            'leida' => 'nullable|boolean',
        ]);

        Alerta::create($data);

        return redirect()->route('alertas.index')->with('success', 'Alerta registrada correctamente.');
    }

    public function edit(int $id): View
    {
        $alerta = Alerta::findOrFail($id);
        $lotes = Lote::with(['productor', 'tipoMaiz'])->orderByDesc('fecha_recepcion')->get();

        return view('alertas.form', compact('alerta', 'lotes'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $alerta = Alerta::findOrFail($id);

        $data = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'tipo_alerta' => 'required|string|max:50',
            'mensaje' => 'required|string',
            'nivel' => 'required|in:baja,media,alta',
            'leida' => 'nullable|boolean',
        ]);

        $alerta->update($data);

        return redirect()->route('alertas.index')->with('success', 'Alerta actualizada correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $alerta = Alerta::findOrFail($id);
        $alerta->delete();

        return redirect()->route('alertas.index')->with('success', 'Alerta eliminada.');
    }
}
