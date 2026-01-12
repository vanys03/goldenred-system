<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Paquete;

class PaquetesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Ver paquetes')->only(['index', 'show']);
        $this->middleware('permission:Crear paquetes')->only(['create', 'store']);
        $this->middleware('permission:Editar paquetes')->only(['edit', 'update']);
        $this->middleware('permission:Eliminar paquetes')->only('destroy');
    }

    public function index()
    {
        $paquetes = Paquete::all();
        return view('paquetes.index', compact('paquetes'));
    }

    public function create()
    {
        return view('paquetes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:paquetes,nombre',
            'precio' => 'required|numeric|min:0',
            
        ]);

        Paquete::create($request->all());

        return redirect()->route('paquetes.index')->with('success', 'Paquete creado exitosamente.');
    }

    public function edit($id)
    {
        $paquete = Paquete::findOrFail($id);
        return view('paquetes.edit', compact('paquete'));
    }

    public function update(Request $request, $id)
    {
        $paquete = Paquete::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100|unique:paquetes,nombre,' . $id,
            'precio' => 'required|numeric|min:0',
        ]);

        $paquete->update($request->all());

        return redirect()->route('paquetes.index')->with('success', 'Paquete actualizado correctamente.');
    }

    public function destroy($id)
    {
        $paquete = Paquete::findOrFail($id);

        $clientesConPaquete = \DB::table('clientes')
            ->where('paquete_id', $paquete->id)
            ->count();

        if ($clientesConPaquete > 0) {
            return redirect()->route('paquetes.index')->with('error', 'No puedes eliminar un paquete asignado a clientes.');
        }

        $paquete->delete();

        return redirect()->route('paquetes.index')->with('success', 'Paquete eliminado correctamente.');
    }
}
