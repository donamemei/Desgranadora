<?php

namespace App\Http\Controllers;

use App\Models\Productor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductorController extends Controller
{
    public function index(): View
    {
        $productores = Productor::orderBy('nombre')->paginate(10);

        return view('productores.index', compact('productores'));
    }

    public function create(): View
    {
        return view('productores.form', ['productor' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:productores,cedula',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'municipio' => 'required|string|max:100',
        ]);

        Productor::create($data);

        return redirect()->route('productores.index')->with('success', 'Productor registrado correctamente.');
    }

    public function edit(int $id): View
    {
        $productor = Productor::findOrFail($id);

        return view('productores.form', compact('productor'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $productor = Productor::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:productores,cedula,' . $id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'municipio' => 'required|string|max:100',
        ]);

        $productor->update($data);

        return redirect()->route('productores.index')->with('success', 'Productor actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $productor = Productor::findOrFail($id);
        $productor->delete();

        return redirect()->route('productores.index')->with('success', 'Productor eliminado.');
    }
}
