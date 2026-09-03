<?php

namespace App\Http\Controllers;

use App\Models\TipoMaiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TipoMaizController extends Controller
{
    public function index(): View
    {
        $tipos = TipoMaiz::orderBy('nombre')->paginate(10);

        return view('tipos_maiz.index', compact('tipos'));
    }

    public function create(): View
    {
        return view('tipos_maiz.form', ['tipo' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|string|max:50',
        ]);

        TipoMaiz::create($data);

        return redirect()->route('tipos-maiz.index')->with('success', 'Tipo de maíz registrado correctamente.');
    }

    public function edit(int $id): View
    {
        $tipo = TipoMaiz::findOrFail($id);

        return view('tipos_maiz.form', compact('tipo'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $tipo = TipoMaiz::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|string|max:50',
        ]);

        $tipo->update($data);

        return redirect()->route('tipos-maiz.index')->with('success', 'Tipo de maíz actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $tipo = TipoMaiz::findOrFail($id);
        $tipo->delete();

        return redirect()->route('tipos-maiz.index')->with('success', 'Tipo de maíz eliminado.');
    }
}
