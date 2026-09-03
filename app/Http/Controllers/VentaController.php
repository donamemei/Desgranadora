<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function index(): View
    {
        $ventas = Venta::with('lote.productor', 'lote.tipoMaiz')
            ->orderByDesc('fecha_venta')
            ->paginate(10);
        $totalVendido = Venta::sum('total');
        $kilosVendidos = Venta::sum('cantidad_kg');

        return view('ventas.index', compact('ventas', 'totalVendido', 'kilosVendidos'));
    }

    public function create(): View
    {
        $lotes = Lote::with(['productor', 'tipoMaiz'])
            ->whereIn('estado', ['procesado', 'pendiente'])
            ->orderByDesc('fecha_recepcion')
            ->get();

        return view('ventas.form', compact('lotes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        Venta::create($data + ['total' => $data['cantidad_kg'] * $data['precio_kg']]);

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function edit(int $id): View
    {
        $venta = Venta::findOrFail($id);
        $lotes = Lote::with(['productor', 'tipoMaiz'])->orderByDesc('fecha_recepcion')->get();

        return view('ventas.form', compact('venta', 'lotes'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $venta = Venta::findOrFail($id);
        $data = $this->validatedData($request);
        $venta->update($data + ['total' => $data['cantidad_kg'] * $data['precio_kg']]);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Venta::findOrFail($id)->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'fecha_venta' => 'required|date',
            'comprador' => 'required|string|max:120',
            'cantidad_kg' => 'required|numeric|min:0.01',
            'precio_kg' => 'required|numeric|min:0',
            'metodo_pago' => 'nullable|in:efectivo,transferencia,credito',
            'observaciones' => 'nullable|string|max:1000',
        ], [
            'lote_id.required' => 'Selecciona el lote vendido.',
            'fecha_venta.required' => 'La fecha de venta es obligatoria.',
            'comprador.required' => 'Indica el nombre del comprador.',
            'cantidad_kg.min' => 'La cantidad debe ser mayor que cero.',
            'precio_kg.min' => 'El precio no puede ser negativo.',
        ]);
    }
}
