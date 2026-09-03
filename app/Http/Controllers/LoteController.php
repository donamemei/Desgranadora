<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Productor;
use App\Models\TipoMaiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoteController extends Controller
{
    public function index(): View
    {
        $lotes = Lote::with(['productor', 'tipoMaiz', 'ultimaClasificacion'])->orderByDesc('fecha_recepcion')->paginate(10);

        return view('lotes.index', compact('lotes'));
    }

    public function create(): View
    {
        $productores = Productor::orderBy('nombre')->get();
        $tipos = TipoMaiz::orderBy('nombre')->get();

        return view('lotes.form', compact('productores', 'tipos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'productor_id' => 'required|exists:productores,id',
            'tipo_maiz_id' => 'required|exists:tipos_maiz,id',
            'sesion_id' => 'nullable|string|max:50',
            'fecha_recepcion' => 'required|date',
            'cantidad_kg' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'estado' => 'nullable|string|max:30',
        ]);

        Lote::create($data);

        return redirect()->route('lotes.index')->with('success', 'Lote registrado correctamente.');
    }

    public function edit(int $id): View
    {
        $lote = Lote::findOrFail($id);
        $productores = Productor::orderBy('nombre')->get();
        $tipos = TipoMaiz::orderBy('nombre')->get();

        return view('lotes.form', compact('lote', 'productores', 'tipos'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $lote = Lote::findOrFail($id);

        $data = $request->validate([
            'productor_id' => 'required|exists:productores,id',
            'tipo_maiz_id' => 'required|exists:tipos_maiz,id',
            'sesion_id' => 'nullable|string|max:50',
            'fecha_recepcion' => 'required|date',
            'cantidad_kg' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'estado' => 'nullable|string|max:30',
        ]);

        $lote->update($data);

        return redirect()->route('lotes.index')->with('success', 'Lote actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $lote = Lote::findOrFail($id);
        $lote->delete();

        return redirect()->route('lotes.index')->with('success', 'Lote eliminado.');
    }
}
