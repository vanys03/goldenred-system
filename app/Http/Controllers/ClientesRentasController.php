<?php

namespace App\Http\Controllers;

use App\Models\ClienteRenta;
use Illuminate\Http\Request;

class ClientesRentasController extends Controller
{
    public function index()
    {
        $clientes = ClienteRenta::all();
        return view('clientes_rentas.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono1' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'dia_pago' => 'nullable|integer|min:1|max:31',
            'precio' => 'nullable|numeric|min:0',
        ]);

        ClienteRenta::create($validated);

        return redirect()->route('clientes-rentas.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show($id)
    {
        $cliente = ClienteRenta::findOrFail($id);
        return view('clientes_rentas.show', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono1' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'dia_pago' => 'nullable|integer|min:1|max:31',
            'precio' => 'nullable|numeric|min:0',
        ]);

        $cliente = ClienteRenta::findOrFail($id);
        $cliente->update($validated);

        return redirect()->route('clientes-rentas.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $cliente = ClienteRenta::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes-rentas.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('q');

        $clientes = ClienteRenta::where('nombre', 'like', "%{$query}%")
            ->orWhere('telefono1', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($clientes);
    }
}
